<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'مدير الموقع',
            'email' => 'ali@smartdecorations.com',
            'password' => 'Ali2024',
            'is_admin' => true,
            'is_super_admin' => true,
        ]);
    }
}
