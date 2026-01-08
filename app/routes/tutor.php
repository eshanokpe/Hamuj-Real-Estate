<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tutor\DashboardController as TutorDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Tutor Routes
Route::middleware(['auth', 'tutor'])->prefix('tutor')->name('tutor.')->group(function () {
    Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [TutorDashboardController::class, 'profile'])->name('profile');
    Route::get('/sessions', [TutorDashboardController::class, 'sessions'])->name('sessions');
    Route::get('/students', [TutorDashboardController::class, 'students'])->name('students');
    Route::get('/earnings', [TutorDashboardController::class, 'earnings'])->name('earnings');
    Route::get('/settings', [TutorDashboardController::class, 'settings'])->name('settings');
});