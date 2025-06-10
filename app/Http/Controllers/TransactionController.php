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
        \Log::info('TransactionController@store called with data:', $request->all());

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'barcode' => 'required|string|exists:products,barcode',
            // Hapus validasi product_name dari request
            'transaction_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'user_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            \Log::warning('Transaction validation failed:', $validator->errors()->toArray());
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil nama produk dari database
            $product = Product::find($request->product_id);
            if (!$product) {
                throw new \Exception('Produk tidak ditemukan');
            }
            $data = $request->all();
            $data['product_name'] = $product->product_name;

            $transaction = Transaction::create($data);
            \Log::info('Transaction created successfully:', $transaction->toArray());

            // Update product status based on transaction
            $oldStatus = $product->status;
            if ($request->transaction_type == 'OUT') {
                $product->status = 'out_of_stock';
            } else {
                $product->status = 'in_stock';
            }
            $product->save();
            \Log::info('Updated product status from ' . $oldStatus . ' to ' . $product->status);
        } catch (\Exception $e) {
            \Log::error('Error creating transaction:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->back()
                ->with('error', 'Failed to create transaction: ' . $e->getMessage());
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

    /**
     * Display transaction activity log.
     *
     * @return \Illuminate\Http\Response
     */
    public function activityLog(Request $request)
    {
        $query = Transaction::with('product')->latest();

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan tipe transaksi
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        $activities = $query->paginate(50);

        return view('inventory.activity-log', compact('activities'));
    }

    /**
     * Display a listing of transactions as JSON API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex()
    {
        $transactions = Transaction::with('product')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    /**
     * Display the specified transaction as JSON API response.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow(Transaction $transaction)
    {
        $transaction->load('product');

        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
    }

    /**
     * Store a newly created transaction via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request)
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
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the transaction
        $transaction = Transaction::create($request->all());

        // Update product status based on transaction
        $product = Product::find($request->product_id);

        if ($product) {
            // Logic for updating product status based on transaction type
            if ($request->transaction_type == 'OUT') {
                $product->status = 'out_of_stock';
            } else {
                $product->status = 'in_stock';
            }
            $product->save();
        }

        $transaction->load('product');

        return response()->json([
            'success' => true,
            'message' => 'Transaction recorded successfully',
            'data' => $transaction
        ], 201);
    }

    /**
     * Get activity log for transactions as JSON API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiActivityLog()
    {
        $transactions = Transaction::latest()
            ->get()
            ->map(function ($transaction) {
                // Gunakan kolom product_name yang baru ditambahkan
                // Jika kolom itu NULL (misal untuk transaksi lama yang tidak dicatat product_name-nya),
                // baru fallback ke relasi (jika product_id tidak NULL) atau string default.
                $productName = $transaction->product_name ?? (optional($transaction->product)->product_name ?? 'Produk tidak tersedia');

                return [
                    'id' => $transaction->id,
                    'product_name' => $productName,  // Gunakan product_name dari kolom transaksi
                    'barcode' => $transaction->barcode,
                    'transaction_type' => $transaction->transaction_type,
                    'quantity' => $transaction->quantity,
                    'user_name' => $transaction->user_name,
                    'notes' => $transaction->notes,
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s')
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
}
