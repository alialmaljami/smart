<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Fix double-encoded JSON in projects
$projects = DB::table('projects')->whereNotNull('images')->get();
foreach ($projects as $p) {
    $decoded = json_decode($p->images);
    if (is_string($decoded)) {
        DB::table('projects')->where('id', $p->id)->update(['images' => $decoded]);
        echo "Fixed project {$p->id}" . PHP_EOL;
    } else {
        echo "Project {$p->id} OK" . PHP_EOL;
    }
}

// Also fix services
$services = DB::table('services')->whereNotNull('images')->get();
foreach ($services as $s) {
    $decoded = json_decode($s->images);
    if (is_string($decoded)) {
        DB::table('services')->where('id', $s->id)->update(['images' => $decoded]);
        echo "Fixed service {$s->id}" . PHP_EOL;
    } else if (is_array($decoded)) {
        echo "Service {$s->id} OK (array)" . PHP_EOL;
    } else {
        echo "Service {$s->id} - null/other" . PHP_EOL;
    }
}

echo PHP_EOL . "Verification:" . PHP_EOL;
$p = App\Models\Project::first();
echo "Project images type: " . gettype($p->images) . PHP_EOL;
echo "Project images: " . json_encode($p->images, JSON_UNESCAPED_UNICODE) . PHP_EOL;
if (is_array($p->images)) {
    echo "First image: {$p->images[0]}" . PHP_EOL;
}
