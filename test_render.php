<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
try {
    $html = view('layouts.app')->render();
    file_put_contents(__DIR__ . '/test_output.html', $html);
    echo 'RENDERED: ' . strlen($html) . ' bytes';
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
