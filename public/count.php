<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$static = ['/', '/about', '/services', '/contact', '/faq', '/privacy', '/terms', '/gallery', '/blog', '/projects', '/materials', '/search', '/jeddah-decoration', '/mecca-decoration'];

echo "Static: " . count($static) . "\n";

echo "Blog posts: " . DB::table('blog_posts')->where('is_active', 1)->count() . "\n";
echo "Projects: " . DB::table('projects')->where('is_active', 1)->count() . "\n";
echo "Materials: " . DB::table('materials')->where('is_active', 1)->count() . "\n";
echo "Material categories: " . DB::table('categories')->where('type', 'material')->where('is_active', 1)->count() . "\n";
echo "Services: " . DB::table('services')->where('is_active', 1)->count() . "\n";
echo "Gallery pages: " . DB::table('galleries')->where('is_active', 1)->count() . "\n";
echo "Service detail: " . DB::table('services')->where('is_active', 1)->count() . "\n";

$total = count($static)
    + DB::table('blog_posts')->where('is_active', 1)->count()
    + DB::table('projects')->where('is_active', 1)->count()
    + DB::table('materials')->where('is_active', 1)->count()
    + DB::table('categories')->where('type', 'material')->where('is_active', 1)->count()
    + DB::table('services')->where('is_active', 1)->count()
    + DB::table('galleries')->where('is_active', 1)->count();

echo "---\nTotal pages: $total\n";
