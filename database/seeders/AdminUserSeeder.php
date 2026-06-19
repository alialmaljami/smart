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
            'email' => 'admin@smartdecorations.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }
}
