<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_keywords TYPE TEXT');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_keywords DROP NOT NULL');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_keywords DROP DEFAULT');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN tags TYPE TEXT');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN tags DROP NOT NULL');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN tags DROP DEFAULT');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_title TYPE TEXT');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_title DROP NOT NULL');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_title DROP DEFAULT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_keywords TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN tags TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE blog_posts ALTER COLUMN meta_title TYPE VARCHAR(255)');
    }
};
