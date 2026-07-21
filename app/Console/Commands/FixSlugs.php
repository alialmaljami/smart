<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\City;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Neighborhood;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tag;
use App\Models\VisitorQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FixSlugs extends Command
{
    protected $signature = 'slugs:fix {--dry-run : Show changes without saving}';
    protected $description = 'Fix slugs that contain spaces, uppercase, or special characters';

    protected array $models = [
        'projects' => Project::class,
        'blog_posts' => BlogPost::class,
        'services' => Service::class,
        'materials' => Material::class,
        'cities' => City::class,
        'neighborhoods' => Neighborhood::class,
        'galleries' => Gallery::class,
        'tags' => Tag::class,
        'visitor_questions' => VisitorQuestion::class,
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $totalFixed = 0;

        foreach ($this->models as $table => $modelClass) {
            $model = new $modelClass;
            $items = $model->where('slug', 'like', '% %')
                ->orWhere('slug', 'like', '%(%')
                ->orWhereRaw('slug != BINARY LOWER(slug)')
                ->get();

            if ($items->isEmpty()) {
                continue;
            }

            $this->info("{$table}: Found " . $items->count() . " slugs to fix");

            foreach ($items as $item) {
                $oldSlug = $item->slug;
                $newSlug = $this->cleanSlug($oldSlug);

                if ($newSlug === $oldSlug) {
                    continue;
                }

                $newSlug = $this->resolveDuplicate($model, $modelClass, $newSlug, $item->id);

                if ($dryRun) {
                    $this->line("  [DRY-RUN] \"{$oldSlug}\" → \"{$newSlug}\"");
                } else {
                    $item->slug = $newSlug;
                    $item->save();
                    $this->line("  Fixed: \"{$oldSlug}\" → \"{$newSlug}\"");
                }
                $totalFixed++;
            }
        }

        if ($totalFixed === 0) {
            $this->info('All slugs are clean.');
        } else {
            $this->info("Total: {$totalFixed} slugs " . ($dryRun ? 'would be' : '') . ' fixed.');
        }

        return Command::SUCCESS;
    }

    protected function cleanSlug(string $slug): string
    {
        $slug = Str::slug($slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }

    protected function resolveDuplicate($query, string $modelClass, string $slug, int $exceptId): string
    {
        $original = $slug;
        $counter = 2;

        while ($query->where('slug', $slug)->where('id', '!=', $exceptId)->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
