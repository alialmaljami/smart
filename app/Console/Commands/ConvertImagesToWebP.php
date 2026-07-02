<?php

namespace App\Console\Commands;

use App\Services\ImageService;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class ConvertImagesToWebP extends Command
{
    protected $signature = 'images:webp {dir=storage/app/public}';
    protected $description = 'Convert all JPG/PNG images in storage to WebP';

    public function handle()
    {
        $dir = $this->argument('dir');
        $fullPath = storage_path(ltrim($dir, 'storage/app/'));
        if (!is_dir($fullPath)) {
            $fullPath = base_path($dir);
        }
        if (!is_dir($fullPath)) {
            $this->error("Directory not found: $dir");
            return 1;
        }

        $finder = new Finder();
        $finder->files()->in($fullPath)->name('/\.(jpg|jpeg|png)$/i');
        $count = 0;

        foreach ($finder as $file) {
            $source = $file->getRealPath();
            $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $source);
            if (file_exists($webpPath)) continue;

            $publicPath = 'storage/' . $file->getRelativePathname();
            $webpPublic = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $publicPath);

            \App\Services\ImageService::webp($publicPath);
            if (file_exists($webpPath)) {
                $count++;
                $this->line("Converted: " . $file->getRelativePathname());
            }
        }

        $this->info("Done! Converted $count images to WebP.");
        return 0;
    }
}
