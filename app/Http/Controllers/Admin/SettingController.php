<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $keys = [
            'site_name', 'site_description', 'logo', 'favicon',
            'email', 'phone', 'address', 'map_url',
            'show_social_links',
            'home_hero_bg',
            'copyright_text', 'footer_description',
            'home_meta_title', 'home_meta_description', 'home_meta_keywords',
            'about_meta_title', 'about_meta_description', 'about_meta_keywords',
            'contact_meta_title', 'contact_meta_description', 'contact_meta_keywords',
            'faq_meta_title', 'faq_meta_description',
            'privacy_meta_title', 'privacy_meta_description',
            'terms_meta_title', 'terms_meta_description',
            'jeddah_meta_title', 'jeddah_meta_description',
            'mecca_meta_title', 'mecca_meta_description',
            'google_search_console', 'google_analytics_id',
            'watermark_enabled', 'watermark_type', 'watermark_text',
            'watermark_opacity', 'watermark_position', 'watermark_size',
        ];

        $keys[] = 'watermark_logo';

        foreach ($keys as $key) {
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } elseif ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key) ?? '']);
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}