<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GoogleCalendarController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CoreValueController;
use App\Http\Controllers\Admin\VisionMissionController;
use App\Http\Controllers\Admin\SociallinkController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\ContactFormController;


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
        //Slider 
        Route::get('/manage/sliderIndex', [SliderController::class, 'indexSlider'])->name('admin.slider.index');
        Route::get('/manage/sliderCreate', [SliderController::class, 'createSlider'])->name('admin.slider.create');
        Route::post('/slider', [SliderController::class, 'storeSlider'])->name('slider.store');
        Route::get('/slider/{id}/edit', [SliderController::class, 'editSlider'])->name('admin.slider.edit');
        Route::put('/slider/{id}', [SliderController::class, 'updateSlider'])->name('admin.slider.update');
        Route::get('/slider/{id}', [SliderController::class, 'destroySlider'])->name('admin.slider.destroy');
        //Why choose us 
        Route::get('/settings/content', [SettingsController::class, 'WhyChooseUs'])->name('admin.settings.content');
        Route::post('/settings/store/why-choose-us', [SettingsController::class, 'storeWhyChooseUs'])->name('admin.settings.store_why_choose_us');
        Route::put('/settings/update/why-choose-us/{id}', [SettingsController::class, 'updateWhyChooseUs'])->name('admin.settings.update_why_choose_us');
        
        Route::get('/settings/index', [SettingsController::class, 'index'])->name('admin.settings.index');
        
        //About us
        Route::get('/settings/about-us', [SettingsController::class, 'getAboutUs'])->name('admin.settings.aboutUs');
        Route::post('/settings/store/about-us', [SettingsController::class, 'storeAboutUs'])->name('admin.settings.storeAboutus');
        Route::put('/settings/update/about-us/{id}', [SettingsController::class, 'updateAboutUs'])->name('admin.settings.updateAboutus');

        //Core Value  
        Route::get('/settings/core-value', [CoreValueController::class, 'index'])->name('admin.coreValue.index');
        Route::post('/settings/store/core-value', [CoreValueController::class, 'store'])->name('admin.coreValue.store');
        Route::put('/settings/update/core-value/{id}', [CoreValueController::class, 'update'])->name('admin.coreValue.update');
        //visionMission
        Route::get('/settings/vision-mission', [SettingsController::class, 'indexVisionMission'])->name('admin.visionMission.index');
        Route::post('/settings/vision-mission/store', [SettingsController::class, 'storeVisionMission'])->name('admin.visionMission.store');
        Route::put('/settings/vision-mission/update/{id}', [SettingsController::class, 'updateVisionMission'])->name('admin.visionMission.update');
        //Blog 
        // Blog Routes
        Route::prefix('post')->group(function () {
            Route::get('index', [BlogController::class, 'index'])->name('admin.post.index');
            Route::get('create', [BlogController::class, 'create'])->name('admin.post.create');
            Route::post('store', [BlogController::class, 'store'])->name('admin.post.store');
            Route::get('{id}/edit', [BlogController::class, 'edit'])->name('admin.post.edit');
            Route::put('{id}', [BlogController::class, 'update'])->name('admin.post.update');
            Route::get('{id}', [BlogController::class, 'destroy'])->name('admin.post.destroy');
        });

        //Office Hours 
        Route::post('/settings/store/office-hours', [SettingsController::class, 'storeOfficeHours'])->name('admin.office-hours.store');
        Route::put('/settings/update/office-hours/{id}', [SettingsController::class, 'updatestoreOfficeHours'])->name('admin.office-hours.update');
        Route::post('/settings/store/office-hours', [SettingsController::class, 'storeOfficeHours'])->name('admin.office-hours.store');
         
        //Contact Us 
        Route::get('/settings/contact', [SettingsController::class, 'indexContact'])->name('admin.contact.index');
        Route::post('/settings/store/contact', [SettingsController::class, 'storeContact'])->name('admin.contact.store');
        Route::put('/settings/update/contact/{id}', [SettingsController::class, 'updateContact'])->name('admin.contact.update');
        //Social Links 
        Route::get('/sociallinks/index', [SociallinkController::class, 'index'])->name('admin.socialLink.index');
        Route::post('/settings/store/social-links', [SociallinkController::class, 'storeSocialLinks'])->name('admin.settings.storeSocialLinks');
        Route::put('/settings/update/social-links/{id}', [SociallinkController::class, 'updateSocialLinks'])->name('admin.settings.updateSocialLinks');
       
        //Careers 
        Route::get('career/index', [CareerController::class, 'index'])->name('admin.career.index');
        Route::post('career/store/', [CareerController::class, 'store'])->name('admin.career.store');
        Route::put('career/update/{id}', [CareerController::class, 'update'])->name('admin.career.update');
       
        //Teams 
        Route::get('/team/index', [TeamController::class, 'getTeam'])->name('admin.team.getTeam');
        Route::get('/team/create', [TeamController::class, 'create'])->name('admin.team.create');
        Route::post('/team/store', [TeamController::class, 'store'])->name('admin.team.store');
        Route::get('/team/{id}/edit', [TeamController::class, 'edit'])->name('admin.team.edit');
        Route::put('/team/{id}', [TeamController::class, 'update'])->name('admin.team.update');
        Route::get('/team/{id}', [TeamController::class, 'destroy'])->name('admin.team.destroy');
       
         //Privacy
        Route::get('/index/privacypolicy', [PrivacyController::class, 'index'])->name('admin.privacyPolicy.index');
        Route::post('/store/privacypolicy', [PrivacyController::class, 'store'])->name('admin.privacy.store');
        Route::put('/update/privacypolicy/{id}', [PrivacyController::class, 'update'])->name('admin.privacy.update');
        
        //Terms Conditions
        Route::get('/terms/conditions', [TermsConditionController::class, 'index'])->name('admin.termsCondition.index');
        Route::post('/terms/conditions/store/', [TermsConditionController::class, 'store'])->name('admin.termsCondition.store');
        Route::put('/terms/conditions/update/{id}', [TermsConditionController::class, 'update'])->name('admin.termsCondition.update');
         
        //Events
        Route::get('events/index', [EventController::class, 'index'])->name('admin.events.index');
        Route::get('events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::post('events/store', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('admin.events.update');
        Route::get('/events/{id}', [EventController::class, 'destroy'])->name('admin.events.destroy');

        //Galleries
        Route::get('projects/status/index', [GalleryContoller::class, 'index'])->name('admin.projects.status.index');
        Route::get('projects/status/create', [GalleryContoller::class, 'create'])->name('admin.projects.status.create');
        Route::post('projects/status/store', [GalleryContoller::class, 'store'])->name('admin.projects.status.store');
        Route::get('/projects/status/{id}/edit', [GalleryContoller::class, 'edit'])->name('admin.projects.status.edit');
        Route::put('/projects/status/{id}', [GalleryContoller::class, 'update'])->name('admin.gallery.update');
        Route::get('/gaprojects/statusllery/{id}', [GalleryContoller::class, 'destroy'])->name('admin.projects.status.destroy');
        
        //QuickLink 
        Route::get('/quicklink/index', [QuicklinkController::class, 'index'])->name('admin.quicklink.index');
        Route::get('/quicklink/create', [QuicklinkController::class, 'create'])->name('admin.quicklink.create');
        Route::post('/quicklink/store', [QuicklinkController::class, 'store'])->name('admin.quicklink.store');
        Route::get('quicklink/{id}/edit', [QuicklinkController::class, 'edit'])->name('admin.quicklink.edit');
        Route::put('quicklink/{id}', [QuicklinkController::class, 'update'])->name('admin.quicklink.update');
        Route::get('quicklink/{id}', [QuicklinkController::class, 'destroy'])->name('admin.quicklink.destroy');

        //Services
        Route::get('solutions/index', [SolutionsController::class, 'index'])->name('admin.solution.index');
        Route::get('solutions/create', [SolutionsController::class, 'create'])->name('admin.solution.create');
        Route::post('post/solutions', [SolutionsController::class, 'store'])->name('admin.solution.store');
        Route::get('solutions/{id}/edit', [SolutionsController::class, 'edit'])->name('admin.solution.edit');
        Route::put('solutions/{id}', [SolutionsController::class, 'update'])->name('admin.solution.update');
        Route::get('solutions/{id}', [SolutionsController::class, 'destroy'])->name('admin.solution.destroy');
      
        //Faqs
        Route::get('faq/index', [FAQController::class, 'index'])->name('admin.faq.index');
        Route::get('faq/create', [FAQController::class, 'create'])->name('admin.faq.create');
        Route::post('post/faq', [FAQController::class, 'store'])->name('admin.faq.store');
        Route::get('faq/{id}/edit', [FAQController::class, 'edit'])->name('admin.faq.edit');
        Route::put('faq/{id}', [FAQController::class, 'update'])->name('admin.faq.update');
        Route::get('faq/{id}', [FAQController::class, 'destroy'])->name('admin.faq.destroy');
        //Contact
        Route::get('/contact-form/index', [ContactFormController::class, 'index'])->name('admin.contactForm.index');
        Route::get('/contact-form/show/{id}', [ContactFormController::class, 'show'])->name('admin.contactForm.show');
        Route::get('/contact-form/destroy/{id}', [ContactFormController::class, 'destroy'])->name('admin.contactForm.destroy');
       
        Route::get('system-calendar', [SystemCalendarController::class, 'index'])->name('admin.systemCalendar');
        // Route::get('system-calendar', [SystemCalendarController::class, 'destroy'])->name('admin.destroy');

    
        
    });  
}); 
