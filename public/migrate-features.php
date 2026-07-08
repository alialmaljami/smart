<?php
// Offline migration script for Hostinger (no SSH access)
// Run this ONCE after uploading new files

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Smart Decorations Feature Migration ===\n\n";

$success = 0;
$errors = 0;

// 1. Add type column and new fields to galleries table
echo "1. Adding columns to galleries table...\n";
try {
    if (!Schema::hasColumn('galleries', 'type')) {
        Schema::table('galleries', function ($table) {
            $table->string('type', 50)->default('image')->after('id')->index();
            $table->string('video_url')->nullable()->after('image');
            $table->string('youtube_id')->nullable()->after('video_url');
            $table->string('vimeo_id')->nullable()->after('youtube_id');
            $table->string('tour_url')->nullable()->after('vimeo_id');
            $table->string('before_image')->nullable()->after('tour_url');
            $table->string('after_image')->nullable()->after('before_image');
            $table->boolean('show_comparison')->default(true)->after('after_image');
        });
        echo "   ✓ Columns added\n";
    } else {
        echo "   - type column already exists, checking other columns...\n";
        $addCols = [
            'video_url', 'youtube_id', 'vimeo_id', 'tour_url',
            'before_image', 'after_image', 'show_comparison'
        ];
        foreach ($addCols as $col) {
            if (!Schema::hasColumn('galleries', $col)) {
                Schema::table('galleries', function ($table) use ($col) {
                    if ($col === 'show_comparison') {
                        $table->boolean($col)->default(true);
                    } else {
                        $table->string($col)->nullable();
                    }
                });
                echo "   ✓ Added $col\n";
            }
        }
    }
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 2. Create neighborhoods table
echo "2. Creating neighborhoods table...\n";
try {
    if (!Schema::hasTable('neighborhoods')) {
        Schema::create('neighborhoods', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('city')->default('mecca')->comment('mecca or jeddah');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
        echo "   ✓ Table created\n";
    } else {
        echo "   - Table already exists\n";
    }
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 3. Update existing gallery records to have type='image' if null
echo "3. Updating existing gallery types...\n";
try {
    $updated = DB::table('galleries')->whereNull('type')->update(['type' => 'image']);
    echo "   ✓ Updated $updated records\n";
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 4. Add neighborhood_id to projects table
echo "4. Adding neighborhood_id to projects table...\n";
try {
    if (!Schema::hasColumn('projects', 'neighborhood_id')) {
        Schema::table('projects', function ($table) {
            $table->foreignId('neighborhood_id')->nullable()->constrained()->nullOnDelete()->after('category_id');
        });
        echo "   ✓ Added neighborhood_id column\n";
    } else {
        echo "   - neighborhood_id column already exists\n";
    }
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 5. Insert default neighborhoods for Mecca
echo "5. Inserting default neighborhoods...\n";
try {
    $meccaNeighborhoods = [
        ['name' => 'العزيزية', 'slug' => 'al-azizia-mecca', 'city' => 'mecca'],
        ['name' => 'الششة', 'slug' => 'al-shisha-mecca', 'city' => 'mecca'],
        ['name' => 'الخالدية', 'slug' => 'al-khalidia-mecca', 'city' => 'mecca'],
        ['name' => 'الزاهر', 'slug' => 'al-zahir-mecca', 'city' => 'mecca'],
        ['name' => 'الحمراء', 'slug' => 'al-hamra-mecca', 'city' => 'mecca'],
        ['name' => 'المسفلة', 'slug' => 'al-misfalah-mecca', 'city' => 'mecca'],
        ['name' => 'العوالي', 'slug' => 'al-awali-mecca', 'city' => 'mecca'],
        ['name' => 'الشوقية', 'slug' => 'al-shawqia-mecca', 'city' => 'mecca'],
        ['name' => 'الجميزة', 'slug' => 'al-jummayzah-mecca', 'city' => 'mecca'],
        ['name' => 'الهنداوية', 'slug' => 'al-handawiya-mecca', 'city' => 'mecca'],
        ['name' => 'النزهة', 'slug' => 'al-nuzha-mecca', 'city' => 'mecca'],
        ['name' => 'الرصيفة', 'slug' => 'al-rusayfa-mecca', 'city' => 'mecca'],
    ];
    $jeddahNeighborhoods = [
        ['name' => 'الحمراء', 'slug' => 'al-hamra-jeddah', 'city' => 'jeddah'],
        ['name' => 'الشرفية', 'slug' => 'al-sharafiya-jeddah', 'city' => 'jeddah'],
        ['name' => 'الروضة', 'slug' => 'al-rawdah-jeddah', 'city' => 'jeddah'],
        ['name' => 'المروة', 'slug' => 'al-marwah-jeddah', 'city' => 'jeddah'],
        ['name' => 'الصفا', 'slug' => 'al-safa-jeddah', 'city' => 'jeddah'],
        ['name' => 'النزهة', 'slug' => 'al-nuzha-jeddah', 'city' => 'jeddah'],
        ['name' => 'الزهراء', 'slug' => 'al-zahraa-jeddah', 'city' => 'jeddah'],
        ['name' => 'المحمدية', 'slug' => 'al-muhammadiya-jeddah', 'city' => 'jeddah'],
        ['name' => 'أبحر الشمالية', 'slug' => 'abhr-al-shamalia-jeddah', 'city' => 'jeddah'],
        ['name' => 'السلامة', 'slug' => 'al-salamah-jeddah', 'city' => 'jeddah'],
        ['name' => 'البساتين', 'slug' => 'al-basateen-jeddah', 'city' => 'jeddah'],
        ['name' => 'الكورنيش', 'slug' => 'al-corniche-jeddah', 'city' => 'jeddah'],
    ];
    $count = 0;
    foreach (array_merge($meccaNeighborhoods, $jeddahNeighborhoods) as $nb) {
        $exists = DB::table('neighborhoods')->where('slug', $nb['slug'])->exists();
        if (!$exists) {
            DB::table('neighborhoods')->insert([
                'name' => $nb['name'],
                'slug' => $nb['slug'],
                'city' => $nb['city'],
                'description' => "خدمات تشطيب وديكور في حي {$nb['name']} - " . ($nb['city'] === 'mecca' ? 'مكة المكرمة' : 'جدة'),
                'is_active' => true,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $count++;
        }
    }
    echo "   ✓ Inserted $count new neighborhoods\n";
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

// 6. Make image column nullable (for gallery types that don't use image)
echo "6. Making image column nullable in galleries table...\n";
try {
    $colInfo = DB::select("SHOW COLUMNS FROM galleries WHERE Field = 'image'");
    if (!empty($colInfo) && strtoupper($colInfo[0]->Null) === 'NO') {
        DB::statement("ALTER TABLE galleries MODIFY image VARCHAR(255) NULL");
        echo "   ✓ image column is now nullable\n";
    } else {
        echo "   - image column already nullable\n";
    }
    $success++;
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    $errors++;
}

echo "\n=== Migration Complete ===\n";
echo "Success: $success, Errors: $errors\n";
