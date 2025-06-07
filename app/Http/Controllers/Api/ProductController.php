<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
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
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
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
