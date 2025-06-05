<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Product routes
Route::resource('products', ProductController::class);

// Transaction routes
Route::resource('transactions', TransactionController::class);
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/scan', function () {
    return view('scan');
});

Route::get('/section/product', function () {
    return view('section.product');
})->name('section.product');
