<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderApiController;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products', [ProductController::class, 'index']);

Route::get('/getProducts', [ProductController::class, 'getProducts']);

Route::get('/getCategories', [CategoryController::class, 'getCategories']);

Route::get('/getSizes', [SizeController::class, 'getSizes']);

//Stripe
Route::post('/create-payment', [PaymentController::class, 'createPayment']);

Route::get('/success', function ( Request $request) {

    $dataSession = $request->get("data");
    
    dd($dataSession);

    return redirect('http://localhost/projecte/transversal-tr1-2024-2025-grupo2_takeAway/web/?s=1');
})->name('success');

Route::get('/cancel', function () {    
    return redirect('http://localhost/projecte/transversal-tr1-2024-2025-grupo2_takeAway/web/?s=0');
})->name('cancel');

Route::post('/ordersApi', [OrderApiController::class, 'store']);
