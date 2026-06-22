<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Project;
use App\Models\Service;
use App\Services\WatermarkService;
use App\Traits\ImageUploadHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class WatermarkRegenerate extends Command
{
    use ImageUploadHelper;

    protected $signature = 'watermark:regenerate {--dry-run : Show what will be processed without making changes}';
    protected $description = 'Re-apply watermark to all existing images';

    protected array $models = [
        'projects' => ['model' => Project::class, 'fields' => ['image']],
        'galleries' => ['model' => Gallery::class, 'fields' => ['image']],
        'blog_posts' => ['model' => BlogPost::class, 'fields' => ['image']],
        'materials' => ['model' => Material::class, 'fields' => ['image']],
    ];

    public function handle(): int
    {
        $watermark = new WatermarkService();
        $dryRun = $this->option('dry-run');
        $manager = new ImageManager(new Driver());
        $total = 0;

        foreach ($this->models as $label => $cfg) {
            $records = $cfg['model']::whereNotNull('image')->get();
            foreach ($records as $record) {
                foreach ($cfg['fields'] as $field) {
                    $path = $record->$field;
                    if (empty($path)) continue;
                    if (!Storage::disk('public')->exists($path)) continue;

                    $total++;
                    $fullPath = storage_path('app/public/' . $path);
                    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

                    if ($dryRun) {
                        $this->line("[DRY] {$path}");
                        continue;
                    }

                    try {
                        $image = $manager->decodePath($fullPath);
                        $watermark->apply($image);
                        $image->save($fullPath, quality: 85);
                        $this->line("✓ {$path}");
                    } catch (\Exception $e) {
                        $this->error("✗ {$path}: {$e->getMessage()}");
                    }
                }

                // Also process sub-sizes (thumb, medium, large)
                $dir = dirname($record->image ?? '');
                $filename = basename($record->image ?? '');
                if ($dir === '.') $dir = '';

                foreach (['thumb', 'medium', 'large'] as $size) {
                    $sizePath = ($dir ? $dir . '/' : '') . $size . '/' . $filename;
                    if (empty($filename)) continue;
                    if (!Storage::disk('public')->exists($sizePath)) continue;

                    $total++;
                    $sizeFull = storage_path('app/public/' . $sizePath);

                    if ($dryRun) {
                        $this->line("[DRY] {$sizePath}");
                        continue;
                    }

                    try {
                        $image = $manager->decodePath($sizeFull);
                        $watermark->apply($image);
                        $image->save($sizeFull, quality: 85);
                        $this->line("✓ {$sizePath}");
                    } catch (\Exception $e) {
                        $this->error("✗ {$sizePath}: {$e->getMessage()}");
                    }
                }
            }
        }

        if ($dryRun) {
            $this->info("Dry run: {$total} images would be processed.");
        } else {
            $this->info("Done! Watermark applied to {$total} images.");
        }

        return self::SUCCESS;
    }
}
