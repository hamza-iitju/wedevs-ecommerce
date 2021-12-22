<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WebController;
use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\API\Admin\OrderController;
use App\Http\Controllers\API\Customer\Auth\RegisterController;
use App\Http\Controllers\API\Customer\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Customer api
Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/user', [LoginController::class, 'user'])->middleware('auth:sanctum');
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
});

// Checkout api
Route::post('/checkout', [WebController::class, 'checkout']);

// prodyct api
Route::prefix('products')->name('products.')->group(function(){
    Route::get('/view', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::get('/search/{name}', [ProductController::class, 'search']);
    Route::get('/search', [ProductController::class, 'get_searched_products']);
    Route::get('/details/{id}', [ProductController::class, 'get_product']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
