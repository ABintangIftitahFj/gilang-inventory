<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/scan', function () {
    return view('scan');
});

Route::get('/section/product', function () {
    return view('section.product');
})->name('section.product');
// web.php

Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
