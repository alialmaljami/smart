<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageSectionController extends Controller
{
    public function index(): View
    {
        $sections = HomepageSection::orderBy('sort_order')->get();
        return view('admin.homepage-sections.index', compact('sections'));
    }

    public function create(): View
    {
        return view('admin.homepage-sections.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:homepage_sections'],
            'type' => ['required', 'string', 'max:50'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'button_text_2' => ['nullable', 'string', 'max:255'],
            'button_url_2' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('homepage', 'public');
        }

        HomepageSection::create($validated);

        return redirect()->route('admin.homepage-sections.index')->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(HomepageSection $homepageSection): View
    {
        return view('admin.homepage-sections.edit', compact('homepageSection'));
    }

    public function update(Request $request, HomepageSection $homepageSection): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:homepage_sections,key,' . $homepageSection->id],
            'type' => ['required', 'string', 'max:50'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'button_text_2' => ['nullable', 'string', 'max:255'],
            'button_url_2' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('homepage', 'public');
        }

        $homepageSection->update($validated);

        return redirect()->route('admin.homepage-sections.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(HomepageSection $homepageSection): RedirectResponse
    {
        $homepageSection->delete();
        return redirect()->route('admin.homepage-sections.index')->with('success', 'تم حذف القسم بنجاح');
    }

    public function toggleActive(HomepageSection $homepageSection): RedirectResponse
    {
        $homepageSection->update(['is_active' => !$homepageSection->is_active]);
        return redirect()->route('admin.homepage-sections.index')->with('success', 'تم تحديث حالة القسم بنجاح');
    }
}
