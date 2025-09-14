<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WalletController  as APIWalletController;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\User\AddPropertyController;
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
use App\Http\Controllers\User\KycController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\Wallet\BeneficiaryController;
//chattle
use Ilmedova\Chattle\app\Http\Controllers\Chat\AdminController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\CreateController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\GetMessagesController;
use Ilmedova\Chattle\app\Http\Controllers\Chat\PostMessageController;
//review
use App\Http\Controllers\User\ReviewController;

 
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


Route::post('/verify-bvn', [RegisterController::class, 'verifyBvn']);
Route::post('/verify-nin', [RegisterController::class, 'verifyNin']);

Route::post('/send-otpapi', [RegisterController::class, 'sendOTPAPI']);
Route::post('/verify-otpapi', [RegisterController::class, 'verifyOTPAPI']);

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
    Route::put('/{id}/transaction/verify_pin', [SecurityController::class, 'verifyTransactionPin']);
    Route::put('/{id}/transaction/verify_otp_pin', [SecurityController::class, 'verifyOTP']);
    Route::put('/{id}/transaction/resend-pin', [SecurityController::class, 'resendOTP']);
    Route::post('/{id}/transaction/reset-pin', [SecurityController::class, 'resetTransactionPin']);
   
   
    Route::get('/get/bank', [APIWalletController::class, 'getBank']);
    Route::get('resolve/account', [WalletController::class, 'resolveAccount']);

    Route::post('create/recipient', [WalletTransferController::class, 'createRecipient']);
    Route::post('initiate/transfer', [WalletTransferController::class, 'initiateTransfer']);
    Route::get('get/wallet/transactions', [WalletController::class, 'paymentHistory']);
    Route::get('get/daily-transfer-total', [WalletController::class, 'dailyTransferTotal']);
    //Referral
    Route::get('get/referral', [ReferralController::class, 'index']); 

    Route::get('/get/userProfile', [ProfileController::class, 'index']);
    Route::post('/update/profile', [ProfileController::class, 'update']);
    Route::get('/verify-token', [ProfileController::class, 'verifyToken']);
   
    // AppLock
    Route::prefix('passcode')->group(function () {
        Route::get('/status', [PasscodeController::class, 'checkStatus']);
        Route::post('/set', [PasscodeController::class, 'setPasscode']);
        Route::post('/verify', [PasscodeController::class, 'verifyPasscode']);
        Route::post('/remove', [PasscodeController::class, 'removePasscode']);
        Route::put('/{id}/change-passcode', [PasscodeController::class, 'changePasscode']);
        Route::post('/{id}/verify/otp', [PasscodeController::class, 'verifyPassCodeOTP']);
        Route::post('/{id}/nopasscode/verify/otp', [PasscodeController::class, 'NoPassCodeOTP']);
        Route::post('/{id}/confirm/otp', [PasscodeController::class, 'confirmPassCodeOTP']);
        Route::post('/resend-otp', [PasscodeController::class, 'resendOTP']);
    });

    Route::prefix('biometric')->group(function () {
        Route::get('/show', [AuthMethodController::class, 'show']);
        Route::put('/update', [AuthMethodController::class, 'update']); 
        Route::get('/biometric-support', [AuthMethodController::class, 'checkBiometricSupport']);
    });      

    Route::prefix('about')->group(function () {
        Route::get('/index', [HelpSupportController::class, 'contactSupport']);
    }); 
  
    Route::get('/user-status/{id}', [DashboardController::class, 'checkStatus']);

    // Example of other protected routes
    // Route::post('/webhook/paystack', [WebhookController::class, 'handlePaystackWebhook']);

    Route::prefix('chattle')->group(function () {
        Route::view('chat', 'chattle::chat'); 
        Route::post('/create-chat', [CreateController::class, 'createChat']);
        Route::post('/post-message', [PostMessageController::class, 'postMessage']);
        Route::get('/get-messages', [GetMessagesController::class, 'getMessages']);
    }); 
    Route::prefix('beneficiaries')->group(function () {
        Route::post('/', [BeneficiaryController::class, 'store']);
        Route::get('/', [BeneficiaryController::class, 'index']);
        Route::post('/delete', [BeneficiaryController::class, 'delete']);
    });
    Route::prefix('kyc')->group(function () {
        Route::post('/', [KycController::class, 'store']);
        Route::get('/', [KycController::class, 'show']);
    }); 

    Route::prefix('add_properties')->group(function () {
        Route::get('/get', [AddPropertyController::class, 'index']);
        Route::get('/{id}', [AddPropertyController::class, 'show']);
        Route::post('/upload', [AddPropertyController::class, 'upload']);
        Route::put('/{id}', [AddPropertyController::class, 'update']);
        Route::delete('/{id}', [AddPropertyController::class, 'destroy']);
    });

    //reviews
    Route::prefix('property')->group(function () {
        Route::get('/{property}/reviews', [ReviewController::class, 'index']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    });
});

 