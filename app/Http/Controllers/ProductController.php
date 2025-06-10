<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('section.product', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('ProductController@store called with data:', $request->all());

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
            \Log::warning('Product validation failed:', $validator->errors()->toArray());
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat produk baru
            $product = Product::create($request->all());
            \Log::info('Product created successfully:', $product->toArray());

            // Buat transaksi masuk otomatis saat produk baru ditambahkan
            $transaction = $product->transactions()->create([
                'barcode' => $product->barcode,
                'product_name' => $product->product_name,
                'transaction_type' => 'IN',
                'quantity' => 1,
                'user_name' => optional(auth()->user())->name ?? 'System',
                'notes' => 'Produk baru ditambahkan'
            ]);
            \Log::info('Initial transaction created:', $transaction->toArray());
        } catch (\Exception $e) {
            \Log::error('Error in ProductController@store:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->back()
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255|unique:products,barcode,' . $product->id,
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
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product->update($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            \Log::info('Starting to delete product:', $product->toArray());

            // Create transaction first
            $transaction = new Transaction();
            $transaction->product_id = $product->id;
            $transaction->barcode = $product->barcode;
            $transaction->product_name = $product->product_name;
            $transaction->transaction_type = 'OUT';
            $transaction->quantity = 1;
            $transaction->user_name = auth()->user() ? auth()->user()->name : 'System';
            $transaction->notes = 'Produk dihapus dari sistem';

            // Save transaction
            if (!$transaction->save()) {
                throw new \Exception('Failed to create transaction');
            }

            \Log::info('Created OUT transaction for deleted product:', $transaction->toArray());

            // Delete the product after transaction is confirmed saved
            $product->delete();
            \Log::info('Product deleted successfully:', $product->toArray());

            return redirect()
                ->route('products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting product:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->back()
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    /**
     * Display inventory stock levels summary.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockLevels()
    {
        $products = Product::with('transactions')->get();

        // Calculate stock for each product based on transactions
        $products->transform(function ($product) {
            $inQuantity = $product->transactions->where('transaction_type', 'IN')->sum('quantity');
            $outQuantity = $product->transactions->where('transaction_type', 'OUT')->sum('quantity');
            $product->current_stock = $inQuantity - $outQuantity;
            return $product;
        });

        return view('inventory.stock-levels', compact('products'));
    }

    /**
     * API methods have been moved to App\Http\Controllers\Api\ProductController
     */
    // Metode checkBarcodeExistence telah dipindahkan ke BarcodeController
}
