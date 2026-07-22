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
use App\Http\Controllers\Frontend\NeighborhoodController;
use App\Http\Controllers\Frontend\CityController;
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

Route::get('/seed-cities', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--path' => 'database/migrations/2026_07_08_000001_create_cities_table.php', '--force' => true]);
    $output = \Illuminate\Support\Facades\Artisan::output();
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\CitySeeder', '--force' => true]);
    $output .= \Illuminate\Support\Facades\Artisan::output();
    return '<pre>' . $output . '</pre>';
});

Route::get('/smart-retag', function () {
    $masterTags = \App\Models\Tag::all();
    $models = [
        \App\Models\BlogPost::class  => ['name' => 'المقالات', 'hasService' => false, 'hasNeighborhood' => false, 'titleField' => 'title', 'contentField' => 'content'],
        \App\Models\Project::class   => ['name' => 'المشاريع', 'hasService' => true, 'hasNeighborhood' => true, 'titleField' => 'title', 'contentField' => 'description'],
        \App\Models\Gallery::class   => ['name' => 'المعرض', 'hasService' => false, 'hasNeighborhood' => false, 'titleField' => 'title', 'contentField' => 'description'],
        \App\Models\Material::class  => ['name' => 'المواد', 'hasService' => true, 'hasNeighborhood' => false, 'titleField' => 'name', 'contentField' => 'description'],
    ];

    $totalItems = 0;
    $linkedItems = 0;
    $results = [];

    $cityTags = $masterTags->filter(fn($t) => in_array($t->slug, ['jeddah', 'mecca', 'riyadh', 'dammam', 'medina', 'taif', 'khobar', 'qassim', 'tabuk', 'abha', 'najran', 'jazan', 'hail', 'jubail', 'yanbu', 'dhahran', 'khamis-mushait', 'madinah']));
    $cityTagMap = [];
    foreach ($cityTags as $ct) {
        $cityTagMap[$ct->slug] = $ct->id;
    }

    $stopWords = ['في', 'من', 'إلى', 'عن', 'على', 'مع', 'بين', 'و', 'أو', 'لا', 'ما', 'هو', 'هي', 'ذلك', 'هذه', 'التي', 'الذي'];

    foreach ($models as $modelClass => $config) {
        $taggedCount = 0;
        $modelClass::chunk(50, function ($items) use ($masterTags, $cityTagMap, $stopWords, $config, &$taggedCount) {
            foreach ($items as $item) {
                $matchedTagIds = [];

                // Strategy 1: Match old JSON tags column by name/slug
                $oldTags = is_string($item->tags ?? null) ? json_decode($item->tags, true) : ($item->tags ?? []);
                if (is_array($oldTags)) {
                    foreach ($oldTags as $oldTag) {
                        $oldTag = trim($oldTag);
                        if (!$oldTag) continue;
                        $found = $masterTags->first(function ($mt) use ($oldTag) {
                            return mb_strtolower(trim($mt->name)) === mb_strtolower($oldTag)
                                || mb_strtolower($mt->slug) === mb_strtolower(\Illuminate\Support\Str::slug($oldTag));
                        });
                        if ($found) $matchedTagIds[] = $found->id;
                    }
                }

                // Strategy 2: Match city tags via neighborhood
                if (isset($config['hasNeighborhood']) && $config['hasNeighborhood'] && $item->neighborhood_id) {
                    try {
                        $n = \App\Models\Neighborhood::find($item->neighborhood_id);
                        if ($n && $n->city) {
                            $citySlug = is_string($n->city) ? $n->city : ($n->city->slug ?? null);
                            if ($citySlug && isset($cityTagMap[$citySlug])) {
                                $matchedTagIds[] = $cityTagMap[$citySlug];
                            }
                        }
                    } catch (\Exception $e) {}
                }

                // Strategy 3: Match service tags
                if (isset($config['hasService']) && $config['hasService'] && $item->service_id) {
                    try {
                        $svc = \App\Models\Service::find($item->service_id);
                        if ($svc) {
                            $found = $masterTags->first(fn($mt) =>
                                mb_strtolower(trim($mt->name)) === mb_strtolower(trim($svc->name))
                                || mb_strtolower($mt->slug) === mb_strtolower(\Illuminate\Support\Str::slug($svc->name))
                            );
                            if ($found) $matchedTagIds[] = $found->id;
                        }
                    } catch (\Exception $e) {}
                }

                // Strategy 4: Title/content keyword matching against all tag names
                $title = $item->{$config['titleField']} ?? '';
                $content = $item->{$config['contentField']} ?? '';
                $text = $title . ' ' . $content;

                foreach ($masterTags as $tag) {
                    if (in_array($tag->id, $matchedTagIds)) continue;
                    if (mb_stripos($text, $tag->name) !== false) {
                        $matchedTagIds[] = $tag->id;
                    }
                }

                // Strategy 5: Title keyword matching against tag SLUG words
                $titleWords = preg_split('/[\s,]+/u', $title);
                foreach ($masterTags as $tag) {
                    if (in_array($tag->id, $matchedTagIds)) continue;
                    $slugParts = explode('-', $tag->slug);
                    foreach ($slugParts as $part) {
                        if (in_array($part, $stopWords)) continue;
                        if (mb_strlen($part) < 3) continue;
                        foreach ($titleWords as $word) {
                            if (mb_strtolower(trim($word)) === mb_strtolower($part)) {
                                $matchedTagIds[] = $tag->id;
                                break 2;
                            }
                        }
                    }
                }

                if ($matchedTagIds) {
                    $item->tagItems()->syncWithoutDetaching(array_unique($matchedTagIds));
                    $taggedCount++;
                }
            }
        });

        $results[] = "{$config['name']}: تم وسم $taggedCount عنصر";
        $totalItems += $taggedCount;
    }

    $html = "<div dir='rtl' style='font-family: system-ui; padding: 20px; background: #f8fafc;'>"
          . "<h2 style='color: #b8860b;'>إعادة الوسم الذكية</h2>"
          . "<p>تمت معالجة جميع العناصر وربط الوسوم ذات العلاقة</p>"
          . "<ul style='line-height: 2;'>";
    foreach ($results as $r) {
        $html .= "<li>$r</li>";
    }
    $html .= "</ul></div>";
    return $html;
});

