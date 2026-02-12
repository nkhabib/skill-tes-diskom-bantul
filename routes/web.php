<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/products');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index');
});
