<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', function (){
        return redirect()->route('admin.auth.login');
    });

    /*authentication*/
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [LoginController::class, 'login'])->name('login');
        Route::post('login', [LoginController::class, 'submit']);
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });

    /*authenticated*/
    Route::group(['middleware' => ['admin']], function () {

        //dashboard routes
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');//previous dashboard route
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            Route::get('/', [DashboardController::class, 'dashboard'])->name('index');
        });

        // Customer route
        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::get('list', [CustomerController::class, 'customer_list'])->name('list');
            Route::post('status-update', [CustomerController::class, 'status_update'])->name('status-update');
        });

        // Product route
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('add-new', [ProductController::class, 'add_new'])->name('add-new');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('remove-image', [ProductController::class, 'remove_image'])->name('remove-image');
            Route::post('status-update', [ProductController::class, 'status_update'])->name('status-update');
            Route::get('list/{type}', [ProductController::class, 'list'])->name('list');
            Route::get('products-search', [ProductController::class, 'products_search'])->name('products-search');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('delete');
            Route::get('view/{id}', [ProductController::class, 'view'])->name('view');
        });

        // Order route
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('list/{status}', [OrderController::class, 'list'])->name('list');
            Route::get('details/{id}', [OrderController::class, 'details'])->name('details');
            Route::post('status', [OrderController::class, 'status'])->name('status');
            Route::post('payment-status', [OrderController::class, 'payment_status'])->name('payment-status');
            Route::get('generate-invoice/{id}', [OrderController::class, 'generate_invoice'])->name('generate-invoice');
        });
    });
});
