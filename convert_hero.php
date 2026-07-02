<?php
$src = __DIR__ . '/public/storage/homepage/QBy2p3HAZTHUhkyofz2Ps6tYpNKpRdu62mNFGNEv.png';
$dst = __DIR__ . '/public/storage/homepage/hero-main.webp';

$info = getimagesize($src);
if ($info[2] === IMAGETYPE_PNG) {
    $img = imagecreatefrompng($src);
    imagepalettetotruecolor($img);
    imagealphablending($img, true);
    imagesavealpha($img, true);
    imagewebp($img, $dst, 80);
    imagedestroy($img);
    echo 'WebP created: ' . filesize($dst) . ' bytes (was ' . filesize($src) . ' bytes)' . PHP_EOL;
    echo 'Reduction: ' . round((1 - filesize($dst)/filesize($src)) * 100) . '%' . PHP_EOL;
}
