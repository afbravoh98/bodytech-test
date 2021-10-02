<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoopingCartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}',[ProductController::class, 'destroy']);
    Route::post('/products/upload', [ProductController::class, 'import']);

    Route::get('/cart', [ShoopingCartController::class, 'index']);
    Route::post('/cart/add/{id}', [ShoopingCartController::class, 'addProduct']);
    Route::post('/cart/remove/{id}', [ShoopingCartController::class, 'removeProduct']);

    Route::post('/cart/pay', [OrderController::class, 'store']);
    Route::post('/orders/export/', [OrderController::class, 'export']);
});



