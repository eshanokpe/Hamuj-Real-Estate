<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
     
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaction', [DashboardController::class, 'transactions'])->name('transactions');
    
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
    Route::get('/buy', [PropertyController::class, 'buy'])->name('buy'); 
    Route::get('/sell', [PropertyController::class, 'sell'])->name('sell');
    Route::get('/transfer', [PropertyController::class, 'transfer'])->name('transfer');
    
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');

    Route::get('/my-properties', [DashboardController::class, 'properties'])->name('myProperties');
    Route::get('/my-properties/{id}', [DashboardController::class, 'propertiesShow'])->name('properties.show');

    Route::post('/pay', [PaymentController::class, 'initializePayment'])->name('payment.initiate');
    Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

    Route::get('/cart/{id}', [CartController::class, 'index'])->name('cart.index');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

