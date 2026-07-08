<?php
// Migration script: Create tags table + taggables pivot, populate from existing data
// Upload this file and run it ONCE after deploying new code

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

echo "=== Tags Migration Script ===\n\n";

$success = 0;
$errors = 0;

// 1. Create tags table
echo "1. Creating tags table...\n";
try {
    if (!Schema::hasTable('tags')) {
        Schema::create('tags', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
        echo "   ✓ Tags table created\n";
    } else {
        echo "   - Tags table already exists\n";
    }
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 2. Create taggables pivot table
echo "2. Creating taggables pivot table...\n";
try {
    if (!Schema::hasTable('taggables')) {
        Schema::create('taggables', function ($table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');
            $table->timestamps();
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        });
        echo "   ✓ Taggables table created\n";
    } else {
        echo "   - Taggables table already exists\n";
    }
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 3. Extract unique tags from all models
echo "3. Extracting unique tags from existing data...\n";
try {
    $allTagNames = [];
    $tables = ['blog_posts', 'projects', 'galleries', 'materials'];

    foreach ($tables as $table) {
        if (Schema::hasColumn($table, 'tags')) {
            $rows = DB::table($table)->whereNotNull('tags')->where('tags', '!=', '[]')->where('tags', '!=', '"[]"')->get(['id', 'tags']);
            foreach ($rows as $row) {
                $tags = json_decode($row->tags, true);
                if (is_array($tags)) {
                    foreach ($tags as $tag) {
                        $t = trim($tag);
                        if ($t !== '') $allTagNames[] = $t;
                    }
                }
            }
        }
    }

    $allTagNames = array_unique($allTagNames);
    echo "   ✓ Found " . count($allTagNames) . " unique tag names\n";
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 4. Create tags & map names to IDs
echo "4. Creating tag records...\n";
try {
    $tagMap = [];
    foreach ($allTagNames as $name) {
        $slug = Str::slug($name);
        // Check if tag already exists
        $existing = DB::table('tags')->where('slug', $slug)->first();
        if ($existing) {
            $tagMap[$name] = $existing->id;
        } else {
            $id = DB::table('tags')->insertGetId([
                'name' => $name,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $tagMap[$name] = $id;
        }
    }
    echo "   ✓ Created/mapped " . count($tagMap) . " tags\n";
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 5. Link existing records to tags in pivot table
echo "5. Populating taggables pivot table...\n";
try {
    $typeMap = [
        'blog_posts' => 'App\Models\BlogPost',
        'projects' => 'App\Models\Project',
        'galleries' => 'App\Models\Gallery',
        'materials' => 'App\Models\Material',
    ];

    $pivotCount = 0;
    foreach ($typeMap as $table => $modelClass) {
        if (!Schema::hasColumn($table, 'tags')) continue;
        $rows = DB::table($table)->whereNotNull('tags')->where('tags', '!=', '[]')->where('tags', '!=', '"[]"')->get(['id', 'tags']);
        foreach ($rows as $row) {
            $tags = json_decode($row->tags, true);
            if (!is_array($tags)) continue;
            foreach ($tags as $tag) {
                $t = trim($tag);
                if ($t === '' || !isset($tagMap[$t])) continue;
                $exists = DB::table('taggables')
                    ->where('tag_id', $tagMap[$t])
                    ->where('taggable_id', $row->id)
                    ->where('taggable_type', $modelClass)
                    ->exists();
                if (!$exists) {
                    DB::table('taggables')->insert([
                        'tag_id' => $tagMap[$t],
                        'taggable_id' => $row->id,
                        'taggable_type' => $modelClass,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $pivotCount++;
                }
            }
        }
    }
    echo "   ✓ Created $pivotCount pivot records\n";
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

echo "\n=== Migration Complete ===\n";
echo "Success: $success, Errors: $errors\n";
echo "\nIMPORTANT: Delete this file after successful migration!\n";
