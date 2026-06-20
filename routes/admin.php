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
use App\Services\WatermarkService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

Route::middleware('web')->prefix('admin')->group(function () {
    // Guest routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);

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
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

        // Watermark preview (generates a sample image with current watermark settings)
        Route::get('/watermark-preview', function () {
            $manager = new ImageManager(new Driver());
            $img = $manager->createImage(800, 600);
            $gd = $img->core()->native();
            imagefill($gd, 0, 0, imagecolorallocate($gd, 40, 40, 60));
            $watermark = new WatermarkService();
            $watermark->enabled = true;
            $watermark->apply($img);
            return response($img->encodeUsingFileExtension('webp', quality: 90)->toString())->header('Content-Type', 'image/webp');
        })->name('admin.watermark-preview');

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
        Route::resource('/reviews', ReviewController::class, ['as' => 'admin']);
        Route::post('/reviews/{review}/toggle-active', [ReviewController::class, 'toggleActive'])->name('admin.reviews.toggle-active');

        // Homepage Sections
        Route::resource('/homepage-sections', HomepageSectionController::class, ['as' => 'admin']);
        Route::post('/homepage-sections/{homepageSection}/toggle-active', [HomepageSectionController::class, 'toggleActive'])->name('admin.homepage-sections.toggle-active');

        // About Page
        Route::get('/about', [AboutPageController::class, 'index'])->name('admin.about.index');
        Route::post('/about', [AboutPageController::class, 'update'])->name('admin.about.update');

        // FAQs
        Route::resource('/faqs', FaqController::class, ['as' => 'admin']);
        Route::post('/faqs/{faq}/toggle-active', [FaqController::class, 'toggleActive'])->name('admin.faqs.toggle-active');

        // Visitor Questions (Q&A)
        Route::resource('/visitor-questions', VisitorQuestionController::class, ['as' => 'admin']);
        Route::post('/visitor-questions/{visitorQuestion}/toggle-active', [VisitorQuestionController::class, 'toggleActive'])->name('admin.visitor-questions.toggle-active');
    });
});
