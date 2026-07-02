<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\MaterialCategoryController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Frontend\FavoriteController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\VisitorQuestionController;
use App\Http\Controllers\SitemapController;

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/seed-living-rooms', function () {
    $images = [
        ['file' => 'living-rooms/mirrors-entry.jpg', 'title' => 'مدخل فاخر بمرايا ذهبية', 'desc' => 'تصميم مدخل عصري يجمع بين المرايا بإطارات ذهبية مبتكرة وبنش مخملي بلون برتقالي دافئ، مع جدار من البانيلات الخشبية المموجة التي تضيف عمقاً وأناقة للمكان. يتميز هذا التصميم بالدمج بين الفخامة والبساطة مع إضاءة سقفية حديثة.'],
        ['file' => 'living-rooms/modern-sofa.jpg', 'title' => 'صالة معيشة بأسلوب مينيمالي راقي', 'desc' => 'تصميم صالة معيشة بخطوط نظيفة وألوان محايدة هادئة، يتميز بكنبة واسعة بلون البيج مع وسائد جلدية بنية، وجدار خلفي مزخرف بشرائح خشبية مع إضاءة LED مخفية تمنح المكان دفئاً وعمقاً بصرياً مذهلاً.'],
        ['file' => 'living-rooms/ring-chandelier.jpg', 'title' => 'صالة جلوس بثريا حلقية معاصرة', 'desc' => 'تصميم صالة جلوس أنيق يتميز بثريا حلقية ثلاثية الطبقات كقطعة مركزية، مع كنبة مودرن رمادية وطاولة قهوة رخامية. الجدار الخلفي مزين بتكسيات خشبية وإضاءة شريطية مع لوحات نحاسية دائرية تضيف لمسة فنية فريدة.'],
        ['file' => 'living-rooms/classic-wall.jpg', 'title' => 'صالة استقبال بطراز كلاسيكي عصري', 'desc' => 'تصميم صالة استقبال يمزج بين الطراز الكلاسيكي والعصري، مع جدران بزخارف إطارية بيضاء وتكسيات خشبية طولية، وإضاءة جدارية ذهبية أنيقة. الأثاث يجمع بين كنبة كلاسيكية ومقعد دائري حديث بألوان رملية هادئة.'],
        ['file' => 'living-rooms/geometric-art.jpg', 'title' => 'صالة معيشة بلوحة فنية هندسية', 'desc' => 'تصميم صالة معيشة عصرية يتميز بلوحة جدارية هندسية مبتكرة من خلفية شرائح خشبية مع أشكال دائرية معدنية، وكنبة واسعة رمادية مع وسائد متنوعة، وطاولة قهوة دائرية بتصميم حديث يعكس الذوق الراقي.'],
    ];

    $service = \App\Models\Service::where('is_active', true)->first();
    $serviceId = $service ? $service->id : null;

    foreach($images as $i => $img) {
        // Project
        \App\Models\Project::create([
            'title' => $img['title'],
            'slug' => 'living-room-' . ($i + 1) . '-' . time(),
            'description' => $img['desc'],
            'images' => [$img['file']],
            'client_name' => 'عميل خاص',
            'is_active' => true,
        ]);

        // Gallery
        \App\Models\Gallery::create([
            'title' => $img['title'],
            'slug' => 'gallery-living-' . ($i + 1) . '-' . time(),
            'description' => $img['desc'],
            'image' => $img['file'],
            'is_active' => true,
        ]);

        // Blog Post
        \App\Models\BlogPost::create([
            'title' => $img['title'] . ' - أفكار ملهمة للديكور',
            'slug' => 'blog-living-' . ($i + 1) . '-' . time(),
            'content' => '<p>' . $img['desc'] . '</p><p>يُعد هذا التصميم من أبرز الاتجاهات الحديثة في عالم الديكور الداخلي لصالات المعيشة. حيث يجمع بين الأناقة والراحة مع استخدام مواد عالية الجودة وألوان متناسقة تمنح المكان طابعاً فريداً.</p><p>في ديكورات المصمم الذكي، نقدم لكم خدمات التصميم والتنفيذ الكاملة لتحويل صالات المعيشة إلى تحف فنية تعكس ذوقكم الخاص. فريقنا المتخصص يعمل على تقديم حلول مبتكرة تناسب جميع المساحات والأذواق.</p><p>تواصلوا معنا اليوم للحصول على استشارة مجانية وتحويل منزلكم إلى واحة من الجمال والأناقة.</p>',
            'image' => $img['file'],
            'is_active' => true,
            'meta_title' => $img['title'],
            'meta_description' => \Str::limit($img['desc'], 160),
        ]);
    }

    return 'تم إنشاء 5 مشاريع + 5 صور معرض + 5 مقالات بنجاح!';
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/decorations/jeddah', [PageController::class, 'cityJeddah'])->name('city.jeddah');
Route::get('/decorations/mecca', [PageController::class, 'cityMecca'])->name('city.mecca');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/materials', [MaterialCategoryController::class, 'index'])->name('materials');
Route::get('/materials/{slug}', [MaterialCategoryController::class, 'show'])->name('material.category.show');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('project.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->middleware('throttle:contact')->name('contact.send');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogPost'])->name('blog.post');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/material/{slug}', [MaterialCategoryController::class, 'showMaterial'])->name('material.show');
Route::get('/gallery/{id}/{slug?}', [GalleryController::class, 'show'])->name('gallery.show');
Route::post('/review/submit', [HomeController::class, 'submitReview'])->middleware('throttle:reviews')->name('review.submit');
Route::post('/favorites/items', [FavoriteController::class, 'items'])->name('favorites.items');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle');
Route::get('/most-viewed', [PageController::class, 'mostViewed'])->name('most-viewed');
Route::get('/questions', [VisitorQuestionController::class, 'index'])->name('questions');
Route::get('/q/{slug}', [VisitorQuestionController::class, 'show'])->name('q.show');
Route::post('/questions', [VisitorQuestionController::class, 'store'])->middleware('throttle:questions')->name('questions.store');
Route::get('/areas-we-serve', [PageController::class, 'areasWeServe'])->name('areas.we.serve');
Route::get('/tag/{tag}', [PageController::class, 'tag'])->name('tag');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-projects.xml', [SitemapController::class, 'projects'])->name('sitemap.projects');
Route::get('/sitemap-images.xml', [SitemapController::class, 'images'])->name('sitemap.images');
Route::get('/sitemap-blog.xml', [SitemapController::class, 'blog'])->name('sitemap.blog');
Route::get('/sitemap-services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/sitemap-materials.xml', [SitemapController::class, 'materials'])->name('sitemap.materials');
Route::get('/sitemap-cities.xml', [SitemapController::class, 'cities'])->name('sitemap.cities');

// Fallback route for storage files - serves original or WebP with on-the-fly conversion
Route::get('/storage/{path}', function (string $path) {
    if (str_contains($path, '..')) {
        abort(404);
    }
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    // Serve WebP if browser supports it
    if (preg_match('/\.(jpg|jpeg|png)$/i', $path) && str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'image/webp')) {
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $fullPath);
        if (!file_exists($webpPath)) {
            \App\Services\ImageService::generateWebP($fullPath, $webpPath);
        }
        if (file_exists($webpPath)) {
            return response()->file($webpPath, ['Content-Type' => 'image/webp']);
        }
    }
    $mime = mime_content_type($fullPath);
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('path', '.*');



