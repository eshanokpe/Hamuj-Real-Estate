<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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
require __DIR__.'/admin.php';

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/membership', [FrontendController::class, 'membership'])->name('membership');
Route::get('/about-us', [FrontendController::class, 'aboutus'])->name('about-us');
Route::get('/events', [FrontendController::class, 'event'])->name('events.index');
Route::get('/events/{slug}', [FrontendController::class, 'show'])->name('events.show');

Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-details', [FrontendController::class, 'blogDetails'])->name('blog-details');
Route::get('/services', [FrontendController::class, 'services'])->name('services');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/our-structure', [FrontendController::class, 'structure'])->name('structure');
Route::get('/igrcfp', [FrontendController::class, 'igrcfp'])->name('igrcfp');

Route::get('/get-involved', [FrontendController::class, 'getInvolved'])->name('get-involved');

// Route::middleware(['auth', 'learner'])->prefix('learner')->name('learner.')->group(function () {
//     Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
// });
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
  

Route::get('/training-calender', [FrontendController::class, 'trainingCalender'])->name('training-calender');
 
Route::get('/registration-success', [RegisterController::class, 'showSuccessPage'])->name('registration.success');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');


  
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::prefix('certification')->name('certifications.')->group(function () {
    Route::get('/', [CertificationController::class, 'index'])->name('index');
    Route::get('/certified-grc-financial-crime-specialist', [CertificationController::class, 'showCGFCS'])->name('cgfcs');
    Route::get('/diploma-grc-financial-crime-prevention',  [CertificationController::class, 'diplomaGRC'])->name('diploma.grc-financial-crime-prevention');
    Route::get('/cybersecurity-finance', [CertificationController::class, 'cybersecurityFinance'])->name('cybersecurity-finance');
    Route::get('/risk-analytics-monitoring', [CertificationController::class, 'monitoringRiskAnalytics'])->name('risk-analytics-monitoring');
    Route::get('/regulatory-compliance',  [CertificationController::class, 'regulatoryComplianceEngagement'])->name('regulatory-compliance');
    Route::get('/regtech-suptech', [CertificationController::class, 'regTechSupTech'])->name('regtech-suptech');
    Route::get('/insurtech-fintech-compliance', [CertificationController::class, 'insurTechFinTechCompliance'])->name('insurtech-fintech');
    Route::get('/executive-masterclasses-short-courses', [CertificationController::class, 'executiveMasterclasses'])->name('executive-masterclasses');
    
    
});

require __DIR__.'/tutor.php';
require __DIR__.'/learner.php';

