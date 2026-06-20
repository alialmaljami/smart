<?php

namespace App\Services;

use App\Models\Setting;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Interfaces\ImageInterface;

class WatermarkService
{
    protected ImageManager $manager;
    public bool $enabled;
    public string $type;
    public int $opacity;
    public string $position;
    public string $size;
    public string $fontPath;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
        $this->enabled = Setting::getValue('watermark_enabled', '1') === '1';
        $this->type = Setting::getValue('watermark_type', 'text');
        $this->opacity = (int) Setting::getValue('watermark_opacity', '40');
        $this->position = Setting::getValue('watermark_position', 'bottom-center');
        $this->size = Setting::getValue('watermark_size', 'medium');

        $fontPath = storage_path('app/public/fonts/Cairo-Bold.ttf');
        if (file_exists($fontPath)) {
            $this->fontPath = $fontPath;
        } else {
            $this->fontPath = 'C:\Windows\Fonts\arabtype.ttf';
        }
    }

    public function apply(ImageInterface $image): ImageInterface
    {
        if (!$this->enabled) {
            return $image;
        }

        if ($this->type === 'logo' || $this->type === 'both') {
            $this->applyLogo($image);
        }

        if ($this->type === 'text' || $this->type === 'both') {
            $this->applyText($image);
        }

        return $image;
    }

    protected function applyText(ImageInterface $image): void
    {
        $text = Setting::getValue('watermark_text', 'ديكورات المصمم الذكي');
        if (empty($text)) return;

        $gd = $image->core()->native();
        $imgW = imagesx($gd);
        $imgH = imagesy($gd);

        $fontSize = match ($this->size) {
            'small' => max(10, intval($imgW / 45)),
            'large' => max(20, intval($imgW / 16)),
            default => max(14, intval($imgW / 28)),
        };

        // Measure text bounding box
        $bbox = imagettfbbox($fontSize, 0, $this->fontPath, $text);
        if (!$bbox) return;
        $textW = abs($bbox[2] - $bbox[0]);
        $textH = abs($bbox[7] - $bbox[1]);
        $baseY = abs($bbox[7]);

        [$x, $y] = $this->getPosition($imgW, $imgH, $textW, $textH);

        $alpha = intval((127 / 100) * (100 - $this->opacity));
        $alpha = min(127, max(0, $alpha));

        $color = imagecolorallocatealpha($gd, 255, 255, 255, $alpha);
        imagettftext($gd, $fontSize, 0, intval($x - $textW / 2), intval($y + $baseY / 2), $color, $this->fontPath, $text);
    }

    protected function applyLogo(ImageInterface $image): void
    {
        $logoPath = Setting::getValue('watermark_logo');
        if (empty($logoPath)) return;

        $logoFull = storage_path('app/public/' . $logoPath);
        if (!file_exists($logoFull)) return;

        $gd = $image->core()->native();
        $imgW = imagesx($gd);
        $imgH = imagesy($gd);

        $logoInfo = getimagesize($logoFull);
        if (!$logoInfo) return;

        $logoGd = imagecreatefromstring(file_get_contents($logoFull));
        if (!$logoGd) return;

        $logoW = imagesx($logoGd);
        $logoH = imagesy($logoGd);

        $scale = match ($this->size) {
            'small' => 0.08,
            'large' => 0.25,
            default => 0.15,
        };
        $targetW = max(30, intval($imgW * $scale));
        $targetH = intval($logoH * ($targetW / max(1, $logoW)));

        $logoResized = imagecreatetruecolor($targetW, $targetH);
        imagefill($logoResized, 0, 0, imagecolorallocatealpha($logoResized, 0, 0, 0, 127));
        imagecopyresampled($logoResized, $logoGd, 0, 0, 0, 0, $targetW, $targetH, $logoW, $logoH);
        imagedestroy($logoGd);

        // Apply alpha
        $alpha = intval((127 / 100) * (100 - $this->opacity));
        imagefilter($logoResized, IMG_FILTER_COLORIZE, 0, 0, 0, $alpha);

        [$x, $y] = $this->getPosition($imgW, $imgH, $targetW, $targetH);

        imagecopy($gd, $logoResized, intval($x - $targetW / 2), intval($y - $targetH / 2), 0, 0, $targetW, $targetH);
        imagedestroy($logoResized);
    }

    protected function getPosition(int $imgW, int $imgH, int $elW, int $elH): array
    {
        $margin = 20;

        $x = match ($this->position) {
            'top-left' => $margin + $elW / 2,
            'top-center' => $imgW / 2,
            'top-right' => $imgW - $margin - $elW / 2,
            'center' => $imgW / 2,
            'bottom-left' => $margin + $elW / 2,
            'bottom-right' => $imgW - $margin - $elW / 2,
            default => $imgW / 2,
        };

        $y = match ($this->position) {
            'top-left', 'top-center', 'top-right' => $margin + $elH / 2,
            'center' => $imgH / 2,
            'bottom-left', 'bottom-center', 'bottom-right' => $imgH - $margin - $elH / 2,
            default => $imgH - $margin - $elH / 2,
        };

        return [intval($x), intval($y)];
    }
}
