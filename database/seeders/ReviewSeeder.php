<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'أحمد القحطاني',
                'text' => 'أشكر فريق المصمم الذكي على الاحترافية والذوق العالي في تنفيذ ديكور منزلي. النتيجة تجاوزت توقعاتي بكل معنى الكلمة.',
                'stars' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'سارة العنزي',
                'text' => 'تعاملت معهم في تصميم مكتبي وكانت تجربة رائعة. التصاميم مبتكرة والتنفيذ دقيق وفي الوقت المحدد. أنصح بالتعامل معهم.',
                'stars' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'محمد الدوسري',
                'text' => 'خدمة ممتازة وفريق محترف. ساعدوني في اختيار أفضل المواد والديكورات بأسعار مناسبة. شكراً لكم.',
                'stars' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'نورة الشمري',
                'text' => 'صالة الاستقبال في منزلي أصبحت تحفة فنية بفضل المصمم الذكي. الاختيارات كانت ذكية والتنفيذ رائع.',
                'stars' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'فهد المطيري',
                'text' => 'أفضل شركة ديكور تعاملت معها. الاهتمام بالتفاصيل والجودة العالية في العمل يميزهم عن غيرهم. تجربة تستحق التكرار.',
                'stars' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}