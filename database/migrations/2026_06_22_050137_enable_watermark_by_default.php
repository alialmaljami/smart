<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'watermark_enabled'],
            ['value' => '1']
        );
    }

    public function down(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'watermark_enabled'],
            ['value' => '0']
        );
    }
};
