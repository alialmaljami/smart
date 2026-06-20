<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('alt_text')->nullable()->after('description');
            $table->string('meta_title')->nullable()->after('alt_text');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('tags')->nullable()->after('meta_description');
            $table->foreignId('service_id')->nullable()->after('tags')->constrained('services')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->after('service_id')->constrained('projects')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['project_id']);
            $table->dropColumn(['slug', 'alt_text', 'meta_title', 'meta_description', 'tags', 'service_id', 'project_id']);
        });
    }
};
