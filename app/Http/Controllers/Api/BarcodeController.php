<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;  // Import JsonResponse untuk type hinting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BarcodeController extends Controller
{
    /**
     * Check if a barcode exists in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBarcode(Request $request): JsonResponse
    {
        // Reduced logging to improve performance - only log important information
        Log::info('Barcode check for: ' . $request->input('barcode'));

        // Validasi input - simplified validation
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string|max:255',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $barcode = $request->input('barcode');

        // Cari produk berdasarkan barcode - using select to only get needed fields
        $product = Product::where('barcode', $barcode)
            ->select('id', 'product_name', 'barcode', 'status')
            ->first();

        if ($product) {
            // Jika produk ditemukan
            return response()->json([
                'success' => true,
                'status' => 'exists',
                'message' => 'Barcode sudah terdaftar di dalam database.',
                'data' => $product
            ]);  // Default 200 OK
        } else {
            // Jika produk tidak ditemukan, tetap kembalikan 200 OK
            // agar frontend dapat memproses 'status: not_exists'
            return response()->json([
                'success' => true,
                'status' => 'not_exists',
                'message' => 'Barcode belum terdaftar di dalam database.'
            ], 200);  // Explicitly return 200 OK
        }
    }
}

?>