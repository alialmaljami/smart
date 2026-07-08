<?php

namespace App\Services;

class ImageService
{
    const SIZES = ['thumb' => [300, 200], 'medium' => [800, 600], 'large' => [1600, 1200]];

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

    public static function asset(?string $storagePath): string
    {
        if (!$storagePath) return '';
        $path = 'storage/' . ltrim($storagePath, '/');
        return asset(self::webp($path));
    }

    public static function sized(string $storagePath, string $size = 'medium'): string
    {
        if (!isset(self::SIZES[$size])) {
            return self::asset($storagePath);
        }
        $dir = dirname($storagePath);
        $file = basename($storagePath);
        $sizedPath = $dir . '/' . $size . '/' . $file;
        $full = storage_path('app/public/' . $sizedPath);
        if (file_exists($full)) {
            return asset('storage/' . self::webp($sizedPath));
        }
        return self::asset($storagePath);
    }

    public static function srcset(string $storagePath): string
    {
        $parts = [];
        foreach (['thumb' => 300, 'medium' => 800, 'large' => 1600] as $size => $width) {
            $url = self::sized($storagePath, $size);
            $parts[] = $url . ' ' . $width . 'w';
        }
        return implode(', ', $parts);
    }

    public static function avif(string $path): string
    {
        $avifPath = preg_replace('/\.(jpg|jpeg|png|webp)$/i', '.avif', $path);
        if ($avifPath === $path) {
            return $path;
        }
        $fullPath = public_path($avifPath);
        if (file_exists($fullPath)) {
            return $avifPath;
        }
        $origPath = public_path($path);
        if (file_exists($origPath)) {
            $img = @imagecreatefromstring(file_get_contents($origPath));
            if ($img) {
                $dir = dirname($fullPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                @imageavif($img, $fullPath, 80);
                imagedestroy($img);
                if (file_exists($fullPath)) {
                    return $avifPath;
                }
            }
        }
        return $path;
    }

    public static function picture(?string $storagePath, string $alt = '', string $class = '', array $attrs = []): string
    {
        if (!$storagePath) return '';
        $path = 'storage/' . ltrim($storagePath, '/');
        $fullUrl = asset($path);
        $webpUrl = asset(self::webp($path));
        $avifUrl = asset(self::avif($path));
        $attrStr = '';
        foreach ($attrs as $k => $v) {
            $attrStr .= ' ' . $k . '="' . e($v) . '"';
        }
        $html = '<picture' . ($class ? ' class="' . e($class) . '"' : '') . '>';
        if ($avifUrl !== $fullUrl) {
            $html .= '<source srcset="' . $avifUrl . '" type="image/avif">';
        }
        if ($webpUrl !== $fullUrl) {
            $html .= '<source srcset="' . $webpUrl . '" type="image/webp">';
        }
        $html .= '<img src="' . $fullUrl . '" alt="' . e($alt) . '" loading="lazy"' . ($class ? ' class="' . e($class) . '"' : '') . $attrStr . '>';
        $html .= '</picture>';
        return $html;
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
