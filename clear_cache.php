<?php
// Clear Laravel view cache by deleting compiled views
$viewDir = __DIR__ . '/../storage/framework/views';
if (is_dir($viewDir)) {
    $files = glob($viewDir . '/*');
    $count = 0;
    foreach ($files as $f) {
        if (is_file($f) && pathinfo($f, PATHINFO_EXTENSION) === 'php') {
            unlink($f);
            $count++;
        }
    }
    echo "Cleared $count compiled views\n";
} else {
    echo "View directory not found at: $viewDir\n";
    // Try alternative path
    $viewDir2 = __DIR__ . '/storage/framework/views';
    if (is_dir($viewDir2)) {
        $files = glob($viewDir2 . '/*');
        $count = 0;
        foreach ($files as $f) {
            if (is_file($f) && pathinfo($f, PATHINFO_EXTENSION) === 'php') {
                unlink($f);
                $count++;
            }
        }
        echo "Cleared $count compiled views (alt path)\n";
    }
}
echo "Done\n";
