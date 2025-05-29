<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\HelpSupportController;
use App\Http\Controllers\User\WebhookController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\TransferController; 
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\User\ReferralController; 
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\SellPropertyController;
use App\Http\Controllers\User\SecurityController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\TransferPropertyController;
use App\Http\Controllers\User\Wallet\WalletController;
use App\Http\Controllers\User\Wallet\WalletTransferController;
 

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

    Route::post('/revolut-payment/make', [OrderController::class, 'makePayment'])->name('revolutPayment.make');
     
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transactions', [DashboardController::class, 'transactionReport'])->name('transactions');

    Route::get('/transaction/report', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transaction/show/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    
    
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
     
    Route::get('/buy', [PropertyController::class, 'buy'])->name('buy');   
    Route::get('/offer/price/{id}', [PropertyController::class, 'offerPrice'])->name('offerPrice'); 
    Route::post('/offer/price/post', [PropertyController::class, 'offerPricePost'])->name('offerPrice.post'); 
   
    Route::get('/transfer', [TransferPropertyController::class, 'index'])->name('transfer');
    
    Route::get('/transfer/recipient', [TransferPropertyController::class, 'transferRecipient'])->name('transfer.recipient');
    Route::post('/transfer/recipient/initiate', [TransferPropertyController::class, 'checkRecipientTransfer'])->name('checkRecipient.transfer');
     
    Route::post('/transfer/verify/recipient', [TransferPropertyController::class, 'verifyRecipient'])->name('transfer.checkRecipient');
    
    Route::get('/transfer/verify/recipient', function () { 
        return redirect()->back();
    }); 
    
    Route::get('/transfer/history', [TransferPropertyController::class, 'transferHistory'])->name('transfer.history');

    Route::get('/transfer/add', [PropertyController::class, 'add'])->name('transfer.add');

    Route::post('/transfer/initiate', [TransferController::class, 'initiateTransfer'])->name('transfer.initiate');
    Route::get('/payment/balance', [TransferController::class, 'balance']);
     
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties'); 
    Route::get('api/properties', [PropertyController::class, 'indexAPI']); 
  
    Route::get('/my-properties', [DashboardController::class, 'properties'])->name('myProperties');
 
    Route::get('/my-properties/{id}', [DashboardController::class, 'propertiesShow'])->name('properties.show');
     
    // For React frontend
    Route::get('/cart/buy/{slug}', [CartController::class, 'index'])->name('cart.buy');
    Route::get('properties-details/{slug}', [CartController::class, 'buy']);
   
  

    Route::get('/cart/sell/{id}', [CartController::class, 'sell'])->name('cart.sell.index');  
    Route::get('/cart/transfer/{id}', [CartController::class, 'transfer'])->name('cart.transfer.index');
    Route::post('/payment/initiate', [PaymentController::class, 'initializePayment'])->name('payment.initiate'); 
    Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

    Route::get('/payment/failed', [RevolutPaymentController::class, 'failed'])->name('payment.failed');
   
    
    Route::get('/purchases', [DashboardController::class, 'purchases'])->name('purchases');
    Route::get('/sell', [SellPropertyController::class, 'index'])->name('sell');
    Route::post('/sell/property', [SellPropertyController::class, 'sellProperty'])->name('sell.property');
    Route::get('/sell/property/history', [SellPropertyController::class, 'sellPropertyHistory'])->name('sell.history');
   
    Route::resource('profile', ProfileController::class);
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/count', [NotificationController::class, 'count'])
    ->name('notifications.count');
    Route::get('/notifications/{notification}/redirect', [NotificationController::class, 'redirect'])
    ->name('notifications.redirect');
  
    // Route::get('/{propertyMode}/confirm/{slug}', [TransferPropertyController::class, 'confirmTransfer'])->name('transfer.property.confirm');
    Route::post('/transfer/confirm/{slug}/submit', [TransferPropertyController::class, 'submitConfirmation'])->name('confirm.transfer.submit');

    Route::get('/view/transfer/property/{recipentId}', [TransferPropertyController::class, 'viewTransferProperty'])->name('view.transfer.property');


    Route::get('properties/{id}/valuation', [PropertyController::class, 'valuation'])->name('properties.valuation');
    Route::get('properties/{id}/history', [PropertyController::class, 'propertyHistory'])->name('properties.history');
    Route::get('referral/index', [ReferralController::class, 'index'])->name('referral.index');
    Route::get('referral/show', [ReferralController::class, 'show'])->name('referrals.show');
    
    Route::get('/wallet/index', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('wallet/top-up', [WalletController::class, 'topUp'])->name('wallet.topUp');
    Route::get('wallet/with-draw', [WalletController::class, 'withDraw'])->name('wallet.withdraw');
    Route::get('wallet/transfer-post', [WalletController::class, 'transferPost'])->name('wallet.transferPost');
    
    Route::get('resolve-account', [WalletController::class, 'resolveAccount'])->name('wallet.resolve.account');
 
    Route::post('create-recipient', [WalletTransferController::class, 'createRecipient'])->name('wallet.createRecipient');
    Route::post('initiate-transfer', [WalletTransferController::class, 'initiateTransfer'])->name('wallet.initiateTransfer');
    Route::post('verifyOtp', [WalletTransferController::class, 'verifyOtp'])->name('wallet.verifyOtp');
  
    Route::get('payment/history', [WalletController::class, 'paymentHistory'])->name('payment.history');

    
    Route::get('/help-support', [HelpSupportController::class, 'index'])->name('support');
    Route::get('/help-center', [HelpSupportController::class, 'helpCenter'])->name('help.center');
    Route::get('/contact-support', [HelpSupportController::class, 'contactSupport'])->name('contact.support');
    Route::get('/social-media', [HelpSupportController::class, 'socialMedia'])->name('social.media');
 
    Route::get('/security', [SecurityController::class, 'index'])->name('login.security');
    Route::get('/change-password', [SecurityController::class, 'changePassword'])->name('change.password');
    Route::put('/{id}/change-password', [SecurityController::class, 'changePasswordPost'])->name('change.password.post');
    Route::get('/transaction-pin', [SecurityController::class, 'transactionPin'])->name('transaction.pin');
    Route::put('/{id}/transaction-create', [SecurityController::class, 'createTransactionPin'])->name('transaction.create.pin');

    Route::post('/user/toggle-hide-balance', [DashboardController::class, 'toggleHideBalance'])->name('toggle.hide.balance');

});

Route::prefix('user')->name('user.')->group(function () {
   
    Route::post('/webhook/paystack', [WebhookController::class, 'handlePaystackWebhook']);
    Route::post('/webhook/transfer', [WebhookController::class, 'handleTransferWebhook']);
    Route::post('/webhook', [WebhookController::class, 'handleRevolutWebhook']);

});
Route::post('/webhook', [WebhookController::class, 'handleRevolutWebhook']);

Route::get('user/config', function () {
    return response()->json([ 
        'revolutPublicKey' => config('services.revolut.public_key'),
    ]);
});
Route::post('user/api/orders', [OrderController::class, 'createOrder']); 
Route::get('user/success/', [OrderController::class, 'success']);
