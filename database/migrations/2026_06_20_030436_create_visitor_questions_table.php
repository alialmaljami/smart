<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('slug')->unique();
            $table->text('answer')->nullable();
            $table->string('asked_by')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_questions');
    }
};
