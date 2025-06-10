<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\WalletController  as APIWalletController;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\NotificationController; 
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\Api\PasscodeController;
use App\Http\Controllers\Api\AuthMethodController;
use App\Http\Controllers\Api\BuyPropertyController;
use App\Http\Controllers\User\SecurityController;
use App\Http\Controllers\User\Wallet\WalletTransferController; 
use App\Http\Controllers\User\Wallet\WalletController;
use App\Http\Controllers\Api\PropertyController as APIPropertyController;
use App\Http\Controllers\Api\TransactionController as APITransactionController;
use App\Http\Controllers\Api\TransferPropertyController as APITransferPropertyController;
use App\Http\Controllers\User\TransferPropertyController;
use App\Http\Controllers\User\SellPropertyController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\HelpSupportController; 
use App\Http\Controllers\User\RevolutPaymentController;
use App\Http\Controllers\User\CartController;





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

// Public routes (no authentication required)
Route::post('register', [RegisterController::class, 'register']);
Route::get('/check/email', [RegisterController::class, 'checkEmail']);
Route::post('login', [LoginController::class, 'login']);
Route::post('deactivate-account', [AuthMethodController::class, 'deactivateAccount']);

 
 
 
// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
     
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::get('/buy/assets', [PropertyController::class, 'buy']);
    Route::get('/sell/assets', [SellPropertyController::class, 'index']);
    Route::post('/sell/assets/request', [SellPropertyController::class, 'sellProperty']);
    Route::get('/sell/histories', [SellPropertyController::class, 'sellPropertyHistory']);
 
    Route::get('/transfer/assets', [TransferPropertyController::class, 'index']);
    Route::post('/transfer/initiate', [TransferPropertyController::class, 'transferRecipient']);
    Route::post('/recipient/verify', [TransferPropertyController::class, 'verifyRecipient']);

    Route::get('/transfer/assets/details/{id}', [APITransferPropertyController::class, 'transferDetails']);
    Route::post('/transfer/recipient/initiate', [APITransferPropertyController::class, 'checkRecipientTransfer']);

    Route::get('/transfer/history', [TransferPropertyController::class, 'transferHistory']);
    Route::get('/{propertyMode}/confirm/{slug}', [TransferPropertyController::class, 'confirmTransfer']);
    Route::post('/transfer/confirm/{slug}/submit', [TransferPropertyController::class, 'submitConfirmation']);

 

    Route::get('/properties/{id}', [APIPropertyController::class, 'propertiesShow']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/wallet/balance', [APIWalletController::class, 'getBalance']);
    Route::post('/wallet/deduct', [APIWalletController::class, 'deductBalance']);
    Route::get('/get/assets', [DashboardController::class, 'index']);
    Route::get('/get/faqs', [DashboardController::class, 'faqs']);
  
    Route::post('/transactions', [APITransactionController::class, 'store']);
    Route::post('/buy/properties', [BuyPropertyController::class, 'walletPayment']);
 
    Route::get('/notifications', [NotificationController::class, 'index']);

 

    Route::put('/{id}/change-password', [SecurityController::class, 'changePasswordPost']);
    Route::put('/{id}/transaction/pin', [SecurityController::class, 'createTransactionPin']);
    Route::get('/{userId}/transaction/get/pin', [SecurityController::class, 'getTransactionPin']);
   
    Route::get('/get/bank', [APIWalletController::class, 'getBank']);
    Route::get('resolve/account', [WalletController::class, 'resolveAccount']);

    Route::post('create/recipient', [WalletTransferController::class, 'createRecipient']);
    Route::post('initiate/transfer', [WalletTransferController::class, 'initiateTransfer']);
    Route::get('get/wallet/transactions', [WalletController::class, 'paymentHistory']);
 
    //Referral
    Route::get('get/referral', [ReferralController::class, 'index']); 

    Route::get('/get/userProfile', [ProfileController::class, 'index']);
    Route::post('/update/profile', [ProfileController::class, 'update']);

    // AppLock
    Route::prefix('passcode')->group(function () {
        Route::get('/status', [PasscodeController::class, 'checkStatus']);
        Route::post('/set', [PasscodeController::class, 'setPasscode']);
        Route::post('/verify', [PasscodeController::class, 'verifyPasscode']);
        Route::post('/remove', [PasscodeController::class, 'removePasscode']);
    });

    Route::prefix('biometric')->group(function () {
        Route::get('/show', [AuthMethodController::class, 'show']);
        Route::put('/update', [AuthMethodController::class, 'update']);
        Route::get('/biometric-support', [AuthMethodController::class, 'checkBiometricSupport']);
    });

    Route::prefix('about')->group(function () {
        Route::get('/index', [HelpSupportController::class, 'contactSupport']);
    }); 
  
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/user-status/{id}', [DashboardController::class, 'checkStatus']);

    // Example of other protected routes
    // Route::post('/webhook/paystack', [WebhookController::class, 'handlePaystackWebhook']);
});

