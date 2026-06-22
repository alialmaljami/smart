<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WatermarkService;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class WatermarkDiagnosticController extends Controller
{
    public function index()
    {
        $manager = new ImageManager(new Driver());
        $watermark = new WatermarkService();

        $info = [];

        // Check font
        $info['font_path'] = $watermark->fontPath;
        $info['font_exists'] = file_exists($watermark->fontPath);
        if ($info['font_exists']) {
            $bbox = imagettfbbox(20, 0, $watermark->fontPath, 'Test');
            $info['font_bbox'] = $bbox ? 'OK' : 'FAILED';
        }

        // Check settings
        $info['watermark_type'] = $watermark->type;
        $info['watermark_opacity'] = $watermark->opacity;
        $info['watermark_position'] = $watermark->position;
        $info['watermark_size'] = $watermark->size;

        // Try to actually render a test image
        try {
            $img = imagecreatetruecolor(400, 200);
            imagefill($img, 0, 0, imagecolorallocate($img, 50, 50, 80));

            $text = 'Test Watermark ديكورات';
            $fontSize = 20;
            $bbox = imagettfbbox($fontSize, 0, $watermark->fontPath, $text);
            if ($bbox) {
                $textW = abs($bbox[2] - $bbox[0]);
                $textH = abs($bbox[7] - $bbox[1]);
                $baseY = abs($bbox[7]);
                $x = 200 - $textW / 2;
                $y = 100 + $baseY / 2;
                $color = imagecolorallocatealpha($img, 255, 255, 255, 60);
                $result = imagettftext($img, $fontSize, 0, intval($x), intval($y), $color, $watermark->fontPath, $text);
                $info['text_rendered'] = $result ? 'YES' : 'FAILED';
            } else {
                $info['text_rendered'] = 'bbox FAILED';
            }

            ob_start();
            imagepng($img);
            $pngData = ob_get_clean();
            imagedestroy($img);

            $info['test_image_base64'] = base64_encode($pngData);
        } catch (\Throwable $e) {
            $info['error'] = $e->getMessage();
        }

        // Storage diagnostics
        $info['public_storage_exists'] = is_dir(public_path('storage'));
        $info['public_storage_is_link'] = is_link(public_path('storage'));
        if ($info['public_storage_is_link']) {
            $info['public_storage_target'] = readlink(public_path('storage'));
        }
        $info['storage_app_public_exists'] = is_dir(storage_path('app/public'));

        // Check last gallery image
        $lastGallery = \App\Models\Gallery::latest()->first();
        if ($lastGallery) {
            $info['last_gallery_id'] = $lastGallery->id;
            $info['last_gallery_image_db'] = $lastGallery->image;
            $fullPath = storage_path('app/public/' . $lastGallery->image);
            $info['last_gallery_file_exists'] = file_exists($fullPath);
            $info['last_gallery_file_path'] = $fullPath;
            $info['last_gallery_url'] = asset('storage/' . $lastGallery->image);
        }

        return view('admin.watermark-diagnostic', compact('info'));
    }
}
