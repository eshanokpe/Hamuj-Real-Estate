<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\TransferController;
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\SellPropertyController;
use App\Http\Controllers\User\TransferPropertyController;


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
    Route::get('/transaction/report', [DashboardController::class, 'transactionReport'])->name('transactions');
    
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
    Route::get('/buy', [PropertyController::class, 'buy'])->name('buy'); 
    Route::get('/offer/price/{id}', [PropertyController::class, 'offerPrice'])->name('offerPrice'); 
    Route::post('/offer/price/post', [PropertyController::class, 'offerPricePost'])->name('offerPrice.post'); 

    Route::get('/transfer', [TransferPropertyController::class, 'index'])->name('transfer');
    Route::get('/transfer/recipient', [TransferPropertyController::class, 'transferRecipient'])->name('transfer.recipient');
    Route::post('/transfer/recipient/initiate', [TransferPropertyController::class, 'checkRecipientTransfer'])->name('checkRecipient.transfer');
    Route::get('/transfer/history', [TransferPropertyController::class, 'transferHistory'])->name('transfer.history');

    Route::get('/transfer/add', [PropertyController::class, 'add'])->name('transfer.add');

    Route::post('/transfer/initiate', [TransferController::class, 'initiateTransfer'])->name('transfer.initiate');
    Route::get('/payment/balance', [TransferController::class, 'balance']);
     
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties'); 
 
    Route::get('/my-properties', [DashboardController::class, 'properties'])->name('myProperties');
    Route::get('/my-properties/{id}', [DashboardController::class, 'propertiesShow'])->name('properties.show');
 
    
    Route::get('/cart/{id}', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/sell/{id}', [CartController::class, 'sell'])->name('cart.sell.index');
    Route::get('/cart/transfer/{id}', [CartController::class, 'transfer'])->name('cart.transfer.index');

    Route::post('/pay', [PaymentController::class, 'initializePayment'])->name('payment.initiate');
    Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

    Route::get('/sell', [SellPropertyController::class, 'index'])->name('sell');
    Route::post('/sell/property', [SellPropertyController::class, 'sellProperty'])->name('sell.property');
    Route::get('/sell/property/history', [SellPropertyController::class, 'sellPropertyHistory'])->name('sell.history');
   
    
    Route::resource('profile', ProfileController::class);
    

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

