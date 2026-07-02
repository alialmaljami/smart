<?php
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Current Dir: " . __DIR__ . "\n\n";

echo "--- Directory Listing (" . __DIR__ . ") ---\n";
$files = scandir(__DIR__);
foreach ($files as $f) {
    $size = is_file($f) ? filesize($f) : 0;
    echo ($size ? str_pad(number_format($size), 12, " ", STR_PAD_LEFT) : "      DIR") . "  $f\n";
}

echo "\n--- Functions ---\n";
$funcs = ['shell_exec','exec','system','passthru','zip_open','ZipArchive'];
foreach ($funcs as $f) {
    echo "$f: " . (function_exists($f) ? "YES" : "NO") . "\n";
}
echo "</pre>";
