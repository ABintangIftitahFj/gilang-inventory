<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions as JSON API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $transactions = Transaction::with('product')->get();
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
    public function show(Transaction $transaction)
    {
        return response()->json([
            'success' => true,
            'data' => $transaction->load('product')
        ]);
    }

    /**
     * Store a newly created transaction via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $transaction = Transaction::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully',
            'data' => $transaction
        ], 201);
    }

    /**
     * Get activity log for transactions as JSON API response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activityLog()
    {
        $transactions = Transaction::with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $activityData = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'barcode' => $transaction->barcode,
                'product_name' => $transaction->product ? $transaction->product->product_name : 'Unknown Product',
                'transaction_type' => $transaction->transaction_type,
                'quantity' => $transaction->quantity,
                'user_name' => $transaction->user_name,
                'notes' => $transaction->notes,
                'created_at' => $transaction->created_at->format('Y-m-d H:i:s')
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $activityData
        ]);
    }
}
