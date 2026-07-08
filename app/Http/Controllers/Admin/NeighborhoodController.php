<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NeighborhoodController extends Controller
{
    use ImageUploadHelper;

    public function index(): View
    {
        $neighborhoods = Neighborhood::orderBy('city')->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.neighborhoods.index', compact('neighborhoods'));
    }

    public function create(): View
    {
        return view('admin.neighborhoods.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:neighborhoods,slug'],
            'city' => ['required', 'in:mecca,jeddah'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:10240'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['city']);
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'neighborhoods');
        }

        Neighborhood::create($validated);

        return redirect()->route('admin.neighborhoods.index')->with('success', 'تم إضافة الحي بنجاح');
    }

    public function edit(Neighborhood $neighborhood): View
    {
        return view('admin.neighborhoods.edit', compact('neighborhood'));
    }

    public function update(Request $request, Neighborhood $neighborhood): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:neighborhoods,slug,' . $neighborhood->id],
            'city' => ['required', 'in:mecca,jeddah'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:10240'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['city']);
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'neighborhoods', $neighborhood->image);
        }

        $neighborhood->update($validated);

        return redirect()->route('admin.neighborhoods.index')->with('success', 'تم تحديث الحي بنجاح');
    }

    public function toggleActive(Neighborhood $neighborhood): RedirectResponse
    {
        $neighborhood->update(['is_active' => !$neighborhood->is_active]);
        return redirect()->route('admin.neighborhoods.index')->with('success', 'تم تحديث الحالة بنجاح');
    }

    public function destroy(Neighborhood $neighborhood): RedirectResponse
    {
        if ($neighborhood->image) $this->deleteImageFiles($neighborhood->image, 'neighborhoods');
        $neighborhood->delete();
        return redirect()->route('admin.neighborhoods.index')->with('success', 'تم حذف الحي بنجاح');
    }
}
