<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class GoogleSearchConsoleController extends Controller
{
    public function index(): View
    {
        $gscCode = Setting::getValue('google_search_console', '');
        $gaId = Setting::getValue('google_analytics_id', '');
        $indexNowKey = Setting::getValue('indexnow_key', '');
        $verified = !empty($gscCode);
        $metaTagPresent = false;

        if ($verified) {
            $homeUrl = url('/');
            $homeHtml = @file_get_contents($homeUrl);
            if ($homeHtml !== false) {
                $metaTagPresent = str_contains($homeHtml, $gscCode);
            }
        }

        return view('admin.google-search-console.index', compact(
            'gscCode', 'gaId', 'indexNowKey', 'verified', 'metaTagPresent'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $keys = ['google_search_console', 'google_analytics_id'];
        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key) ?? '']);
            }
        }

        return redirect()->route('admin.google-search-console')
            ->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    public function checkMeta(): \Illuminate\Http\JsonResponse
    {
        $gscCode = Setting::getValue('google_search_console', '');
        if (empty($gscCode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم إدخال رمز التحقق بعد'
            ]);
        }

        $homeUrl = url('/');
        $context = stream_context_create(['http' => ['timeout' => 10]]);
        $homeHtml = @file_get_contents($homeUrl, false, $context);

        if ($homeHtml === false) {
            return response()->json([
                'status' => 'error',
                'message' => 'تعذر الاتصال بالموقع للتحقق'
            ]);
        }

        $found = str_contains($homeHtml, $gscCode);

        return response()->json([
            'status' => $found ? 'verified' : 'not_found',
            'message' => $found
                ? '✓ تم العثور على رمز التحقق في الصفحة الرئيسية. الموقع جاهز للتحقق في Search Console.'
                : '✗ لم يتم العثور على رمز التحقق. تأكد من حفظ الإعدادات وتحديث صفحة الموقع.'
        ]);
    }

    public function submitSitemaps(): \Illuminate\Http\JsonResponse
    {
        $key = Setting::getValue('indexnow_key', '');
        if (empty($key)) {
            $key = str_replace('-', '', \Illuminate\Support\Str::uuid()->toString());
            Setting::updateOrCreate(['key' => 'indexnow_key'], ['value' => $key]);
        }

        $keyFileUrl = url('/') . '/' . $key . '.txt';
        $keyFileCheck = @file_get_contents($keyFileUrl);
        if ($keyFileCheck === false || trim($keyFileCheck) !== $key) {
            $publicPath = public_path($key . '.txt');
            @file_put_contents($publicPath, $key);
        }

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

        $results = [];

        foreach ($sitemaps as $sitemap) {
            try {
                $response = Http::timeout(10)->get('https://www.bing.com/indexnow', [
                    'url' => $sitemap,
                    'key' => $key,
                ]);
                $results[] = [
                    'sitemap' => basename(parse_url($sitemap, PHP_URL_PATH)),
                    'status' => $response->successful() ? 'ok' : 'error',
                    'http' => $response->status(),
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'sitemap' => basename(parse_url($sitemap, PHP_URL_PATH)),
                    'status' => 'error',
                    'http' => $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'status' => 'done',
            'results' => $results,
        ]);
    }
}
