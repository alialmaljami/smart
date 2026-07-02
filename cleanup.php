<?php
$files = [
    __DIR__ . '/../public/check_tags.php',
    __DIR__ . '/../public/debug_material.php',
    __DIR__ . '/../public/debug_post.php',
    __DIR__ . '/../public/fix_blog_tags.php',
    __DIR__ . '/../public/fix_gallery_tags.php',
    __DIR__ . '/../public/fix_homepage.php',
    __DIR__ . '/../public/fix_project_tags.php',
    __DIR__ . '/../public/fix_unicode_batch1.php',
    __DIR__ . '/../public/fix_unicode_all.php',
    __DIR__ . '/../public/check_post.php',
    __DIR__ . '/../public/check_db.php',
    __DIR__ . '/../public/clear_cache.php',
    __DIR__ . '/../public/fix_all_unicode.php',
];
$count = 0;
foreach ($files as $f) {
    if (file_exists($f)) {
        unlink($f);
        $count++;
    }
}
echo "Removed $count temp files\n";
