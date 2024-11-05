<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products', [ProductController::class, 'index']);

Route::get('/getProducts', [ProductController::class, 'getProducts']);

Route::get('/getCategories', [CategoryController::class, 'getCategories']);

Route::get('/getSizes', [SizeController::class, 'getSizes']);

//Stripe
Route::post('/create-payment',[PaymentController::class, 'createPayment']);
Route::post('/create-checkout-session', [PaymentController::class, 'createPayment']);


Route::get('/success', function() {
    return 'El pagament ha sigut correcte!';
})->name('success');

Route::get('/cancel', function() {
    return 'Payment was canceled.'; 
})->name('cancel');
