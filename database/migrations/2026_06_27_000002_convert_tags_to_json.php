<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['galleries', 'blog_posts', 'materials'] as $table) {
            DB::table($table)->whereNotNull('tags')->where('tags', 'not like', '[%')->orderBy('id')->each(function ($row) use ($table) {
                $tags = array_map('trim', explode(',', $row->tags));
                DB::table($table)->where('id', $row->id)->update(['tags' => json_encode($tags)]);
            });
        }
    }

    public function down(): void
    {
    }
};
