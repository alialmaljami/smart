<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait ImageUploadHelper
{
    protected array $sizes = [
        'thumb' => [300, 200],
        'medium' => [800, 600],
        'large' => [1600, 1200],
    ];

    protected int $quality = 70;

    public function uploadImage(UploadedFile $file, string $directory = 'images', ?string $oldPath = null): string
    {
        if ($oldPath) {
            $this->deleteImageFiles($oldPath, $directory);
        }

        $manager = new ImageManager(new Driver());
        $counter = (int)(microtime(true) * 10000);
        $filename = 'ديكورات المصمم الذكي 0541232717 (' . $counter . ').webp';
        $relativePath = $directory . '/' . $filename;

        $image = $manager->decodePath($file->getRealPath());
        $this->ensureDirectoryExists($directory);
        $image->save(storage_path('app/public/' . $relativePath));

        foreach ($this->sizes as $size => [$width, $height]) {
            $this->ensureDirectoryExists($directory . '/' . $size);
            $resized = $manager->decodePath($file->getRealPath());
            $resized->cover($width, $height);
            $sizePath = $directory . '/' . $size . '/' . $filename;
            $resized->save(storage_path('app/public/' . $sizePath), quality: $this->quality);
        }

        return $relativePath;
    }

    public function uploadImagesArray(array $files, string $directory = 'images', array $oldPaths = []): array
    {
        $paths = [];
        foreach ($files as $i => $file) {
            if ($file instanceof UploadedFile) {
                $old = $oldPaths[$i] ?? null;
                $paths[] = $this->uploadImage($file, $directory, $old);
            }
        }
        return $paths;
    }

    protected function ensureDirectoryExists(string $directory): void
    {
        $full = storage_path('app/public/' . $directory);
        if (!is_dir($full)) {
            mkdir($full, 0755, true);
        }
    }

    public function deleteImageFiles(string $path, string $directory = 'images'): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        $filename = basename($path);
        foreach (array_keys($this->sizes) as $size) {
            $sizePath = $directory . '/' . $size . '/' . $filename;
            if (Storage::disk('public')->exists($sizePath)) {
                Storage::disk('public')->delete($sizePath);
            }
        }
    }
}
