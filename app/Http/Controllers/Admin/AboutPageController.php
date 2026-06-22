<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.about.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $keys = [
            'about_title', 'about_subtitle', 'about_description',
            'about_story_1', 'about_story_2', 'about_story_3',
            'about_image',
            'about_vision_title', 'about_vision_text',
            'about_mission_title', 'about_mission_text',
            'about_values_title', 'about_values_text',
            'about_stat_years', 'about_stat_projects', 'about_stat_clients', 'about_stat_awards',
            'about_stat_years_label', 'about_stat_projects_label', 'about_stat_clients_label', 'about_stat_awards_label',
            'about_cta_title', 'about_cta_text', 'about_cta_button',
            'about_meta_title', 'about_meta_description', 'about_meta_keywords',
        ];

        foreach ($keys as $key) {
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('about', 'public');
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } elseif ($request->has($key)) {
                $value = $request->input($key) ?? '';
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return redirect()->route('admin.about.index')->with('success', 'تم حفظ صفحة عن الشركة بنجاح');
    }
}
