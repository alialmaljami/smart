<?php
set_time_limit(300);
$base = __DIR__ . '/';

function extractZip($path, $dest) {
    $zip = zip_open($path);
    if (!is_resource($zip)) die("Cannot open zip: $path");
    echo "Extracting: " . basename($path) . " -> $dest\n";
    $count = 0;
    while ($entry = zip_read($zip)) {
        $name = zip_entry_name($entry);
        $file = $dest . $name;
        if (substr($name, -1) === '/') {
            @mkdir($file, 0755, true);
        } else {
            @mkdir(dirname($file), 0755, true);
            if (zip_entry_open($zip, $entry, 'r')) {
                $buf = zip_entry_read($entry, zip_entry_filesize($entry));
                file_put_contents($file, $buf);
                zip_entry_close($entry);
                $count++;
            }
        }
    }
    zip_close($zip);
    echo "  Extracted $count files\n";
}

echo "<pre>";

// 1. Extract project files
extractZip($base . 'project_upload.zip', $base);

// 2. Extract images into storage/app/public
@mkdir($base . 'storage/app/public', 0755, true);
extractZip($base . 'images_backup.zip', $base . 'storage/app/public/');

// 3. Remove old smart.zip
if (file_exists($base . 'smart.zip')) {
    unlink($base . 'smart.zip');
    echo "Removed old smart.zip\n";
}

// 4. Set permissions
echo "Setting permissions...\n";
$dirs = ['storage', 'bootstrap/cache', 'public/build'];
foreach ($dirs as $d) {
    $p = $base . $d;
    if (is_dir($p)) {
        chmod($p, 0755);
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($p));
        foreach ($it as $f) {
            if ($f->isFile()) chmod($f, 0644);
            if ($f->isDir()) chmod($f, 0755);
        }
    }
}

echo "\nDone! Extraction complete.\n";
echo "</pre>";
