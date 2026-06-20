<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    use ImageUploadHelper;
    public function index(Request $request): View
    {
        $categories = Category::where('type', 'material')->orderBy('sort_order')->get();
        $query = Material::with('category');

        if ($request->filled('category_id')) {
            $query->where('material_category_id', $request->category_id);
        }

        $materials = $query->orderBy('name')->paginate(20);
        return view('admin.materials.index', compact('materials', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'material')->orderBy('sort_order')->get();
        return view('admin.materials.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:materials'],
            'description' => ['nullable', 'string'],
            'material_category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'specifications' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'materials');
        }

        if ($request->hasFile('images')) {
            $validated['images'] = $this->uploadImagesArray($request->file('images'), 'materials');
        }

        Material::create($validated);

        return redirect()->route('admin.materials.index')
            ->with('success', 'تم إضافة المادة بنجاح');
    }

    public function edit(Material $material): View
    {
        $categories = Category::where('type', 'material')->orderBy('sort_order')->get();
        return view('admin.materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:materials,slug,' . $material->id],
            'description' => ['nullable', 'string'],
            'material_category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'specifications' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'materials', $material->image);
        }

        if ($request->hasFile('images')) {
            $oldImages = $material->images ?? [];
            $validated['images'] = $this->uploadImagesArray($request->file('images'), 'materials', $oldImages);
        }

        $material->update($validated);

        return redirect()->route('admin.materials.index')
            ->with('success', 'تم تحديث المادة بنجاح');
    }

    public function destroy(Material $material): RedirectResponse
    {
        if ($material->image) $this->deleteImageFiles($material->image, 'materials');
        $material->delete();
        return redirect()->route('admin.materials.index')
            ->with('success', 'تم حذف المادة بنجاح');
    }

    public function toggleActive(Material $material): RedirectResponse
    {
        $material->update(['is_active' => !$material->is_active]);
        return redirect()->route('admin.materials.index')
            ->with('success', 'تم تحديث حالة المادة بنجاح');
    }
}
