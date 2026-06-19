<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'ديكورات المصمم الذكي', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'شركة متخصصة في الديكور والتصميم الداخلي', 'group' => 'general'],
            ['key' => 'copyright_text', 'value' => '© 2026 ديكورات المصمم الذكي. جميع الحقوق محفوظة.', 'group' => 'general'],
            ['key' => 'footer_description', 'value' => 'نحن في ديكورات المصمم الذكي نقدم أفضل حلول الديكور والتصميم الداخلي', 'group' => 'general'],
            ['key' => 'home_meta_title', 'value' => 'ديكورات المصمم الذكي | Smart Designer Decorations', 'group' => 'general'],
            ['key' => 'home_meta_description', 'value' => 'أفضل شركة ديكور وتصميم داخلي في المملكة', 'group' => 'general'],
            ['key' => 'home_meta_keywords', 'value' => 'ديكور, تصميم داخلي, ديكورات منازل, تشطيبات', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'Smartdecorat1@gmail.com', 'group' => 'general'],
            ['key' => 'map_url', 'value' => 'https://maps.app.goo.gl/w8TwGiDcEgCCXHmL9', 'group' => 'general'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/wrq.mlm', 'group' => 'general'],
            ['key' => 'tiktok_url', 'value' => 'https://www.tiktok.com/@m1________m1', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
