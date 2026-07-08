<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$phone = '0541232717';
$prefix = 'ديكورات المصمم الذكي ' . $phone . ' (';
$counter = 1;

// Collect all image paths from all tables
$paths = [];

// projects.image
foreach (DB::table('projects')->pluck('image') as $v) { if ($v) $paths[$v] = 'projects.image'; }
foreach (DB::table('projects')->pluck('images') as $v) { if ($v) { foreach (json_decode($v, true) ?? [] as $p) { if ($p) $paths[$p] = 'projects.images'; } } }
// services
foreach (DB::table('services')->pluck('image') as $v) { if ($v) $paths[$v] = 'services.image'; }
foreach (DB::table('services')->pluck('images') as $v) { if ($v) { foreach (json_decode($v, true) ?? [] as $p) { if ($p) $paths[$p] = 'services.images'; } } }
// materials
foreach (DB::table('materials')->pluck('image') as $v) { if ($v) $paths[$v] = 'materials.image'; }
foreach (DB::table('materials')->pluck('images') as $v) { if ($v) { foreach (json_decode($v, true) ?? [] as $p) { if ($p) $paths[$p] = 'materials.images'; } } }
// blog_posts
foreach (DB::table('blog_posts')->pluck('image') as $v) { if ($v) $paths[$v] = 'blog_posts.image'; }
foreach (DB::table('blog_posts')->pluck('images') as $v) { if ($v) { foreach (json_decode($v, true) ?? [] as $p) { if ($p) $paths[$p] = 'blog_posts.images'; } } }
// galleries
foreach (DB::table('galleries')->pluck('image') as $v) { if ($v) $paths[$v] = 'galleries.image'; }
// categories
foreach (DB::table('categories')->whereNotNull('image')->pluck('image') as $v) { if ($v) $paths[$v] = 'categories.image'; }
// reviews
foreach (DB::table('reviews')->pluck('image') as $v) { if ($v) $paths[$v] = 'reviews.image'; }
// homepage_sections
foreach (DB::table('homepage_sections')->pluck('image') as $v) { if ($v) $paths[$v] = 'homepage_sections.image'; }
// settings (image-like keys)
$imgKeys = ['logo','favicon','about_image','home_hero_bg'];
foreach (DB::table('settings')->whereIn('key', $imgKeys)->pluck('value') as $v) { if ($v) $paths[$v] = 'settings.' . $v; }

$base = storage_path('app/public');
$renamed = 0;
$mapping = []; // oldRelPath => newRelPath

foreach ($paths as $relPath => $source) {
    // Skip if already renamed
    if (str_contains($relPath, $prefix)) {
        echo "SKIP (already renamed): $relPath\n";
        continue;
    }

    $oldFile = $base . '/' . $relPath;
    if (!file_exists($oldFile)) {
        echo "NOT FOUND: $relPath\n";
        continue;
    }

    $dir = dirname($relPath);
    $ext = pathinfo($relPath, PATHINFO_EXTENSION);
    $newFilename = $prefix . $counter . ').' . $ext;
    $newRelPath = $dir . '/' . $newFilename;
    $newFile = $base . '/' . $newRelPath;

    if (rename($oldFile, $newFile)) {
        echo "RENAMED: $relPath -> $newRelPath\n";
        $mapping[$relPath] = $newRelPath;

        // Also rename sized variants (thumb/, medium/, large/) if they exist
        $dirBasename = basename($dir);
        $dirParent = dirname($dir);
        if ($dirBasename === 'gallery') {
            $parentDir = $dirParent;
        } else {
            $parentDir = $dir;
        }

        foreach (['thumb', 'medium', 'large'] as $size) {
            $oldSizePath = $dir . '/' . $size . '/' . basename($relPath);
            $oldSizeFile = $base . '/' . $oldSizePath;
            if (file_exists($oldSizeFile)) {
                $newSizePath = $dir . '/' . $size . '/' . $newFilename;
                $newSizeFile = $base . '/' . $newSizePath;
                rename($oldSizeFile, $newSizeFile);
                echo "  SIZED ($size): $oldSizePath -> $newSizePath\n";
            }
        }

        $counter++;
        $renamed++;
    } else {
        echo "FAILED: $relPath\n";
    }
}

// Update DB records with new paths
echo "\n--- Updating database ---\n";
$dbUpdated = 0;

foreach ($mapping as $oldRel => $newRel) {
    // projects.image
    if ($updated = DB::table('projects')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "projects.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // services.image
    if ($updated = DB::table('services')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "services.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // materials.image
    if ($updated = DB::table('materials')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "materials.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // blog_posts.image
    if ($updated = DB::table('blog_posts')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "blog_posts.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // galleries.image
    if ($updated = DB::table('galleries')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "galleries.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // categories.image
    if ($updated = DB::table('categories')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "categories.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // reviews.image
    if ($updated = DB::table('reviews')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "reviews.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // homepage_sections.image
    if ($updated = DB::table('homepage_sections')->where('image', $oldRel)->update(['image' => $newRel])) {
        echo "homepage_sections.image: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
    // settings.value (where value matches old path)
    if ($updated = DB::table('settings')->where('value', $oldRel)->update(['value' => $newRel])) {
        echo "settings.value: $oldRel -> $newRel ($updated)\n"; $dbUpdated += $updated;
    }
}

// Handle JSON images arrays
foreach ([
    'projects' => 'images',
    'services' => 'images',
    'materials' => 'images',
    'blog_posts' => 'images',
] as $table => $column) {
    foreach (DB::table($table)->pluck($column, 'id') as $id => $json) {
        if (!$json) continue;
        $arr = json_decode($json, true);
        if (!is_array($arr)) continue;
        $changed = false;
        foreach ($arr as $i => $p) {
            if (isset($mapping[$p])) {
                $arr[$i] = $mapping[$p];
                $changed = true;
            }
        }
        if ($changed) {
            DB::table($table)->where('id', $id)->update([$column => json_encode($arr, JSON_UNESCAPED_UNICODE)]);
            echo "$table.$column (id=$id): updated\n";
            $dbUpdated++;
        }
    }
}

echo "\nDone. Renamed files: $renamed, DB records updated: $dbUpdated\n";
