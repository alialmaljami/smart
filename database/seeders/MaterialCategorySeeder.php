<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class MaterialCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'الخشب وبديل الخشب',
                'slug' => 'wood-and-wood-alternatives',
                'description' => 'مجموعة متنوعة من أنواع الخشب الطبيعي والصناعي وبدائل الخشب عالية الجودة المستخدمة في الديكورات والأثاث.',
                'type' => 'material',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'الرخام وبديل الرخام',
                'slug' => 'marble-and-marble-alternatives',
                'description' => 'أفضل أنواع الرخام الطبيعي والصناعي وبدائل الرخام للأرضيات والجدران والواجهات.',
                'type' => 'material',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'الشيبورد وبديل الشيبورد',
                'slug' => 'chipboard-and-alternatives',
                'description' => 'ألواح الشيبورد وبدائلها المناسبة للديكورات الداخلية والخارجية.',
                'type' => 'material',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'الحجر وبديل الحجر',
                'slug' => 'stone-and-stone-alternatives',
                'description' => 'تشكيلة من الحجر الطبيعي والصناعي وبدائل الحجر للواجهات والجدران والديكورات الخارجية.',
                'type' => 'material',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'الأرضيات والباركيه',
                'slug' => 'flooring-and-parquet-materials',
                'description' => 'جميع أنواع الأرضيات بما في ذلك الباركيه والفينيل والسيراميك والبورسلين مع مستلزمات التركيب.',
                'type' => 'material',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'الأسقف والجبس',
                'slug' => 'ceilings-and-gypsum',
                'description' => 'مواد الأسقف المعلقة والجبس بجميع أنواعها مع الإكسسوارات والأدوات اللازمة للتركيب.',
                'type' => 'material',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'ورق الجدران',
                'slug' => 'wallpaper',
                'description' => 'مجموعة واسعة من ورق الجدران بمختلف التصاميم والألوان والأنماط العصرية والكلاسيكية.',
                'type' => 'material',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'ديكورات الفوم',
                'slug' => 'foam-decorations',
                'description' => 'ديكورات الفوم خفيفة الوزن وسهلة التركيب، مثالية لإضفاء لمسات جمالية على الجدران والأسقف.',
                'type' => 'material',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'ديكورات استيل',
                'slug' => 'steel-decorations',
                'description' => 'ديكورات الاستيل العصرية التي تضفي لمسات معدنية أنيقة على المساحات الداخلية.',
                'type' => 'material',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'الإضاءة',
                'slug' => 'lighting',
                'description' => 'جميع أنواع الإضاءة الديكورية والوظيفية بما في ذلك الثريات والسبوتات والأضواء المخفية.',
                'type' => 'material',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'الستائر',
                'slug' => 'curtains',
                'description' => 'تشكيلة واسعة من الستائر بمختلف الأقمشة والتصاميم تناسب جميع الأذواق.',
                'type' => 'material',
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'name' => 'المرايا واللوحات',
                'slug' => 'mirrors-and-paintings',
                'description' => 'مرايا ديكورية ولوحات فنية تضيف لمسات جمالية وأناقة للمساحات الداخلية.',
                'type' => 'material',
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'براويز وإطارات ديكورية',
                'slug' => 'decorative-frames',
                'description' => 'براويز وإطارات ديكورية متنوعة تناسب جميع الأذواق وتكمل ديكور المنزل.',
                'type' => 'material',
                'sort_order' => 13,
                'is_active' => true,
            ],
            [
                'name' => 'الإكسسوارات',
                'slug' => 'accessories',
                'description' => 'إكسسوارات ديكورية متنوعة تشمل التحف والقطع الفنية الصغيرة التي تزيد المساحات جمالاً.',
                'type' => 'material',
                'sort_order' => 14,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
