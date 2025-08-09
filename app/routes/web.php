<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaceTecController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

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
require __DIR__.'/admin.php';
require __DIR__.'/user.php'; 
 
use App\Http\Controllers\SmsController;

Route::get('/create-messaging-service', [SmsController::class, 'createMessagingService']);

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/{page}', [PagesController::class, 'index'])->name('home.pages');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blog.details');
Route::post('/post/comment', [BlogController::class, 'storeComment'])->name('comments.store');

 
 
Auth::routes(); 

Route::get('/user/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('user/login', [LoginController::class, 'showLoginForm'])->name('login'); 

Route::get('/user/register/referral/{referralCode}', [RegisterController::class, 'showRegistrationForm'])->name('register.referral');

Route::post('post/register', [RegisterController::class, 'register'])->name('post.register');
Route::post('post/login', [LoginController::class, 'login'])->name('post.login');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('otp/verify/{user_id}', [VerificationController::class, 'notice'])->name('verification.notice');
Route::post('/verify/otp', [VerificationController::class, 'verifyOTP'])->name('verification.otp');

// Route::get('/user/register/referral/{referralCode}', [PagesController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

Route::post('/guest/info', [HomeController::class, 'guestInfo']); 
Route::post('/conversations/messages', [MessageController::class, 'store']); 


Route::get('/paystack/create-customer', [WalletController::class, 'createCustomer']);
Route::get('/paystack/create-dedicated-account', [WalletController::class, 'createDedicatedAccount']);

Route::prefix('home')->name('home.')->group(function () {
    Route::get('/properties/{slug}', [HomeController::class, 'showProperties'])->name('properties.show');


});

Route::post('/send-otp', [RegisterController::class, 'sendOtp'])->name('send-otp');
  
Route::post('/verify-bvn', [RegisterController::class, 'verifyBvn'])->name('verify-bvn');

Route::post('/verify-face', [RegisterController::class, 'verifyBvnFace'])->name('verify-face');

Route::post('/verify-nin', [RegisterController::class, 'verifyNin'])->name('verify-nin');

Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify-otp');

Route::post('/verify-privacy', [RegisterController::class, 'verifyOtp'])->name('privacy');


// Face Verification Routes
Route::get('app/facetac', [FaceTecController::class, 'index']);
Route::get('/face-verification', [FaceVerificationController::class, 'show'])->name('face.verification');
Route::post('/face-verification/submit', [FaceVerificationController::class, 'submit'])->name('verification.submit');

// FaceTec API Routes
Route::get('/api/facetec/session', [FaceTecController::class, 'createSession'])->name('facetec.session');
Route::post('/api/facetec/verify', [FaceTecController::class, 'verifySession'])->name('facetec.verify');

Route::get('app/identity-verification', function() {
    $file = public_path('facetec/index.html');
    if (file_exists($file)) {
        return response()->file($file);
    } 
    abort(404, 'File not found'); 
});