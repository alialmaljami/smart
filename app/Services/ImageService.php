<?php

namespace App\Services;

class ImageService
{
    public static function webp(string $path): string
    {
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);
        if ($webpPath === $path) {
            return $path;
        }
        $fullPath = public_path($webpPath);
        if (file_exists($fullPath)) {
            return $webpPath;
        }
        $origPath = public_path($path);
        if (file_exists($origPath)) {
            self::generateWebP($origPath, $fullPath);
            if (file_exists($fullPath)) {
                return $webpPath;
            }
        }
        return $path;
    }

    public static function asset(string $storagePath): string
    {
        $path = 'storage/' . ltrim($storagePath, '/');
        return asset(self::webp($path));
    }

    private static function generateWebP(string $source, string $dest): void
    {
        $dir = dirname($dest);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $info = @getimagesize($source);
        if (!$info) return;
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $img = @imagecreatefromjpeg($source);
                break;
            case IMAGETYPE_PNG:
                $img = @imagecreatefrompng($source);
                if ($img) {
                    imagepalettetotruecolor($img);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                }
                break;
            default:
                return;
        }
        if (!$img) return;
        @imagewebp($img, $dest, 80);
        imagedestroy($img);
    }
}
