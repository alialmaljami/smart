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

class GalleryTypeController extends Controller
{
    use ImageUploadHelper;

    private function getTypeConfig(string $type): array
    {
        return match ($type) {
            'video' => [
                'label' => 'الفيديوهات',
                'icon' => 'fa-video',
                'route_prefix' => 'admin.videos',
                'view_dir' => 'admin.gallery-types.videos',
                'title_single' => 'فيديو',
            ],
            '360' => [
                'label' => 'جولات 360',
                'icon' => 'fa-vr-cardboard',
                'route_prefix' => 'admin.tours',
                'view_dir' => 'admin.gallery-types.tours',
                'title_single' => 'جولة 360',
            ],
            'before_after' => [
                'label' => 'صور قبل وبعد',
                'icon' => 'fa-not-equal',
                'route_prefix' => 'admin.before-after',
                'view_dir' => 'admin.gallery-types.before-after',
                'title_single' => 'صورة قبل وبعد',
            ],
            'photography' => [
                'label' => 'التصوير',
                'icon' => 'fa-camera',
                'route_prefix' => 'admin.photography',
                'view_dir' => 'admin.gallery-types.photography',
                'title_single' => 'صورة تصوير',
            ],
            default => abort(404),
        };
    }

    public function index(string $type): View
    {
        $config = $this->getTypeConfig($type);
        $items = Gallery::byType($type)->with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view($config['view_dir'] . '.index', compact('items', 'config', 'type'));
    }

    public function create(string $type): View
    {
        $config = $this->getTypeConfig($type);
        $categories = Category::where('type', 'gallery')->where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $projects = Project::where('is_active', true)->orderBy('title')->get();
        $allTags = Tag::orderBy('name')->get();
        return view($config['view_dir'] . '.create', compact('config', 'type', 'categories', 'services', 'projects', 'allTags'));
    }

    public function store(string $type, Request $request): RedirectResponse
    {
        $config = $this->getTypeConfig($type);
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug'],
            'description' => ['nullable', 'string'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];

        if ($type === 'video') {
            $rules['video_url'] = ['nullable', 'string', 'max:500'];
            $rules['youtube_id'] = ['nullable', 'string', 'max:100'];
            $rules['vimeo_id'] = ['nullable', 'string', 'max:100'];
            $rules['image'] = ['nullable', 'image', 'max:10240'];
        } elseif ($type === '360') {
            $rules['tour_url'] = ['required', 'string', 'max:500'];
            $rules['image'] = ['nullable', 'image', 'max:10240'];
        } elseif ($type === 'before_after') {
            $rules['before_image'] = ['required', 'image', 'max:10240'];
            $rules['after_image'] = ['required', 'image', 'max:10240'];
            $rules['show_comparison'] = ['boolean'];
        } elseif ($type === 'photography') {
            $rules['image'] = ['required', 'image', 'max:10240'];
        }

        $validated = $request->validate($rules);
        $validated['type'] = $type;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['tags'] = [];
        $validated['show_comparison'] = $request->boolean('show_comparison');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'galleries');
        }
        if ($request->hasFile('before_image')) {
            $validated['before_image'] = $this->uploadImage($request->file('before_image'), 'galleries');
        }
        if ($request->hasFile('after_image')) {
            $validated['after_image'] = $this->uploadImage($request->file('after_image'), 'galleries');
        }

        $gallery = Gallery::create($validated);

        if ($request->has('tag_ids')) {
            $gallery->tagItems()->sync($request->tag_ids);
            $tagNames = Tag::whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $gallery->update(['tags' => $tagNames]);
        }

        return redirect()->route($config['route_prefix'] . '.index')
            ->with('success', "تم إضافة {$config['title_single']} بنجاح");
    }

    public function edit(string $type, Gallery $gallery): View
    {
        $config = $this->getTypeConfig($type);
        $categories = Category::where('type', 'gallery')->where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $projects = Project::where('is_active', true)->orderBy('title')->get();
        $allTags = Tag::orderBy('name')->get();
        return view($config['view_dir'] . '.edit', compact('gallery', 'config', 'type', 'categories', 'services', 'projects', 'allTags'));
    }

    public function update(string $type, Request $request, Gallery $gallery): RedirectResponse
    {
        $config = $this->getTypeConfig($type);
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug,' . $gallery->id],
            'description' => ['nullable', 'string'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];

        if ($type === 'video') {
            $rules['video_url'] = ['nullable', 'string', 'max:500'];
            $rules['youtube_id'] = ['nullable', 'string', 'max:100'];
            $rules['vimeo_id'] = ['nullable', 'string', 'max:100'];
            $rules['image'] = ['nullable', 'image', 'max:10240'];
        } elseif ($type === '360') {
            $rules['tour_url'] = ['required', 'string', 'max:500'];
            $rules['image'] = ['nullable', 'image', 'max:10240'];
        } elseif ($type === 'before_after') {
            $rules['before_image'] = ['nullable', 'image', 'max:10240'];
            $rules['after_image'] = ['nullable', 'image', 'max:10240'];
            $rules['show_comparison'] = ['boolean'];
        } elseif ($type === 'photography') {
            $rules['image'] = ['nullable', 'image', 'max:10240'];
        }

        $validated = $request->validate($rules);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['tags'] = [];
        $validated['show_comparison'] = $request->boolean('show_comparison');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'galleries', $gallery->image);
        }
        if ($request->hasFile('before_image')) {
            $validated['before_image'] = $this->uploadImage($request->file('before_image'), 'galleries', $gallery->before_image);
        }
        if ($request->hasFile('after_image')) {
            $validated['after_image'] = $this->uploadImage($request->file('after_image'), 'galleries', $gallery->after_image);
        }

        $gallery->update($validated);

        if ($request->has('tag_ids')) {
            $gallery->tagItems()->sync($request->tag_ids);
            $tagNames = Tag::whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $gallery->update(['tags' => $tagNames]);
        } else {
            $gallery->tagItems()->detach();
        }

        return redirect()->route($config['route_prefix'] . '.index')
            ->with('success', "تم تحديث {$config['title_single']} بنجاح");
    }

    public function toggleActive(string $type, Gallery $gallery): RedirectResponse
    {
        $config = $this->getTypeConfig($type);
        $gallery->update(['is_active' => !$gallery->is_active]);
        return redirect()->route($config['route_prefix'] . '.index')
            ->with('success', 'تم تحديث الحالة بنجاح');
    }

    public function destroy(string $type, Gallery $gallery): RedirectResponse
    {
        $config = $this->getTypeConfig($type);
        if ($gallery->image) $this->deleteImageFiles($gallery->image, 'galleries');
        if ($gallery->before_image) $this->deleteImageFiles($gallery->before_image, 'galleries');
        if ($gallery->after_image) $this->deleteImageFiles($gallery->after_image, 'galleries');
        $gallery->delete();
        return redirect()->route($config['route_prefix'] . '.index')
            ->with('success', "تم حذف {$config['title_single']} بنجاح");
    }
}
