<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $changes = [
            'categories' => ['name', 'slug', 'type', 'tags', 'meta_title', 'meta_keywords', 'canonical_url'],
            'contacts' => ['type', 'value', 'label'],
            'faqs' => ['question', 'category'],
            'galleries' => ['title', 'category', 'slug', 'alt_text', 'meta_title', 'canonical_url'],
            'homepage_sections' => ['key', 'type', 'title', 'subtitle', 'button_text', 'button_url', 'button_text_2', 'button_url_2'],
            'materials' => ['name', 'slug', 'tags', 'meta_title', 'meta_keywords', 'canonical_url'],
            'projects' => ['title', 'slug', 'client_name', 'meta_title', 'meta_keywords', 'canonical_url'],
            'reviews' => ['name'],
            'services' => ['name', 'slug', 'icon', 'image', 'meta_title', 'meta_keywords', 'canonical_url'],
            'social_links' => ['platform', 'url', 'icon'],
            'visitor_questions' => ['question', 'slug', 'asked_by'],
        ];

        foreach ($changes as $table => $columns) {
            if (!Schema::hasTable($table)) continue;
            foreach ($columns as $col) {
                if (!Schema::hasColumn($table, $col)) continue;
                DB::statement("ALTER TABLE \"{$table}\" ALTER COLUMN \"{$col}\" TYPE TEXT");
            }
        }
    }

    public function down()
    {
    }
};
