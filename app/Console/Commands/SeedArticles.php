<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SeedArticles extends Command
{
    protected $signature = 'blog:seed-articles {--dry-run}';
    protected $description = 'Seed 20 SEO blog articles targeting Saudi/Makkah/Jeddah keywords';

    public function handle(): int
    {
        $blogCatIds = Category::where('type', 'blog')->pluck('id', 'slug')->toArray();
        if (empty($blogCatIds)) {
            $this->error('No blog categories found. Run php artisan blog:create-categories first.');
            return 1;
        }

        $this->info('Blog categories found: ' . count($blogCatIds));

        $articles = $this->getArticles($blogCatIds);
        $created = 0;
        $skipped = 0;

        foreach ($articles as $article) {
            $exists = BlogPost::where('slug', $article['slug'])->exists();
            if ($exists) {
                $this->line("  SKIP: {$article['slug']} (already exists)");
                $skipped++;
                continue;
            }

            if (!$this->option('dry-run')) {
                $post = BlogPost::create([
                    'title' => $article['title'],
                    'slug' => $article['slug'],
                    'content' => $article['content'],
                    'excerpt' => $article['excerpt'],
                    'blog_category_id' => $blogCatIds[$article['cat_slug']] ?? null,
                    'category' => $article['cat_slug'],
                    'is_active' => true,
                    'views' => 0,
                    'meta_title' => $article['meta_title'],
                    'meta_description' => $article['meta_description'],
                    'meta_keywords' => $article['meta_keywords'],
                    'tags' => $article['tags'],
                ]);

                foreach ($article['tags'] as $tagName) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $post->tagItems()->attach($tag->id);
                }
            }

            $this->info("  CREATED: {$article['title']}");
            $created++;
        }

        $this->info("Done. Created: {$created}, Skipped: {$skipped}");
        return 0;
    }

    protected function getArticles(array $catIds): array
    {
        return require __DIR__ . '/../../data/blog_articles.php';
    }
}
