<?php
// Bootstrap Laravel to use its autoloader
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$tokenPath = __DIR__ . '/../storage/google-token.json';
if (!file_exists($tokenPath)) {
    die('Token file not found at: ' . $tokenPath);
}
$token = json_decode(file_get_contents($tokenPath), true);
$accessToken = $token['access_token'] ?? '';
if (empty($accessToken)) {
    die('Access token is empty');
}

$property = 'sc-domain:smartdecorat.com';
$output = [];

// Test token by listing sitemaps
$ch = curl_init('https://www.googleapis.com/webmasters/v3/sites/' . rawurlencode($property) . '/sitemaps');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 20,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ],
]);
$listResponse = curl_exec($ch);
$listHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$output[] = '=== List Sitemaps (HTTP ' . $listHttpCode . ') ===';
$output[] = $listResponse;
$output[] = '';

// Submit each sitemap
$sitemaps = [
    'https://smartdecorat.com/sitemap.xml',
    'https://smartdecorat.com/sitemap-pages.xml',
    'https://smartdecorat.com/sitemap-projects.xml',
    'https://smartdecorat.com/sitemap-images.xml',
    'https://smartdecorat.com/sitemap-blog.xml',
    'https://smartdecorat.com/sitemap-services.xml',
    'https://smartdecorat.com/sitemap-materials.xml',
    'https://smartdecorat.com/sitemap-cities.xml',
    'https://smartdecorat.com/sitemap-neighborhoods.xml',
];

$output[] = '=== Submit Sitemaps ===';
foreach ($sitemaps as $sitemap) {
    $feedpath = rawurlencode($sitemap);
    $url = 'https://www.googleapis.com/webmasters/v3/sites/' . rawurlencode($property) . '/sitemaps/' . $feedpath;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
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
    $output[] = $name . ' => HTTP ' . $httpCode . ($curlError ? ' (cURL: ' . $curlError . ')' : '');
    if ($resp) {
        $output[] = '  Response: ' . $resp;
    }
}

// IndexNow (Bing)
$indexnowKey = '0501cb62e0d2433c9297f1a79a1212a7';
$keyFilePath = __DIR__ . '/' . $indexnowKey . '.txt';
if (!file_exists($keyFilePath)) {
    file_put_contents($keyFilePath, $indexnowKey);
}
$output[] = '';
$output[] = '=== IndexNow (Bing) ===';
foreach ($sitemaps as $sitemap) {
    $url = 'https://www.bing.com/indexnow?url=' . urlencode($sitemap) . '&key=' . urlencode($indexnowKey);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $name = basename(parse_url($sitemap, PHP_URL_PATH));
    $output[] = $name . ' => HTTP ' . $httpCode;
}

echo '<pre>' . implode("\n", $output) . '</pre>';
