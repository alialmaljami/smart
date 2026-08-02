<?php
/**
 * Standalone seed script for the 20 new PDF articles.
 * Upload to public/ then visit in browser.
 * DELETE THIS FILE after use!
 */

ini_set('display_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $blogCatIds = DB::table('categories')->where('type', 'blog')->pluck('id', 'slug')->toArray();
    if (empty($blogCatIds)) {
        die('ERROR: No blog categories found.');
    }

    $articles = require __DIR__ . '/../data/blog_articles_20new.php';
    $log = [];
    $created = 0;
    $skipped = 0;

    foreach ($articles as $article) {
        $exists = DB::table('blog_posts')->where('slug', $article['slug'])->exists();
        if ($exists) {
            $log[] = "SKIP: {$article['slug']}";
            $skipped++;
            continue;
        }

        $catId = $blogCatIds[$article['cat_slug']] ?? null;

        $postId = DB::table('blog_posts')->insertGetId([
            'title' => $article['title'],
            'slug' => $article['slug'],
            'content' => $article['content'],
            'excerpt' => $article['excerpt'],
            'blog_category_id' => $catId,
            'category' => $article['cat_slug'],
            'is_active' => 1,
            'views' => 0,
            'meta_title' => $article['meta_title'],
            'meta_description' => $article['meta_description'],
            'meta_keywords' => $article['meta_keywords'],
            'tags' => json_encode($article['tags'], JSON_UNESCAPED_UNICODE),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        foreach ($article['tags'] as $tagName) {
            $tag = App\Models\Tag::firstOrCreate(
                ['slug' => Illuminate\Support\Str::slug($tagName)],
                ['name' => $tagName]
            );
            DB::table('taggables')->insert([
                'tag_id' => $tag->id,
                'taggable_type' => App\Models\BlogPost::class,
                'taggable_id' => $postId,
            ]);
        }

        $log[] = "CREATED: {$article['title']}";
        $created++;
    }

    echo "<h1>Seed Complete</h1>";
    echo "<p>Created: {$created} | Skipped: {$skipped}</p>";
    echo "<pre>" . implode("\n", $log) . "</pre>";
    echo "<p><b>DELETE this file after use!</b></p>";
} catch (Throwable $e) {
    echo "<h2 style='color:red'>ERROR</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
