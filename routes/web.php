<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PagesController;
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
 
  
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/{page}', [PagesController::class, 'index'])->name('home.pages');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/download', [FrontendController::class, 'download'])->name('home.download');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blog.details');
Route::post('/post/comment', [BlogController::class, 'storeComment'])->name('comments.store');

 
 
Auth::routes(); 

Route::get('/user/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/user/register/referral/{referralCode}', [RegisterController::class, 'showRegistrationForm'])->name('register.referral');

Route::post('post/register', [RegisterController::class, 'register'])->name('post.register');
Route::get('user/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('post/login', [LoginController::class, 'login'])->name('post.login');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

// Route::get('/user/register/referral/{referralCode}', [PagesController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');



Route::get('/paystack/create-customer', [WalletController::class, 'createCustomer']);
Route::get('/paystack/create-dedicated-account', [WalletController::class, 'createDedicatedAccount']);

Route::prefix('home')->name('home.')->group(function () {
    Route::get('/properties/{slug}', [HomesController::class, 'showProperties'])->name('properties.show');
 

});