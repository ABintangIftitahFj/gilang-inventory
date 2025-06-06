<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class ValidateInventoryData
{
    /**
     * Handle an incoming request.
     *
     * This middleware validates inventory data before processing the request.
     * It can check for required fields, data integrity, or business rules.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply validation for write operations (POST, PUT, PATCH)
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $errors = [];

            // For product data validation
            if ($request->is('*/products*') || $request->is('*/inventory/scan*')) {
                // Validate barcode format if present
                if ($request->has('barcode') && !$this->isValidBarcode($request->barcode)) {
                    $errors[] = 'Invalid barcode format.';
                }

                // Validate measurements if present
                if ($request->has('panjang') && ($request->panjang <= 0)) {
                    $errors[] = 'Length (panjang) must be a positive number.';
                }

                if ($request->has('berat') && ($request->berat <= 0)) {
                    $errors[] = 'Weight (berat) must be a positive number.';
                }

                if ($request->has('lebar') && ($request->lebar <= 0)) {
                    $errors[] = 'Width (lebar) must be a positive number.';
                }
            }

            // For transaction validation
            if ($request->is('*/transactions*')) {
                // Validate quantity must be positive
                if ($request->has('quantity') && ($request->quantity <= 0)) {
                    $errors[] = 'Quantity must be a positive number.';
                }

                // Validate transaction_type
                if ($request->has('transaction_type') &&
                        !in_array($request->transaction_type, ['IN', 'OUT'])) {
                    $errors[] = 'Transaction type must be either IN or OUT.';
                }
            }

            // If validation fails, return error response
            if (count($errors) > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], 422);
            }
        }

        return $next($request);
    }

    /**
     * Validate barcode format.
     * This is a placeholder validation logic.
     *
     * @param string $barcode
     * @return bool
     */
    private function isValidBarcode($barcode): bool
    {
        // Example barcode validation - customize based on your barcode format
        // This example checks if barcode is at least 8 characters long and contains only alphanumeric
        return (strlen($barcode) >= 8 && preg_match('/^[a-zA-Z0-9]+$/', $barcode));
    }
}
