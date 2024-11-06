<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products', [ProductController::class, 'index']);

Route::get('/getProducts', [ProductController::class, 'getProducts']);

Route::get('/getCategories', [CategoryController::class, 'getCategories']);

Route::get('/getSizes', [SizeController::class, 'getSizes']);

Route::post('/ordersApi', [OrderApiController::class, 'store']);
