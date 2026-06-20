<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['blog_posts', 'projects', 'galleries', 'materials', 'services'] as $table) {
            if (!Schema::hasColumn($table, 'views')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->bigInteger('views')->default(0)->after('is_active');
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['blog_posts', 'projects', 'galleries', 'materials', 'services'] as $table) {
            if (Schema::hasColumn($table, 'views')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('views');
                });
            }
        }
    }
};
