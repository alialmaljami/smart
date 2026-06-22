<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $types = ['project' => 'المشاريع', 'gallery' => 'معرض الصور', 'material' => 'مواد الديكور', 'blog' => 'المدونة'];
        $query = Category::orderBy('type')->orderBy('sort_order');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $categories = $query->get();
        return view('admin.categories.index', compact('categories', 'types'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', 'in:project,gallery,material,blog'],
            'image' => ['nullable', 'image', 'max:10240'],
            'tags' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index', ['type' => $validated['type']])
            ->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', 'in:project,gallery,material,blog'],
            'image' => ['nullable', 'image', 'max:10240'],
            'tags' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index', ['type' => $validated['type']])
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $type = $category->type;
        $category->delete();
        return redirect()->route('admin.categories.index', ['type' => $type])
            ->with('success', 'تم حذف التصنيف بنجاح');
    }

    public function toggleActive(Category $category): RedirectResponse
    {
        $category->update(['is_active' => !$category->is_active]);
        return redirect()->route('admin.categories.index', ['type' => $category->type])
            ->with('success', 'تم تحديث حالة التصنيف بنجاح');
    }
}
