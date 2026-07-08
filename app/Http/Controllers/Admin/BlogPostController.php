<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    use ImageUploadHelper;
    public function index(): View
    {
        $posts = BlogPost::orderBy('id')->get();
        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create(): View
    {
        $blogCategories = Category::where('type', 'blog')->where('is_active', true)->orderBy('name')->get();
        $allTags = Tag::orderBy('name')->get();
        return view('admin.blog-posts.create', compact('blogCategories', 'allTags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts'],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'blog_category_id' => ['nullable', 'integer'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['tags'] = [];

        if ($request->filled('blog_category_id')) {
            $cat = Category::find($validated['blog_category_id']);
            if (!$cat) $validated['blog_category_id'] = null;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'blog');
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $this->uploadImage($file, 'blog/gallery');
            }
            $validated['images'] = $paths;
        }

        $post = BlogPost::create($validated);

        if ($request->has('tag_ids')) {
            $post->tagItems()->sync($request->tag_ids);
            $tagNames = Tag::whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $post->update(['tags' => $tagNames]);
        }

        return redirect()->route('admin.blog-posts.index')->with('success', 'تم إضافة المقال بنجاح');
    }

    public function edit(BlogPost $blogPost): View
    {
        $blogCategories = Category::where('type', 'blog')->where('is_active', true)->orderBy('name')->get();
        $allTags = Tag::orderBy('name')->get();
        return view('admin.blog-posts.edit', compact('blogPost', 'blogCategories', 'allTags'));
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug,' . $blogPost->id],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'blog_category_id' => ['nullable', 'integer'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->filled('blog_category_id')) {
            $cat = Category::find($validated['blog_category_id']);
            if (!$cat) {
                $validated['blog_category_id'] = null;
            }
        } else {
            $validated['blog_category_id'] = null;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'blog', $blogPost->image);
        }

        if ($request->hasFile('images')) {
            $paths = $blogPost->images ?? [];
            foreach ($request->file('images') as $file) {
                $paths[] = $this->uploadImage($file, 'blog/gallery');
            }
            $validated['images'] = $paths;
        }

        $validated['tags'] = [];
        $blogPost->update($validated);

        if ($request->has('tag_ids')) {
            $blogPost->tagItems()->sync($request->tag_ids);
            $tagNames = Tag::whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $blogPost->update(['tags' => $tagNames]);
        } else {
            $blogPost->tagItems()->detach();
        }

        return redirect()->route('admin.blog-posts.index')->with('success', 'تم تحديث المقال بنجاح');
    }

    public function toggleActive(BlogPost $blogPost): RedirectResponse
    {
        $blogPost->update(['is_active' => !$blogPost->is_active]);
        return redirect()->route('admin.blog-posts.index')->with('success', 'تم تحديث حالة المقال بنجاح');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        if ($blogPost->image) $this->deleteImageFiles($blogPost->image, 'blog');
        $blogPost->delete();
        return redirect()->route('admin.blog-posts.index')->with('success', 'تم حذف المقال بنجاح');
    }
}