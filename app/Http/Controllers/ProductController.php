<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat produk baru
        $product = Product::create($request->all());

        // Buat transaksi masuk otomatis saat produk baru ditambahkan
        $product->transactions()->create([
            'barcode' => $product->barcode,
            'transaction_type' => 'IN',
            'quantity' => 1,
            'user_name' => optional(auth()->user())->name ?? 'System',
            'notes' => 'Produk baru ditambahkan'
        ]);

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
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    /**
     * Display inventory stock levels summary.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockLevels()
    {
        $inStock = Product::where('status', 'in_stock')->count();
        $outOfStock = Product::where('status', 'out_of_stock')->count();
        $products = Product::with('transactions')->get();

        return view('inventory.stock-levels', compact('inStock', 'outOfStock', 'products'));
    }

    /**
     * API methods have been moved to App\Http\Controllers\Api\ProductController
     */
    // Metode checkBarcodeExistence telah dipindahkan ke BarcodeController
}
