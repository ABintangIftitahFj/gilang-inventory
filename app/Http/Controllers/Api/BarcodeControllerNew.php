<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;  // Import JsonResponse untuk type hinting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// PENTING: Namespace ini mengharuskan file berada di folder app/Http/Controllers/Api/

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
        // Log request untuk debugging
        Log::info('BarcodeController::checkBarcode endpoint hit.', [
            'payload' => $request->all(),
            'url' => $request->fullUrl(),
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string|max:255',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);  // 422 Unprocessable Entity lebih cocok untuk error validasi
        }

        $barcode = $request->input('barcode');

        // Cari produk berdasarkan barcode
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            // Jika produk ditemukan
            return response()->json([
                'success' => true,
                'status' => 'exists',
                'message' => 'Barcode sudah terdaftar di dalam database.',
                'data' => $product
            ]);
        } else {
            // Jika produk tidak ditemukan
            return response()->json([
                'success' => true,
                'status' => 'not_exists',
                'message' => 'Barcode belum terdaftar di dalam database.'
            ], 404);  // Kembalikan status 404 Not Found agar lebih semantik
        }
    }
}
