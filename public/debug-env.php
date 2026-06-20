<?php
header('Content-Type: text/plain');
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "\n";
echo "SCRIPT_FILENAME: " . ($_SERVER['SCRIPT_FILENAME'] ?? 'N/A') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'N/A') . "\n";

echo "\n--- .env file exists: " . (file_exists(__DIR__ . '/../.env') ? 'YES' : 'NO') . " ---\n";
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env');
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line !== '' && !str_starts_with($line, '#')) {
            echo "$line\n";
        }
    }
}

echo "\n--- GETENV ---\n";
echo "APP_KEY: " . (getenv('APP_KEY') ?: 'NOT SET') . "\n";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'NOT SET') . "\n";
echo "DB_DATABASE: " . (getenv('DB_DATABASE') ?: 'NOT SET') . "\n";
echo "DB_USERNAME: " . (getenv('DB_USERNAME') ?: 'NOT SET') . "\n";
echo "DB_PASSWORD: " . (getenv('DB_PASSWORD') ?: 'NOT SET') . "\n";
echo "APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'NOT SET') . "\n";
echo "APP_ENV: " . (getenv('APP_ENV') ?: 'NOT SET') . "\n";
echo "\n_ALL_ env vars:\n";
foreach (getenv() as $k => $v) {
    if (strlen($v) > 100) $v = substr($v, 0, 100) . '...';
    echo "$k=$v\n";
}