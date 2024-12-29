<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VisionMissionController;
// use App\Http\Controllers\Admin\SociallinkController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;

 
Route::redirect('/admin/dashboard', '/admin');
// Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.index');

Route::prefix('admin')->group(function () { 
    Route::get('/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
    Route::post('/manage/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/manage/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('auth.admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');

        Route::post('/settings/update-password', [AdminLoginController::class, 'updatePassword'])->name('admin.password.update');
        Route::get('/settings/show-password', [AdminLoginController::class, 'showChangePasswordForm'])->name('admin.show.password');
        // Menu
     
        Route::get('/menu/create', [MenuController::class, 'creat'])->name('admin.menu.create');
        Route::get('/manage/menu/index', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::post('/menu', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('/menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::get('/menu/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
        //Why choose us 
        Route::get('/settings/content', [SettingsController::class, 'WhyChooseUs'])->name('admin.settings.content');
        Route::post('/settings/store/why-choose-us', [SettingsController::class, 'storeWhyChooseUs'])->name('admin.settings.store_why_choose_us');
        Route::put('/settings/update/why-choose-us/{id}', [SettingsController::class, 'updateWhyChooseUs'])->name('admin.settings.update_why_choose_us');
        
        Route::get('/settings/index', [SettingsController::class, 'index'])->name('admin.settings.index');
        
        //About us
        Route::get('/settings/about-us', [SettingsController::class, 'getAboutUs'])->name('admin.settings.aboutUs');
        Route::post('/settings/store/about-us', [SettingsController::class, 'storeAboutUs'])->name('admin.settings.storeAboutus');
        Route::put('/settings/update/about-us/{id}', [SettingsController::class, 'updateAboutUs'])->name('admin.settings.updateAboutus');
        //visionMission
        Route::get('/settings/vision-mission', [SettingsController::class, 'indexVisionMission'])->name('admin.visionMission.index');
        Route::post('/settings/vision-mission/store', [SettingsController::class, 'storeVisionMission'])->name('admin.visionMission.store');
        Route::put('/settings/vision-mission/update/{id}', [SettingsController::class, 'updateVisionMission'])->name('admin.visionMission.update');
      
        // Blog Routes
        Route::prefix('post')->group(function () {
            Route::get('index', [BlogController::class, 'index'])->name('admin.post.index');
            Route::get('create', [BlogController::class, 'create'])->name('admin.post.create');
            Route::post('store', [BlogController::class, 'store'])->name('admin.post.store');
            Route::get('{id}/edit', [BlogController::class, 'edit'])->name('admin.post.edit');
            Route::put('{id}', [BlogController::class, 'update'])->name('admin.post.update');
            Route::get('{id}', [BlogController::class, 'destroy'])->name('admin.post.destroy');
        });

        //Property
        Route::name('admin.')->group(function () {
            Route::resource('properties', AdminPropertyController::class);
            Route::get('properties/{id}/evaluate', [AdminPropertyController::class, 'evaluate'])
            ->name('properties.evaluate');
            Route::post('properties/valuation/store', [AdminPropertyController::class, 'valuationStore'])
            ->name('properties.valuation');
            Route::get('properties/valuation/edit', [AdminPropertyController::class, 'valuationEdit'])
            ->name('properties.valuation.edit');
        });
       

        //Office Hours 
        Route::post('/settings/store/office-hours', [SettingsController::class, 'storeOfficeHours'])->name('admin.office-hours.store');
        Route::put('/settings/update/office-hours/{id}', [SettingsController::class, 'updatestoreOfficeHours'])->name('admin.office-hours.update');
        Route::post('/settings/store/office-hours', [SettingsController::class, 'storeOfficeHours'])->name('admin.office-hours.store');
         
        //Contact Us 
        Route::get('/settings/contact', [SettingsController::class, 'indexContact'])->name('admin.contact.index');
        Route::post('/settings/store/contact', [SettingsController::class, 'storeContact'])->name('admin.contact.store');
        Route::put('/settings/update/contact/{id}', [SettingsController::class, 'updateContact'])->name('admin.contact.update');
        //Terms
        Route::get('/settings/terms', [SettingsController::class, 'indexTerms'])->name('admin.terms.index');
        Route::post('/settings/store/terms', [SettingsController::class, 'storeTerms'])->name('admin.terms.store');
        Route::put('/settings/update/terms/{id}', [SettingsController::class, 'updateTerms'])->name('admin.terms.update');
        //Privacy
        Route::get('/settings/privacypolicy', [SettingsController::class, 'indexPrivacyPolicy'])->name('admin.privacyPolicy.index');
        Route::post('/settings/store/privacypolicy', [SettingsController::class, 'storePrivacyPolicy'])->name('admin.privacy.store');
        Route::put('/settings/update/privacypolicy/{id}', [SettingsController::class, 'updatePrivacyPolicy'])->name('admin.privacy.update');
        
        //Terms Conditions
        // Route::get('/terms/conditions', [TermsConditionController::class, 'index'])->name('admin.termsCondition.index');
        // Route::post('/terms/conditions/store/', [TermsConditionController::class, 'store'])->name('admin.termsCondition.store');
        // Route::put('/terms/conditions/update/{id}', [TermsConditionController::class, 'update'])->name('admin.termsCondition.update');
      
        //Faqs
        Route::get('faq/index', [FAQController::class, 'index'])->name('admin.faq.index');
        Route::get('faq/create', [FAQController::class, 'create'])->name('admin.faq.create');
        Route::post('post/faq', [FAQController::class, 'store'])->name('admin.faq.store');
        Route::get('faq/{id}/edit', [FAQController::class, 'edit'])->name('admin.faq.edit');
        Route::put('faq/{id}', [FAQController::class, 'update'])->name('admin.faq.update');
        Route::get('faq/{id}', [FAQController::class, 'destroy'])->name('admin.faq.destroy');
       
       
        
    });  
}); 
