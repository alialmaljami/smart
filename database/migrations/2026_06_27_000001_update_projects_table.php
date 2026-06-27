<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('is_active');
            $table->json('tags')->nullable()->after('sort_order');
            $table->dropColumn('client_name');
            $table->dropColumn('completion_date');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('sort_order');
            $table->dropColumn('tags');
            $table->string('client_name')->nullable();
            $table->date('completion_date')->nullable();
        });
    }
};
