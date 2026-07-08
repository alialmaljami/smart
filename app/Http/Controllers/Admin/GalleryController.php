<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tag;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    use ImageUploadHelper;
    public function index(): View
    {
        $galleries = Gallery::with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'gallery')->where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $projects = Project::where('is_active', true)->orderBy('title')->get();
        $allTags = Tag::orderBy('name')->get();
        return view('admin.galleries.create', compact('categories', 'services', 'projects', 'allTags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug'],
            'description' => ['nullable', 'string'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:10240'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['tags'] = [];

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'galleries');
        }

        $gallery = Gallery::create($validated);

        if ($request->has('tag_ids')) {
            $gallery->tagItems()->sync($request->tag_ids);
            $tagNames = Tag::whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $gallery->update(['tags' => $tagNames]);
        }

        return redirect()->route('admin.galleries.index')->with('success', 'تم إضافة الصورة إلى المعرض بنجاح');
    }

    public function edit(Gallery $gallery): View
    {
        $categories = Category::where('type', 'gallery')->where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $projects = Project::where('is_active', true)->orderBy('title')->get();
        $allTags = Tag::orderBy('name')->get();
        return view('admin.galleries.edit', compact('gallery', 'categories', 'services', 'projects', 'allTags'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug,' . $gallery->id],
            'description' => ['nullable', 'string'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:10240'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['tags'] = [];

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'galleries', $gallery->image);
        }

        $gallery->update($validated);

        if ($request->has('tag_ids')) {
            $gallery->tagItems()->sync($request->tag_ids);
            $tagNames = Tag::whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $gallery->update(['tags' => $tagNames]);
        } else {
            $gallery->tagItems()->detach();
        }

        return redirect()->route('admin.galleries.index')->with('success', 'تم تحديث الصورة بنجاح');
    }

    public function toggleActive(Gallery $gallery): RedirectResponse
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        return redirect()->route('admin.galleries.index')->with('success', 'تم تحديث حالة الصورة بنجاح');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->deleteImageFiles($gallery->image, 'galleries');
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'تم حذف الصورة بنجاح');
    }
}