Route::get('/retag-content', function () {
    return redirect('/smart-retag');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/decorations/jeddah', [CityController::class, 'show'])->defaults('slug', 'jeddah')->name('city.jeddah');
Route::get('/decorations/mecca', [CityController::class, 'show'])->defaults('slug', 'mecca')->name('city.mecca');
Route::get('/decorations/{slug}', [CityController::class, 'show'])->name('city.show');
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
Route::get('/gallery/videos', [GalleryController::class, 'videos'])->name('gallery.videos');
Route::get('/gallery/tours', [GalleryController::class, 'tours'])->name('gallery.tours');
Route::get('/gallery/before-after', [GalleryController::class, 'beforeAfter'])->name('gallery.before-after');
Route::get('/gallery/photography', [GalleryController::class, 'photography'])->name('gallery.photography');
Route::get('/material/{slug}', [MaterialCategoryController::class, 'showMaterial'])->name('material.show');
Route::get('/gallery/{id}/{slug?}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/media/{type}/{slug}/{index}', [\App\Http\Controllers\Frontend\MediaController::class, 'show'])->name('media.show');
Route::post('/review/submit', [HomeController::class, 'submitReview'])->middleware('throttle:reviews')->name('review.submit');
Route::post('/favorites/items', [FavoriteController::class, 'items'])->name('favorites.items');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('like.toggle');
Route::get('/most-viewed', [PageController::class, 'mostViewed'])->name('most-viewed');
Route::get('/questions', [VisitorQuestionController::class, 'index'])->name('questions');
Route::get('/q/{slug}', [VisitorQuestionController::class, 'show'])->name('q.show');
Route::post('/questions', [VisitorQuestionController::class, 'store'])->middleware('throttle:questions')->name('questions.store');
Route::get('/areas-we-serve', [PageController::class, 'areasWeServe'])->name('areas.we.serve');
Route::get('/area/{slug}', [NeighborhoodController::class, 'show'])->name('area.show');
Route::get('/tag-debug', function () {
    $logFile = storage_path('logs/laravel.log');
    if (!file_exists($logFile)) return 'No log file';
    $lines = file($logFile);
    $lastErrors = [];
    foreach (array_reverse($lines) as $line) {
        if (str_contains($line, 'local.ERROR')) {
            $lastErrors[] = $line;
            if (count($lastErrors) >= 3) break;
        }
    }
    return "<pre dir='ltr'>" . htmlspecialchars(implode("\n", $lastErrors)) . "</pre>";
});
Route::get('/tag/{tag}', [PageController::class, 'tag'])->name('tag');
Route::get('/tag/slug/{slug}', [PageController::class, 'tagBySlug'])->name('tag.slug');
Route::get('/submit-google-sitemaps', function () {
    $tokenPath = storage_path('google-token.json');
    if (!file_exists($tokenPath)) {
        return 'لم يتم العثور على ملف التوكن. قم بتجديد التوكن أولاً.';
    }
    $token = json_decode(file_get_contents($tokenPath), true);
    $accessToken = $token['access_token'] ?? '';
    if (empty($accessToken)) {
        return 'التوكن فارغ';
    }
    $property = 'sc-domain:smartdecorat.com';
    $response = [];
    
    // First, test the token by listing sitemaps
    $ch = curl_init('https://www.googleapis.com/webmasters/v3/sites/' . rawurlencode($property) . '/sitemaps');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ],
    ]);
    $listResponse = curl_exec($ch);
    $listHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $response[] = '=== قائمة السيت ماب الحالية (HTTP ' . $listHttpCode . ') ===';
    $response[] = $listResponse;
    $response[] = '';

    // Now submit each sitemap
    $sitemaps = [
        url('/sitemap.xml'),
        url('/sitemap-pages.xml'),
        url('/sitemap-projects.xml'),
        url('/sitemap-images.xml'),
        url('/sitemap-blog.xml'),
        url('/sitemap-services.xml'),
        url('/sitemap-materials.xml'),
        url('/sitemap-cities.xml'),
        url('/sitemap-neighborhoods.xml'),
    ];
    
    $response[] = '=== إرسال السيت ماب ===';
    foreach ($sitemaps as $sitemap) {
        try {
            $feedpath = rawurlencode($sitemap);
            $ch = curl_init('https://www.googleapis.com/webmasters/v3/sites/' . rawurlencode($property) . '/sitemaps/' . $feedpath);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Length: 0',
                ],
                CURLOPT_CUSTOMREQUEST => 'PUT',
            ]);
            $resp = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            $name = basename(parse_url($sitemap, PHP_URL_PATH));
            $response[] = $name . ' => HTTP ' . $httpCode . ($curlError ? ' (cURL: ' . $curlError . ')' : '') . ($resp ? ' | ' . $resp : '');
        } catch (\Exception $e) {
            $response[] = basename(parse_url($sitemap, PHP_URL_PATH)) . ' => ERROR: ' . $e->getMessage();
        }
    }
    return '<pre>' . implode("\n", $response) . '</pre>';
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-projects.xml', [SitemapController::class, 'projects'])->name('sitemap.projects');
Route::get('/sitemap-images.xml', [SitemapController::class, 'images'])->name('sitemap.images');
Route::get('/sitemap-blog.xml', [SitemapController::class, 'blog'])->name('sitemap.blog');
Route::get('/sitemap-services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/sitemap-materials.xml', [SitemapController::class, 'materials'])->name('sitemap.materials');
Route::get('/sitemap-cities.xml', [SitemapController::class, 'cities'])->name('sitemap.cities');
Route::get('/sitemap-neighborhoods.xml', [SitemapController::class, 'neighborhoods'])->name('sitemap.neighborhoods');

// Fallback route for storage files (when symlink is missing)
Route::get('/storage/{path}', function (string $path) {
    if (str_contains($path, '..')) {
        abort(404);
    }
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    if (!$disk->exists($path)) {
        abort(404);
    }
    return response()->file($disk->path($path));
})->where('path', '.*');


