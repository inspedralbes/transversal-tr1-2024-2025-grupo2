<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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


Route::post('/orderApi', [OrderApiController::class, 'store'])->name('orderApi');
Route::get('/success', function (Request $request) {
    $dataSession = json_decode($request->get("data"), true);
    
    if ($dataSession) {
        $response = Http::post(route('orderApi'), [
            'products' => $dataSession,  // Pasamos los productos decodificados a la API
        ]);
    } 
    
    $urlBase = env('BASE_URL');
    return redirect($urlBase . '?s=1');
})->name('success');


Route::get('/cancel', function () {
    $urlBase = env('BASE_URL');
    return redirect($urlBase . '?s=0');
})->name('cancel');

