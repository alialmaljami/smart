<?php

namespace App\Services;

class ImageService
{
    public static function webp(string $path): string
    {
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);
        if ($webpPath !== $path && file_exists(public_path($webpPath))) {
            return $webpPath;
        }
        return $path;
    }

    public static function asset(string $storagePath): string
    {
        $path = 'storage/' . ltrim($storagePath, '/');
        return asset(self::webp($path));
    }
}
