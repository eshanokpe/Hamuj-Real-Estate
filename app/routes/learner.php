<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Learner\DashboardController as LearnerDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;

// Learner Routes. 
Route::middleware(['auth', 'learner'])->prefix('learner')->name('learner.')->group(function () {
    Route::get('/dashboard', [LearnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [LearnerDashboardController::class, 'profile'])->name('profile');
    Route::get('/sessions', [LearnerDashboardController::class, 'sessions'])->name('sessions');
    Route::get('/sessions/book', [LearnerDashboardController::class, 'bookSession'])->name('sessions.book');
    Route::get('/tutors', [LearnerDashboardController::class, 'tutors'])->name('tutors');
    Route::get('/courses', [LearnerDashboardController::class, 'courses'])->name('courses');
    Route::get('/courses/{course:slug}', [LearnerDashboardController::class, 'show'])->name('courses.show');
    Route::get('/progress', [LearnerDashboardController::class, 'progress'])->name('progress');
    Route::get('/settings', [LearnerDashboardController::class, 'settings'])->name('settings');
    Route::get('/messages', [LearnerDashboardController::class, 'messages'])->name('messages');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Instead of the controller route, use this:
    // Route::get('/cart', \App\Livewire\CartPage::class)->name('cart.index');

    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

 

// Profile routes
Route::middleware(['auth'])->group(function () { 
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update');
    Route::delete('/profile/picture', [ProfileController::class, 'removePicture'])->name('profile.picture.remove');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/preferences', [ProfileController::class, 'updatePreferences'])->name('preferences.update');
}); 