<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform' => 'whatsapp',
                'url' => 'https://wa.me/...',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'platform' => 'telegram',
                'url' => 'https://t.me/...',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'platform' => 'instagram',
                'url' => 'https://www.instagram.com/wrq.mlm',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'platform' => 'tiktok',
                'url' => 'https://www.tiktok.com/@m1________m1',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'platform' => 'pinterest',
                'url' => 'https://www.pinterest.com/...',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'platform' => 'google_maps',
                'url' => 'https://maps.app.goo.gl/w8TwGiDcEgCCXHmL9',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::create($link);
        }
    }
}
