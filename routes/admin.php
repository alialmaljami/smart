<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\HomepageSectionController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\VisitorQuestionController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\GoogleSearchConsoleController;
use App\Http\Controllers\Admin\GalleryTypeController;
use App\Http\Controllers\Admin\NeighborhoodController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CityController;


Route::middleware('web')->prefix('admin')->group(function () {
    // Guest routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:login');

    // Auth routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Services
        Route::resource('/services', ServiceController::class, ['as' => 'admin']);
        Route::post('/services/{service}/toggle-active', [ServiceController::class, 'toggleActive'])->name('admin.services.toggle-active');
        Route::post('/services/sort', [ServiceController::class, 'sort'])->name('admin.services.sort');

        // Materials
        Route::resource('/materials', MaterialController::class, ['as' => 'admin']);
        Route::post('/materials/{material}/toggle-active', [MaterialController::class, 'toggleActive'])->name('admin.materials.toggle-active');

        // Projects
        Route::resource('/projects', ProjectController::class, ['as' => 'admin']);
        Route::post('/projects/{project}/toggle-active', [ProjectController::class, 'toggleActive'])->name('admin.projects.toggle-active');

        // Social Links
        Route::resource('/social-links', SocialLinkController::class, ['as' => 'admin']);
        Route::post('/social-links/{socialLink}/toggle-active', [SocialLinkController::class, 'toggleActive'])->name('admin.social-links.toggle-active');
        Route::post('/social-links/sort', [SocialLinkController::class, 'sort'])->name('admin.social-links.sort');

        // Contacts
        Route::resource('/contacts', ContactController::class, ['as' => 'admin']);
        Route::put('/contacts/{contact}/toggle-active', [ContactController::class, 'toggleActive'])->name('admin.contacts.toggle-active');

        // Settings
        Route::middleware('super-admin')->group(function () {
            Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
            Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

            Route::get('/google-search-console', [GoogleSearchConsoleController::class, 'index'])->name('admin.google-search-console');
            Route::post('/google-search-console', [GoogleSearchConsoleController::class, 'update'])->name('admin.google-search-console.update');
            Route::get('/google-search-console/check-meta', [GoogleSearchConsoleController::class, 'checkMeta'])->name('admin.google-search-console.check-meta');
            Route::post('/google-search-console/submit-sitemaps', [GoogleSearchConsoleController::class, 'submitSitemaps'])->name('admin.google-search-console.submit-sitemaps');

            Route::get('/about', [AboutPageController::class, 'index'])->name('admin.about.index');
            Route::post('/about', [AboutPageController::class, 'update'])->name('admin.about.update');

            Route::resource('/admins', AdminUserController::class, ['as' => 'admin']);


        });

        // Blog Posts
        Route::resource('/blog-posts', BlogPostController::class, ['as' => 'admin']);
        Route::put('/blog-posts/{blog_post}/toggle-active', [BlogPostController::class, 'toggleActive'])->name('admin.blog-posts.toggle-active');

        // Categories
        Route::resource('/categories', CategoryController::class, ['as' => 'admin']);
        Route::put('/categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('admin.categories.toggle-active');

        // Gallery
        Route::resource('/galleries', GalleryController::class, ['as' => 'admin']);
        Route::post('/galleries/{gallery}/toggle-active', [GalleryController::class, 'toggleActive'])->name('admin.galleries.toggle-active');

        // Reviews
        Route::any('/reviews/{review}/toggle-active', [ReviewController::class, 'toggleActive'])->name('admin.reviews.toggle-active');
        Route::resource('/reviews', ReviewController::class, ['as' => 'admin']);

        // Homepage Sections
        Route::resource('/homepage-sections', HomepageSectionController::class, ['as' => 'admin']);
        Route::post('/homepage-sections/{homepageSection}/toggle-active', [HomepageSectionController::class, 'toggleActive'])->name('admin.homepage-sections.toggle-active');

            // About Page moved under super-admin group above

        // FAQs
        Route::resource('/faqs', FaqController::class, ['as' => 'admin']);
        Route::post('/faqs/{faq}/toggle-active', [FaqController::class, 'toggleActive'])->name('admin.faqs.toggle-active');

        // Visitor Questions (Q&A)
        Route::resource('/visitor-questions', VisitorQuestionController::class, ['as' => 'admin']);
        Route::post('/visitor-questions/{visitorQuestion}/toggle-active', [VisitorQuestionController::class, 'toggleActive'])->name('admin.visitor-questions.toggle-active');

        // Gallery Type: Videos
        Route::prefix('/videos')->name('admin.videos.')->group(function () {
            Route::get('/', function () {
                return app(GalleryTypeController::class)->index('video');
            })->name('index');
            Route::get('/create', function () {
                return app(GalleryTypeController::class)->create('video');
            })->name('create');
            Route::post('/', function (\Illuminate\Http\Request $req) {
                return app(GalleryTypeController::class)->store('video', $req);
            })->name('store');
            Route::get('/{gallery}/edit', function (App\Models\Gallery $gallery) {
                return app(GalleryTypeController::class)->edit('video', $gallery);
            })->name('edit');
            Route::put('/{gallery}', function (\Illuminate\Http\Request $req, App\Models\Gallery $gallery) {
                return app(GalleryTypeController::class)->update('video', $req, $gallery);
            })->name('update');
            Route::post('/{gallery}/toggle-active', function (App\Models\Gallery $gallery) {
                return app(GalleryTypeController::class)->toggleActive('video', $gallery);
            })->name('toggle-active');
            Route::delete('/{gallery}', function (App\Models\Gallery $gallery) {
                return app(GalleryTypeController::class)->destroy('video', $gallery);
            })->name('destroy');
        });

        // Gallery Type: 360 Tours
        Route::prefix('/tours')->name('admin.tours.')->group(function () {
            Route::get('/', function () { return app(GalleryTypeController::class)->index('360'); })->name('index');
            Route::get('/create', function () { return app(GalleryTypeController::class)->create('360'); })->name('create');
            Route::post('/', function (\Illuminate\Http\Request $req) { return app(GalleryTypeController::class)->store('360', $req); })->name('store');
            Route::get('/{gallery}/edit', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->edit('360', $gallery); })->name('edit');
            Route::put('/{gallery}', function (\Illuminate\Http\Request $req, App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->update('360', $req, $gallery); })->name('update');
            Route::post('/{gallery}/toggle-active', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->toggleActive('360', $gallery); })->name('toggle-active');
            Route::delete('/{gallery}', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->destroy('360', $gallery); })->name('destroy');
        });

        // Gallery Type: Before/After
        Route::prefix('/before-after')->name('admin.before-after.')->group(function () {
            Route::get('/', function () { return app(GalleryTypeController::class)->index('before_after'); })->name('index');
            Route::get('/create', function () { return app(GalleryTypeController::class)->create('before_after'); })->name('create');
            Route::post('/', function (\Illuminate\Http\Request $req) { return app(GalleryTypeController::class)->store('before_after', $req); })->name('store');
            Route::get('/{gallery}/edit', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->edit('before_after', $gallery); })->name('edit');
            Route::put('/{gallery}', function (\Illuminate\Http\Request $req, App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->update('before_after', $req, $gallery); })->name('update');
            Route::post('/{gallery}/toggle-active', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->toggleActive('before_after', $gallery); })->name('toggle-active');
            Route::delete('/{gallery}', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->destroy('before_after', $gallery); })->name('destroy');
        });

        // Gallery Type: Photography
        Route::prefix('/photography')->name('admin.photography.')->group(function () {
            Route::get('/', function () { return app(GalleryTypeController::class)->index('photography'); })->name('index');
            Route::get('/create', function () { return app(GalleryTypeController::class)->create('photography'); })->name('create');
            Route::post('/', function (\Illuminate\Http\Request $req) { return app(GalleryTypeController::class)->store('photography', $req); })->name('store');
            Route::get('/{gallery}/edit', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->edit('photography', $gallery); })->name('edit');
            Route::put('/{gallery}', function (\Illuminate\Http\Request $req, App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->update('photography', $req, $gallery); })->name('update');
            Route::post('/{gallery}/toggle-active', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->toggleActive('photography', $gallery); })->name('toggle-active');
            Route::delete('/{gallery}', function (App\Models\Gallery $gallery) { return app(GalleryTypeController::class)->destroy('photography', $gallery); })->name('destroy');
        });

        // Neighborhoods
        Route::resource('/neighborhoods', NeighborhoodController::class, ['as' => 'admin']);
        Route::post('/neighborhoods/{neighborhood}/toggle-active', [NeighborhoodController::class, 'toggleActive'])->name('admin.neighborhoods.toggle-active');

        // Tags
        Route::resource('/tags', TagController::class, ['as' => 'admin']);

        // Cities
        Route::resource('/cities', CityController::class, ['as' => 'admin']);
        Route::post('/cities/{city}/toggle-active', [CityController::class, 'toggleActive'])->name('admin.cities.toggle-active');
    });
});
