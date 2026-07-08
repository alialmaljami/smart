<?php
// Clear Laravel view cache and OPcache

// 1. Clear view cache (compiled Blade files)
$viewCache = __DIR__ . '/../storage/framework/views/';
$files = glob($viewCache . '*');
$count = 0;
foreach ($files as $file) {
    if (is_file($file) && str_ends_with($file, '.php')) {
        unlink($file);
        $count++;
    }
}
echo "Cleared $count view cache files.\n";

// 2. Clear OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache reset.\n";
} else {
    echo "OPcache not available.\n";
}

echo "Cache cleared successfully!\n";
