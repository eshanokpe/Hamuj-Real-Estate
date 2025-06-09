<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WalletTransactionController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\BuyController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VisionMissionController;
use App\Http\Controllers\Admin\SociallinkController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\PropertyHistoryController;
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
            Route::get('properties/valuation/edit/{id}', [AdminPropertyController::class, 'valuationEdit'])
            ->name('properties.valuation.edit');
            Route::put('properties/valuation/update/{id}', [AdminPropertyController::class, 'valuationUpdate'])
            ->name('properties.valuation.update');
            Route::get('properties/valuation/delete/{id}', [AdminPropertyController::class, 'valuationDelete'])
            ->name('properties.valuation.delete');

            Route::post('properties/valuation/prediction/store', [AdminPropertyController::class, 'valuationPredictionStore'])
            ->name('properties.valuation.prediction');
            Route::get('properties/valuation/prediction/edit/{id}', [AdminPropertyController::class, 'valuationPredictionEdit'])
            ->name('properties.valuation.prediction.edit');
            Route::put('properties/valuation/prediction/update/{id}', [AdminPropertyController::class, 'valuationPredictionUpdate'])
            ->name('properties.valuation.prediction.update');
            Route::get('properties/valuation/prediction/delete/{id}', [AdminPropertyController::class, 'valuationPredictionDelete'])
            ->name('properties.valuation.prediction.delete');
            
            Route::get('properties/{id}/propertyHistory', [PropertyHistoryController::class, 'index'])
            ->name('properties.propertyHistory');
            Route::post('properties/propertyHistory/store', [PropertyHistoryController::class, 'store'])->name('properties.propertyHistory.store');

            Route::get('/properties/propertyHistory/{id}/edit', [PropertyHistoryController::class, 'edit'])->name('properties.propertyHistory.edit');
            Route::get('properties/propertyHistory/delete/{id}', [PropertyHistoryController::class, 'destroy'])->name('properties.propertyHistory.delete');
            Route::put('properties/propertyHistory/update/{id}', [PropertyHistoryController::class, 'update'])->name('properties.propertyHistory.update');

            Route::get('properties/{id}/neighborhood', [AdminPropertyController::class, 'neighborhood'])
            ->name('properties.neighborhood');
            Route::post('properties/neighborhood/store', [AdminPropertyController::class, 'storeNeighborhood'])->name('properties.neighborhood.store');
            Route::get('/properties/neighborhood/{id}/edit', [AdminPropertyController::class, 'editNeighborhood'])->name('properties.neighborhood.edit');
            Route::put('/properties/neighborhood/{id}', [AdminPropertyController::class, 'updateNeighborhood'])->name('properties.neighborhood.update');

            Route::get('/properties/neighborhood/category', [AdminPropertyController::class, 'neighborhoodCategory'])->name('properties.neighborhood.category');
            Route::post('properties/neighborhood/category/store', [AdminPropertyController::class, 'neighborhoodCategoryStore'])->name('properties.neighborhood.category.store');
            Route::get('properties/neighborhood/category/edit/{id}', [AdminPropertyController::class, 'neighborhoodCategoryEdit'])->name('properties.neighborhood.category.edit');
            Route::put('properties/neighborhood/category/update/{id}', [AdminPropertyController::class, 'neighborhoodCategoryUpdate'])->name('properties.neighborhood.category.update');
            Route::delete('properties/neighborhood/category/delete/{id}', [AdminPropertyController::class, 'neighborhoodCategoryDelete'])->name('properties.neighborhood.category.delete');
            
        });
       
        // Buy Routes
        Route::name('admin.')->group(function () {
            Route::get('buy', [BuyController::class, 'index'])->name('buy.index');
            Route::get('{id}/editbuy', [BuyController::class, 'edit'])->name('buy.edit');
            Route::put('{id}/buy', [BuyController::class, 'update'])->name('buy.update');
            Route::delete('{id}/buy', [BuyController::class, 'destroy'])->name('buy.destroy');
        });
        Route::name('admin.')->group(function () {
            Route::get('transaction/index', [TransactionController::class, 'index'])->name('transaction');
        });
        
        Route::name('admin.')->group(function () {
            Route::get('wallettransaction/index', [WalletTransactionController::class, 'index'])->name('walletTransaction');
        });
        Route::name('admin.')->group(function () {
            Route::get('referral/index', [ReferralController::class, 'index'])->name('referral');
            Route::get('referral/{id}/show', [ReferralController::class, 'edit'])->name('referral.show');
            Route::put('referral/{id}/', [ReferralController::class, 'update'])->name('referral.update');
        });

        // Sell Routes
        Route::name('admin.')->group(function () {
            Route::get('sell', [SellController::class, 'index'])->name('sell.index');
            Route::get('{id}/editsell', [SellController::class, 'edit'])->name('sell.edit');
            Route::put('{id}/sell', [SellController::class, 'update'])->name('sell.update');
            Route::delete('{id}/sell', [SellController::class, 'destroy'])->name('sell.destroy');
        });

        // Transfer Routes
        Route::name('admin.')->group(function () {
            Route::get('transfer', [TransferController::class, 'index'])->name('transfer.index');
            Route::get('{id}/edittransfer', [TransferController::class, 'edit'])->name('transfer.edit');
            Route::put('{id}/transfer', [TransferController::class, 'update'])->name('transfer.update');
            Route::delete('{id}/transfer', [TransferController::class, 'destroy'])->name('transfer.destroy');
        });

        Route::name('admin.')->group(function () {
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
            Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        });

        Route::name('admin.')->group(function () {
            Route::get('wallet/index', [WalletController::class, 'index'])->name('wallet');
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
        
        //Social Links 
        Route::name('admin.')->group(function () {
                Route::get('/sociallinks/index', [SociallinkController::class, 'index'])->name('socialLink.index');
                Route::post('/settings/store/social-links', [SociallinkController::class, 'storeSocialLinks'])->name('settings.storeSocialLinks');
                Route::put('/settings/update/social-links/{id}', [SociallinkController::class, 'updateSocialLinks'])->name('settings.updateSocialLinks');
        });

        Route::name('admin.')->group(function () {
            Route::get('user/index', [UserController::class, 'index'])->name('users');
            Route::get('user/{id}/show', [UserController::class, 'edit'])->name('users.show');
            Route::put('user/{id}/', [UserController::class, 'update'])->name('users.update');
            Route::get('user/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        });

       Route::get('buy/index', [BuyController::class, 'index'])->name('admin.buy');
       Route::get('transfer/index', [Transferontroller::class, 'index'])->name('admin.transfer');
       Route::get('sell/index', [SellController::class, 'index'])->name('admin.sell');

    });  
}); 
