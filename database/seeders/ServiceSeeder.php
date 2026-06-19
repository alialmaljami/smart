<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'الديكورات الداخلية',
                'slug' => 'interior-decorations',
                'description' => 'نقدم تصاميم ديكور داخلية عصرية وفاخرة تناسب جميع الأذواق، من غرف المعيشة إلى غرف النوم والمطابخ، باستخدام أفضل الخامات وأحدث الأساليب التصميمية.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'الديكورات الخارجية',
                'slug' => 'exterior-decorations',
                'description' => 'تصميم وتنفيذ ديكورات خارجية مميزة للواجهات والمداخل والحدائق، تجمع بين الجمال والوظائف العملية لتعطي انطباعاً فريداً لمبناك.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'ديكورات الجدران',
                'slug' => 'wall-decorations',
                'description' => 'تشكيلة واسعة من حلول ديكورات الجدران تشمل ورق الجدران، الفوم، الاستيل، والدهانات الفنية لإضفاء لمسات جمالية مميزة على جدران منزلك.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'ديكورات الأسقف',
                'slug' => 'ceiling-decorations',
                'description' => 'تصاميم أسقف جبسية مبتكرة ومعلقة مع أنظمة إضاءة مدمجة، تضفي عمقاً وجمالاً على المساحات الداخلية.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'الأرضيات والباركيه',
                'slug' => 'flooring-and-parquet',
                'description' => 'نوفر أفضل أنواع الأرضيات والباركيه والرخام والسيراميك، مع التركيب الاحترافي لضمان أعلى مستويات الجودة والمتانة.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'الإضاءة والمرايا',
                'slug' => 'lighting-and-mirrors',
                'description' => 'حلول إضاءة عصرية وديكورية مع مرايا فاخرة تعكس الأناقة وتخلق أجواء مثالية في كل مساحة.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'الستائر والمفروشات',
                'slug' => 'curtains-and-upholstery',
                'description' => 'مجموعة مختارة من الستائر الفاخرة والمفروشات المنزلية التي تجمع بين الراحة والجمال، مع أحدث صيحات الموضة.',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'الواجهات الخارجية',
                'slug' => 'facades',
                'description' => 'تصميم وتنفيذ واجهات خارجية باستخدام الحجر والرخام والزجاج والعناصر المعمارية الحديثة لإطلالة مبهرة.',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'الحدائق والجلسات الخارجية',
                'slug' => 'gardens-and-outdoor-sittings',
                'description' => 'تصميم حدائق وجلسات خارجية مريحة وجذابة، مع تنظيم المساحات الخضراء والممرات والإضاءة الخارجية.',
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'الأثاث المخصص',
                'slug' => 'custom-furniture',
                'description' => 'تصنيع أثاث مخصص حسب الطلب بتصاميم فريدة تناسب مساحتك وذوقك الشخصي، باستخدام أجود الخامات.',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'التشطيبات',
                'slug' => 'finishing',
                'description' => 'خدمات تشطيب متكاملة للمشاريع السكنية والتجارية، من البداية حتى التسليم النهائي بأعلى معايير الجودة.',
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'name' => 'الصيانة والتجديد',
                'slug' => 'maintenance-and-renovation',
                'description' => 'خدمات صيانة وتجديد شاملة للمنازل والمكاتب، تشمل إصلاح وتحديث الديكورات والبنية التحتية.',
                'sort_order' => 12,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
