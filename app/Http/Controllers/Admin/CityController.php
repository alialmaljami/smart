<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CityController extends Controller
{
    use ImageUploadHelper;

    public function index(): View
    {
        $cities = City::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function create(): View
    {
        return view('admin.cities.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:cities,slug'],
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
            $validated['slug'] = Str::slug($validated['name']);
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'cities');
        }

        City::create($validated);

        return redirect()->route('admin.cities.index')->with('success', 'تم إضافة المدينة بنجاح');
    }

    public function edit(City $city): View
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:cities,slug,' . $city->id],
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
            $validated['slug'] = Str::slug($validated['name']);
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'cities', $city->image);
        }

        $city->update($validated);

        return redirect()->route('admin.cities.index')->with('success', 'تم تحديث المدينة بنجاح');
    }

    public function toggleActive(City $city): RedirectResponse
    {
        $city->update(['is_active' => !$city->is_active]);
        return redirect()->route('admin.cities.index')->with('success', 'تم تحديث الحالة بنجاح');
    }

    public function destroy(City $city): RedirectResponse
    {
        if ($city->image) $this->deleteImageFiles($city->image, 'cities');
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'تم حذف المدينة بنجاح');
    }
}
