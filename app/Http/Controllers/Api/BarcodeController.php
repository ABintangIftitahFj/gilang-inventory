<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product; // Pastikan model Product di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarcodeController extends Controller
{
    /**
     * Check if a barcode exists in the database.
     * Accessible at /api/check-barcode
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid barcode format.',
                'errors' => $validator->errors()
            ], 400); // Bad Request
        }

        $barcode = $request->input('barcode');
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'status' => 'exists',
                'message' => 'Barcode sudah ada di database.',
                'data' => $product // Opsional: kirim data produk jika ditemukan
            ]);
        } else {
            return response()->json([
                'success' => true,
                'status' => 'not_exists',
                'message' => 'Barcode belum ada di database.'
            ]);
        }
    }
}