<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'الديكورات الداخلية', 'slug' => 'interior-decorations', 'type' => 'gallery', 'sort_order' => 1],
            ['name' => 'الديكورات الخارجية', 'slug' => 'exterior-decorations', 'type' => 'gallery', 'sort_order' => 2],
            ['name' => 'الجدران', 'slug' => 'walls', 'type' => 'gallery', 'sort_order' => 3],
            ['name' => 'الأسقف', 'slug' => 'ceilings', 'type' => 'gallery', 'sort_order' => 4],
            ['name' => 'الأرضيات', 'slug' => 'flooring', 'type' => 'gallery', 'sort_order' => 5],
            ['name' => 'الإضاءة', 'slug' => 'lighting', 'type' => 'gallery', 'sort_order' => 6],
            ['name' => 'الواجهات', 'slug' => 'facades', 'type' => 'gallery', 'sort_order' => 7],
            ['name' => 'الحدائق', 'slug' => 'gardens', 'type' => 'gallery', 'sort_order' => 8],
            ['name' => 'المجالس', 'slug' => 'majlis', 'type' => 'gallery', 'sort_order' => 9],
            ['name' => 'المطابخ', 'slug' => 'kitchens', 'type' => 'gallery', 'sort_order' => 10],
            ['name' => 'غرف النوم', 'slug' => 'bedrooms', 'type' => 'gallery', 'sort_order' => 11],
            ['name' => 'دورات المياه', 'slug' => 'bathrooms', 'type' => 'gallery', 'sort_order' => 12],
            ['name' => 'ديكورات مكة', 'slug' => 'mecca-decorations', 'type' => 'gallery', 'sort_order' => 13],
            ['name' => 'ديكورات جدة', 'slug' => 'jeddah-decorations', 'type' => 'gallery', 'sort_order' => 14],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
