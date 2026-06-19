<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            SocialLinkSeeder::class,
            ContactSeeder::class,
            ServiceSeeder::class,
            MaterialCategorySeeder::class,
            ReviewSeeder::class,
            HomepageSectionSeeder::class,
        ]);
    }
}
