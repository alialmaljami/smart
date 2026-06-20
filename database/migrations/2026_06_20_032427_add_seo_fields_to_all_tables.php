<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['services', 'projects', 'blog_posts', 'categories', 'materials'];
        
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'meta_keywords')) {
                    $table->text('meta_keywords')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'canonical_url')) {
                    $table->string('canonical_url')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'is_indexed')) {
                    $table->boolean('is_indexed')->default(true);
                }
            });
        }

        // Galleries already has meta_title and meta_description
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable();
            }
            if (!Schema::hasColumn('galleries', 'canonical_url')) {
                $table->string('canonical_url')->nullable();
            }
            if (!Schema::hasColumn('galleries', 'is_indexed')) {
                $table->boolean('is_indexed')->default(true);
            }
        });
    }

    public function down(): void
    {
        $tables = ['services', 'projects', 'blog_posts', 'categories', 'materials'];
        
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columns = [];
                if (Schema::hasColumn($tableName, 'meta_title')) $columns[] = 'meta_title';
                if (Schema::hasColumn($tableName, 'meta_description')) $columns[] = 'meta_description';
                if (Schema::hasColumn($tableName, 'meta_keywords')) $columns[] = 'meta_keywords';
                if (Schema::hasColumn($tableName, 'canonical_url')) $columns[] = 'canonical_url';
                if (Schema::hasColumn($tableName, 'is_indexed')) $columns[] = 'is_indexed';
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }

        Schema::table('galleries', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('galleries', 'meta_keywords')) $columns[] = 'meta_keywords';
            if (Schema::hasColumn('galleries', 'canonical_url')) $columns[] = 'canonical_url';
            if (Schema::hasColumn('galleries', 'is_indexed')) $columns[] = 'is_indexed';
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
