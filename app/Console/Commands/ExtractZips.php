<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class ExtractZips extends Command
{
    protected $signature = 'storage:extract-zips {--dir= : Directory to scan for zips}';
    protected $description = 'Extract zip archives from storage/app/public';

    public function handle(): void
    {
        $dir = $this->option('dir') ?: storage_path('app/public');

        if (!is_dir($dir)) {
            $this->warn("Directory not found: $dir");
            return;
        }

        $zips = glob("$dir/*.zip");
        if (empty($zips)) {
            $this->info('No zip files found.');
            return;
        }

        foreach ($zips as $zipPath) {
            $basename = basename($zipPath, '.zip');
            $this->info("Extracting: $basename.zip");

            $targetDir = $this->resolveTargetDir($dir, $basename);
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipPath) !== true) {
                $this->error("Failed to open: $basename.zip");
                continue;
            }

            $zip->extractTo($targetDir);
            $zip->close();

            unlink($zipPath);
            $this->info("Extracted and removed: $basename.zip");
        }

        $this->info('Done.');
    }

    private function resolveTargetDir(string $baseDir, string $basename): string
    {
        $dirMap = [
            'blog-part1' => 'blog',
            'blog-part2' => 'blog',
            'blog-part3' => 'blog',
            'blog-part4' => 'blog',
            'galleries' => 'galleries',
            'homepage' => 'homepage',
            'living-rooms' => 'living-rooms',
            'projects' => 'projects',
            'services' => 'services',
            'settings' => 'settings',
            'images' => '',
        ];

        $sub = $dirMap[$basename] ?? $basename;
        return $sub === '' ? $baseDir : $baseDir . '/' . $sub;
    }
}
