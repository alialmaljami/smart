<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'title' => 'ديكورات المصمم الذكي',
                'subtitle' => 'تصميم داخلي فاخر يجمع بين الأناقة العصرية واللمسات العربية الأصيلة',
                'button_text' => 'اكتشف خدماتنا',
                'button_url' => '/services',
                'button_text_2' => 'اتصل بنا',
                'button_url_2' => '/contact',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'services',
                'type' => 'section_header',
                'title' => 'ما نقدمه لكم',
                'subtitle' => 'نقدم مجموعة متكاملة من خدمات التصميم والديكور لتلبية جميع احتياجاتكم',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'projects',
                'type' => 'section_header',
                'title' => 'أحدث مشاريعنا',
                'subtitle' => 'نفخر بتقديم مجموعة من أحدث مشاريعنا التي تعكس إبداعنا واهتمامنا بالتفاصيل',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'why_us',
                'type' => 'why_us',
                'title' => 'لماذا تختار المصمم الذكي؟',
                'is_active' => true,
                'sort_order' => 4,
                'extra' => [
                    'items' => [
                        [
                            'icon' => 'fas fa-award',
                            'title' => 'خبرة',
                            'description' => 'أكثر من 10 سنوات من الخبرة في مجال التصميم والديكور',
                        ],
                        [
                            'icon' => 'fas fa-check-circle',
                            'title' => 'جودة',
                            'description' => 'نستخدم أفضل المواد وأحدث التقنيات لضمان أعلى مستويات الجودة',
                        ],
                        [
                            'icon' => 'fas fa-handshake',
                            'title' => 'التزام',
                            'description' => 'نلتزم بمواعيدنا ونتجاوز توقعات عملائنا الكرام',
                        ],
                        [
                            'icon' => 'fas fa-lightbulb',
                            'title' => 'إبداع',
                            'description' => 'تصاميم فريدة ومبتكرة تناسب ذوقك وتعكس شخصيتك',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'stats',
                'type' => 'stats',
                'is_active' => true,
                'sort_order' => 5,
                'extra' => [
                    'items' => [
                        ['number' => '10+', 'label' => 'سنوات خبرة'],
                        ['number' => '100+', 'label' => 'مشروع مكتمل'],
                        ['number' => '50+', 'label' => 'عميل سعيد'],
                        ['number' => '20+', 'label' => 'جائزة وتكريم'],
                    ],
                ],
            ],
            [
                'key' => 'cta',
                'type' => 'cta',
                'title' => 'هل لديك مشروع؟',
                'subtitle' => 'تواصل معنا اليوم للحصول على استشارة مجانية ودعنا نحول رؤيتك إلى واقع',
                'button_text' => 'تواصل معنا',
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }
    }
}
