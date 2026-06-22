<?php

use Illuminate\Support\Facades\Artisan;
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
use App\Services\WatermarkService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

Route::middleware('web')->prefix('admin')->group(function () {
    // Guest routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/setup', function () {
        $exists = App\Models\User::where('is_admin', true)->exists();
        if ($exists) {
            $user = App\Models\User::where('email', 'ali@smartdecorations.com')->first();
            if (!$user || !$user->is_admin) {
                App\Models\User::updateOrCreate(
                    ['email' => 'ali@smartdecorations.com'],
                    ['name' => 'Admin', 'password' => 'Ali2024', 'is_admin' => true, 'is_super_admin' => true]
                );
                return redirect()->route('admin.login')->with('success', 'Admin account re-created. Login with ali@smartdecorations.com / Ali2024');
            }
            if (!$user->is_super_admin) {
                $user->update(['is_super_admin' => true]);
            }
            return redirect()->route('admin.login');
        }
        App\Models\User::create([
            'name' => 'Admin',
            'email' => 'ali@smartdecorations.com',
            'password' => 'Ali2024',
            'is_admin' => true,
            'is_super_admin' => true,
        ]);
        return redirect()->route('admin.login')->with('success', 'Admin account created. Login with ali@smartdecorations.com / Ali2024');
    });
    Route::get('/debug', function () {
        $user = App\Models\User::where('email', 'ali@smartdecorations.com')->first();
        if (!$user) {
            return 'User not found in database';
        }
        $check = Illuminate\Support\Facades\Hash::check('Ali2024', $user->password);
        return "User found: {$user->name}, is_admin: " . ($user->is_admin ? 'yes' : 'no') . ", password check: " . ($check ? 'pass' : 'FAIL') . ", password hash: {$user->password}";
    });

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

            Route::get('/about', [AboutPageController::class, 'index'])->name('admin.about.index');
            Route::post('/about', [AboutPageController::class, 'update'])->name('admin.about.update');

            Route::resource('/admins', AdminUserController::class, ['as' => 'admin']);

            Route::get('/watermark-regenerate', function () {
                $artisan = Artisan::call('watermark:regenerate');
                $output = Artisan::output();
                return redirect()->route('admin.settings')->with('success', nl2br(e($output)));
            })->name('admin.watermark.regenerate');

            Route::get('/watermark-diagnostic', function () {
                $watermark = new WatermarkService();
                $info = [];

                $info['font_path'] = $watermark->fontPath;
                $info['font_exists'] = file_exists($watermark->fontPath);
                $info['watermark_type'] = $watermark->type;
                $info['watermark_opacity'] = $watermark->opacity;
                $info['watermark_position'] = $watermark->position;
                $info['watermark_size'] = $watermark->size;

                $info['public_storage_exists'] = is_dir(public_path('storage'));
                $info['public_storage_is_link'] = is_link(public_path('storage'));
                if ($info['public_storage_is_link']) {
                    $info['public_storage_target'] = readlink(public_path('storage'));
                }
                $info['storage_app_public'] = storage_path('app/public');

                $lastGallery = \App\Models\Gallery::latest()->first();
                if ($lastGallery) {
                    $info['gallery_id'] = $lastGallery->id;
                    $info['gallery_image_db'] = $lastGallery->image;
                    $info['gallery_file_exists'] = file_exists(storage_path('app/public/' . $lastGallery->image)) ? 'YES' : 'NO';
                    $info['gallery_url'] = asset('storage/' . $lastGallery->image);
                    $info['gallery_fullpath'] = storage_path('app/public/' . $lastGallery->image);
                }

                $html = '<!DOCTYPE html><html dir="rtl"><head><meta charset="utf-8"><title>Diagnostic</title><style>body{font-family:sans-serif;padding:20px;background:#1a1a2e;color:#fff}table{width:100%;border-collapse:collapse;margin-bottom:20px}td,th{padding:10px;border:1px solid #333;text-align:right}th{background:#16213e}.ok{color:#4ade80}.fail{color:#f87171}</style></head><body><h1>تشخيص العلامة المائية والتخزين</h1>';
                $html .= '<table><tr><th>المعلومة</th><th>القيمة</th></tr>';
                foreach ($info as $k => $v) {
                    $vStr = is_bool($v) ? ($v ? 'true' : 'false') : (string)$v;
                    $cls = ($k === 'font_exists' && !$v) || ($k === 'gallery_file_exists' && $v === 'NO') ? 'fail' : 'ok';
                    $html .= "<tr><td>$k</td><td class=\"$cls\">$vStr</td></tr>";
                }
                $html .= '</table>';

                if (isset($info['gallery_id'])) {
                    $html .= '<h2>اختبار عرض الصورة</h2>';
                    $html .= '<img src="' . $info['gallery_url'] . '" style="max-width:400px;border:2px solid #333;border-radius:8px" onerror="this.after(document.createTextNode(\' ❌ الصورة لا تظهر (رابط معطل)\'));this.style.display=\'none\'">';
                    $html .= '<br><br><a href="' . route('admin.storage-test', $info['gallery_id']) . '" style="color:#fbbf24" target="_blank">🔗 عرض عبر Laravel route (اختبار المسار البديل)</a>';
                }

                $html .= '</body></html>';
                return response($html);
            })->name('admin.watermark-diagnostic');

            Route::get('/storage-test/{id}', function ($id) {
                $gallery = \App\Models\Gallery::find($id);
                if (!$gallery || !$gallery->image) abort(404);
                $fullPath = storage_path('app/public/' . $gallery->image);
                if (!file_exists($fullPath)) abort(404, 'File not found: ' . $fullPath);
                $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                $mime = match($ext) { 'webp' => 'image/webp', 'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', default => 'application/octet-stream' };
                return response()->file($fullPath, ['Content-Type' => $mime, 'Content-Disposition' => 'inline']);
            })->name('admin.storage-test');
        });

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

            // About Page moved under super-admin group above

        // FAQs
        Route::resource('/faqs', FaqController::class, ['as' => 'admin']);
        Route::post('/faqs/{faq}/toggle-active', [FaqController::class, 'toggleActive'])->name('admin.faqs.toggle-active');

        // Visitor Questions (Q&A)
        Route::resource('/visitor-questions', VisitorQuestionController::class, ['as' => 'admin']);
        Route::post('/visitor-questions/{visitorQuestion}/toggle-active', [VisitorQuestionController::class, 'toggleActive'])->name('admin.visitor-questions.toggle-active');
    });
});
