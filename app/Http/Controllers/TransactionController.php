<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with('product')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status', 'in_stock')->get();
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'barcode' => 'required|string|exists:products,barcode',
            'transaction_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'user_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the transaction
        $transaction = Transaction::create($request->all());

        // Update product status based on transaction
        $product = Product::find($request->product_id);

        // Logic for updating product status based on transaction type
        // This is a simplified approach - you might need more complex logic
        if ($request->transaction_type == 'OUT' && $product) {
            // If all product is out of stock, change status
            // You might need to implement a way to track quantity
            $product->status = 'out_of_stock';
            $product->save();
        } elseif ($request->transaction_type == 'IN' && $product) {
            $product->status = 'in_stock';
            $product->save();
        }

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction recorded successfully.');
    }

    /**
     * Display the specified transaction.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('product');
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        return view('transactions.edit', compact('transaction', 'products'));
    }

    /**
     * Update the specified transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'barcode' => 'required|string|exists:products,barcode',
            'transaction_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'user_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the old product ID to check if product changed
        $oldProductId = $transaction->product_id;

        // Update the transaction
        $transaction->update($request->all());

        // If product changed, update both the old and new product status
        if ($oldProductId != $request->product_id) {
            // Update old product status if needed
            $oldProduct = Product::find($oldProductId);
            if ($oldProduct) {
                // Logic to update old product status
            }

            // Update new product status
            $newProduct = Product::find($request->product_id);
            if ($newProduct) {
                // Logic to update new product status based on transaction type
                if ($request->transaction_type == 'OUT') {
                    $newProduct->status = 'out_of_stock';
                } else {
                    $newProduct->status = 'in_stock';
                }
                $newProduct->save();
            }
        }
        // If just transaction type changed on same product
        elseif ($transaction->isDirty('transaction_type')) {
            $product = Product::find($request->product_id);
            if ($product) {
                if ($request->transaction_type == 'OUT') {
                    $product->status = 'out_of_stock';
                } else {
                    $product->status = 'in_stock';
                }
                $product->save();
            }
        }

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
}
