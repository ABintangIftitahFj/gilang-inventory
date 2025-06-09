<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction; // Make sure to import the Transaction model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of products as JSON API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Display the specified product as JSON API response.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Store a newly created product via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        \Log::info('API ProductController@store called with data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'barcode' => 'required|string|unique:products,barcode|max:255',
            'panjang' => 'required|numeric',
            'berat' => 'required|numeric',
            'lebar' => 'required|numeric',
            'grade' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'date_received' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:in_stock,out_of_stock',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            \Log::warning('API Product validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the product
            $product = Product::create($request->all());
            \Log::info('API Product created successfully:', $product->toArray());

            // Create an automatic "IN" transaction for the new product
            $transaction = $product->transactions()->create([
                'barcode' => $product->barcode,
                'product_name' => $product->product_name, // <--- TAMBAHKAN INI
                'transaction_type' => 'IN',
                'quantity' => 1,
                'user_name' => optional(auth()->user())->name ?? 'System',
                'notes' => 'Produk baru ditambahkan'
            ]);
            \Log::info('API Initial transaction created:', $transaction->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product->load('transactions')
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Error in API ProductController@store:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified product via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'sometimes|required|string|max:255',
            'barcode' => 'sometimes|required|string|max:255|unique:products,barcode,' . $product->id,
            'panjang' => 'sometimes|required|numeric',
            'berat' => 'sometimes|required|numeric',
            'lebar' => 'sometimes|required|numeric',
            'grade' => 'sometimes|required|string|max:255',
            'supplier' => 'sometimes|required|string|max:255',
            'date_received' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:in_stock,out_of_stock',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified product via API.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            \Log::info('API: Starting to delete product:', $product->toArray());
            
        // Create transaction first
        $transaction = new Transaction();
        $transaction->product_id = $product->id;
        $transaction->barcode = $product->barcode;
        $transaction->product_name = $product->product_name; // <--- TAMBAHKAN INI
        $transaction->transaction_type = 'OUT';
        $transaction->quantity = 1; // Sesuaikan jika Anda ingin 0 untuk log penghapusan
        $transaction->user_name = auth()->user() ? auth()->user()->name : 'System';
        $transaction->notes = 'Produk dihapus dari sistem';
            
            // Save transaction
            if (!$transaction->save()) {
                throw new \Exception('Failed to create transaction');
            }
            
            \Log::info('API: Created OUT transaction for deleted product:', $transaction->toArray());
            
            // Delete the product after transaction is confirmed saved
            $product->delete();
            \Log::info('API: Product deleted successfully:', $product->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('API: Error deleting product:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get stock levels for products as JSON API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stockLevels()
    {
        $products = Product::with('transactions')->get();

        $stockData = $products->map(function ($product) {
            // Calculate stock level based on transactions
            $inTransactions = $product->transactions->where('transaction_type', 'IN')->sum('quantity');
            $outTransactions = $product->transactions->where('transaction_type', 'OUT')->sum('quantity');
            $stockLevel = $inTransactions - $outTransactions;

            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'barcode' => $product->barcode,
                'current_stock' => $stockLevel,
                'status' => $product->status,
                'location' => $product->location
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $stockData
        ]);
    }

    /**
     * Process barcode scan via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string|exists:products,barcode',
            'action' => 'required|in:check,in,out',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::where('barcode', $request->barcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // If just checking the product
        if ($request->action === 'check') {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }

        // If performing an inventory action (in or out)
        // In a real application, you'd create a transaction record here

        return response()->json([
            'success' => true,
            'message' => 'Barcode processed successfully',
            'data' => $product,
            'action' => $request->action
        ]);
    }
}
