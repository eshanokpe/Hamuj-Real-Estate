 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\SettingController;


// Admin login should be OUTSIDE the admin middleware
// Admin authentication routes (no middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
      
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-action', [UserController::class, 'bulkAction'])->name('bulk-action'); // Add this
    });
    
    // Blog Management
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
        Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{blog}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');
        Route::patch('/{blog}/toggle-status', [BlogController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-action', [BlogController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Event Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::patch('/{event}/toggle-status', [EventController::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/bulk-action', [EventController::class, 'bulkAction'])->name('bulk-action');
    });

    // Courses Management
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/{course}', [CourseController::class, 'show'])->name('show');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
        Route::patch('/{course}/toggle-status', [CourseController::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{course}/toggle-featured', [CourseController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::patch('/{course}/toggle-popular', [CourseController::class, 'togglePopular'])->name('toggle-popular');
        Route::post('/bulk-action', [CourseController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Member Management
    // Route::prefix('members')->name('members.')->group(function () {
    //     Route::get('/', [MemberController::class, 'index'])->name('index');
    //     Route::get('/{member}', [MemberController::class, 'show'])->name('show');
    //     Route::patch('/{member}/approve', [MemberController::class, 'approve'])->name('approve');
    //     Route::patch('/{member}/reject', [MemberController::class, 'reject'])->name('reject');
    // });
    
    
    
    // Settings
    // Route::prefix('settings')->name('settings.')->group(function () {
    //     Route::get('/', [SettingController::class, 'index'])->name('index');
    //     Route::put('/', [SettingController::class, 'update'])->name('update');
    // });
});