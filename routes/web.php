<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialLoginController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\Admin\CareersController as Careers;
use App\Http\Controllers\Admin\CauseController;
use App\Http\Controllers\Admin\BloggersController;
use App\Http\Controllers\Admin\BlogCategoriesController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\GalleryController as Gallery;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\VolunteersController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\WebpagesController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\ExportsController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Admin\ApplicationsController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\JobCategoryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\BlogController as Blogs;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CauseController as Causes;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController as Events;
use App\Http\Controllers\ProjectController as Projects;
use App\Http\Controllers\StoryController as Stories;
use App\Models\JobCategory;

//Guest routes
// Route::get('/', function() {
//   return view('under-maintainence');
// });

Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/gallery', [PageController::class, 'gallery']);

Route::get('/blogs', [Blogs::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [Blogs::class, 'show'])->name('blogs.show');
Route::get('/blogs/category/{cause:slug}', [Blogs::class, 'category'])->name('blogs.category');

Route::controller(Causes::class)->group(function () {
    Route::get('/causes', 'index')->name('causes.index');
    Route::get('/cause/{slug}', 'show')->name('causes.show');
});

Route::controller(Projects::class)->group(function () {
    Route::get('/projects', 'index')->name('projects.index');
    Route::get('/project/{project:slug}', 'show')->name('projects.show');
});

Route::controller(Stories::class)->group(function () {
    Route::get('/stories', 'index')->name('stories.index');
    Route::get('/stories/{slug}', 'show')->name('stories.show');
});

Route::controller(Events::class)->group(function () {
    Route::get('/events', 'index')->name('events.index');
    Route::get('/events/{slug}', 'show')->name('events.show');
});

Route::get('/cause/{id}', [PageController::class, 'cause']);
Route::get('/donate', [PageController::class, 'donate']);
Route::get('/volunteer', [PageController::class, 'volunteer']);

Route::get('/application-sent', [PageController::class, 'application_sent']);
Route::get('blogs/search/{keyword}', [PageController::class, 'search']);
Route::resource('contact', ContactController::class);
Route::resource('subscribe', SubscriptionsController::class);
Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer');
Route::post('/volunteer', [VolunteerController::class, 'store']);
Route::get('/donate', [DonateController::class, 'index']);
Route::post('/donate', [DonateController::class, 'store'])->name('donation.store');

// --- DONATION ECOSYSTEM ---

Route::prefix('donations')->name('donations.')->group(function () {
    
    // 1. The Project Hub (Gallery of all causes)
    Route::get('/', [DonationController::class, 'index'])->name('index');

    // 2. Project Detail (The "Convincing" Story Page)
    // We use a slug (e.g., /donations/project/clean-water) for SEO and professionalism
    Route::get('/project/{slug}', [DonationController::class, 'show'])->name('show');

    // 3. Checkout Page (The Secure Payment Form)
    Route::get('/checkout/{project_id?}', [DonationController::class, 'checkout'])->name('checkout');

    // 4. Payment Verification (The one we discussed)
    Route::get('/success', [DonationController::class, 'handleSuccess'])->name('success');

    // 5. Success/Thank You Page (The Emotional Landing)
    // Usually triggered after handleSuccess verifies the payment
    Route::get('/thank-you', [DonationController::class, 'thankYou'])->name('thank_you');

    // 6. Webhook (CRITICAL for Production)
    // Paystack sends a POST here if the user's internet cuts out but the Momo went through.
    // This ensures the donation is recorded even if the user closes the browser.
    Route::post('/webhook', [DonationController::class, 'handleWebhook'])->name('webhook');
});

// Gallery Page
Route::get('/gallery', [Gallery::class, 'index'])->name('gallery.index');
Route::get('/gallery/{photo}', [Gallery::class, 'show'])->name('gallery.show');
Route::get('/gallery/category/{slug}', [Gallery::class, 'filter'])->name('gallery.filter');

Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::get('/careers/{slug}', [CareerController::class, 'show'])->name('careers.show');

Route::get('/job-details/{id}', [CareersController::class, 'jobDetails']);
Route::get('/apply/{id}', [CareersController::class, 'apply'])->name('apply');
Route::post('/apply', [CareersController::class, 'store']);
// Route::resource('careers', Careers::class);
Route::resource('applications', ApplicationsController::class);
Route::get('/export-excel', [ExportsController::class, 'exportAll']);
Route::get('/export-excel/{id}', [ExportsController::class, 'exportSelected']);

// Social login routes
Route::get('/auth/redirect/{provider}', [SocialLoginController::class, 'redirect']);
Route::get('/auth/callback/{provider}', [SocialLoginController::class, 'callback']);

//Authenticated user routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () { 
    Route::get('/home', [PageController::class, 'index'])->name('home');
    Route::post('/comment', [PagesController::class, 'post']);
    Route::post('/deleteComment/{id}', [PagesController::class, 'deleteComment']);
});

//Admin and super admin Routes
Route::middleware(['auth', 'role:admin|super-admin'])->prefix('admin')->name('admin.')->group(function () {
   // Route::get('/admin/dashboard', fn() => 'Admin Dashboard')->name('admin.dashboard');

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/add-task', [AdminController::class, 'addTask'])->name('addTask');
    Route::post('/task-done/{id}', [AdminController::class, 'taskDone'])->name('taskDone');
    Route::resource('pages', WebpagesController::class);
    Route::resource('causes', CauseController::class);
    Route::resource('stories', StoryController::class);
    Route::resource('bloggers', BloggersController::class);

    Route::resource('jobs', JobController::class);
    Route::resource('job-categories', JobCategoryController::class);

    Route::resource('blogs', BlogController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('team', TeamController::class);
    Route::resource('careers', Careers::class);
    Route::resource('applications', ApplicationsController::class);
    Route::post('applications/shortlist', [ApplicationsController::class, 'shortlist']);
    Route::post('/applications/export-all', [ApplicationsController::class, 'exportAll']);
    Route::get('/applications/export-selected', [ApplicationsController::class, 'exportSelected']);
    Route::get("/letmesee/{id}", [ApplicationsController::class, 'exportSelected']);
    Route::get('applications/filter/{id}', [ApplicationsController::class, 'filter']);
    Route::get('applications/search/{keyword}', [ApplicationsController::class, 'search']);
    Route::get('/downloadfiles', [ApplicationsController::class, 'downloadfiles']);
    Route::post('applications/hire', [ApplicationsController::class, 'hire']);
    Route::post('applications/reject', [ApplicationsController::class, 'reject']);
    Route::resource('volunteers', VolunteersController::class);
    Route::resource('events', EventController::class);
    Route::get('/events/{event:slug}/download-pdf', [EventController::class, 'downloadPdf'])->name('events.download-pdf');
    Route::resource('users', UsersController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('organization', OrganizationController::class);
});

//Testing routes
Route::get('/test-super-admin', function () {
    return 'You are super-admin!';
})->middleware(['auth', 'role:super-admin']);

Route::get('/test-admin', function () {
    return 'You are admin!';
})->middleware(['auth', 'role:admin']);

Route::get('/checkifemailisverified', function () {
    return "You have verified";
})->middleware(['verified']);

