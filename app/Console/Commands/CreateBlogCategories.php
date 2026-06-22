<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Console\Command;

class CreateBlogCategories extends Command
{
    protected $signature = 'blog:create-categories';
    protected $description = 'Create blog categories';

    public function handle(): void
    {
        $categories = [
            ['name' => 'الديكورات الداخلية', 'slug' => 'blog-interior-decor'],
            ['name' => 'الديكورات الخارجية', 'slug' => 'blog-exterior-decor'],
            ['name' => 'ديكورات مكة', 'slug' => 'blog-makkah-decor'],
            ['name' => 'ديكورات جدة', 'slug' => 'blog-jeddah-decor'],
            ['name' => 'ديكورات الجدران', 'slug' => 'blog-wall-decor'],
            ['name' => 'ديكورات الأسقف', 'slug' => 'blog-ceiling-decor'],
            ['name' => 'الدهانات والألوان', 'slug' => 'blog-paints-colors'],
            ['name' => 'الأرضيات والباركيه', 'slug' => 'blog-flooring-parquet'],
            ['name' => 'الإضاءة', 'slug' => 'blog-lighting-decor'],
            ['name' => 'المطابخ', 'slug' => 'blog-kitchens-decor'],
            ['name' => 'دورات المياة', 'slug' => 'blog-bathrooms-decor'],
            ['name' => 'غرف النوم', 'slug' => 'blog-bedrooms-decor'],
            ['name' => 'المجالس والصالات', 'slug' => 'blog-majlis-living'],
            ['name' => 'الواجهات الخارجية', 'slug' => 'blog-facades-decor'],
            ['name' => 'الحدائق والجلسات', 'slug' => 'blog-gardens-sittings'],
            ['name' => 'أفكار ونصائح الديكور', 'slug' => 'blog-decor-tips'],
            ['name' => 'التشطيبات والترميم', 'slug' => 'blog-finishing-renovation'],
            ['name' => 'اتجاهات الديكور الحديثة', 'slug' => 'blog-modern-trends'],
        ];

        // Delete any stale blog categories first, then recreate
        Category::where('type', 'blog')->delete();
        $this->info('Cleared existing blog categories.');

        // Clear stale blog_category_id references in posts
        BlogPost::whereNotNull('blog_category_id')->update(['blog_category_id' => null]);
        $this->info('Cleared stale blog_category_id references.');

        foreach ($categories as $i => $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'type' => 'blog',
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
            $this->info("Created: {$cat['name']}");
        }

        $this->info('Done. Created ' . count($categories) . ' blog categories.');
    }
}
