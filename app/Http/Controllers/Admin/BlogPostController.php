<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    use ImageUploadHelper;
    public function index(): View
    {
        $posts = BlogPost::latest()->paginate(15);
        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create(): View
    {
        $blogCategories = Category::where('type', 'blog')->where('is_active', true)->orderBy('name')->get();
        return view('admin.blog-posts.create', compact('blogCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_posts'],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'blog_category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'tags' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->filled('blog_category_id')) {
            $cat = Category::find($validated['blog_category_id']);
            $validated['category'] = $cat ? $cat->name : ($validated['category'] ?? null);
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

        BlogPost::create($validated);

        return redirect()->route('admin.blog-posts.index')->with('success', 'تم إضافة المقال بنجاح');
    }

    public function edit(BlogPost $blogPost): View
    {
        $blogCategories = Category::where('type', 'blog')->where('is_active', true)->orderBy('name')->get();
        return view('admin.blog-posts.edit', compact('blogPost', 'blogCategories'));
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_posts,slug,' . $blogPost->id],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'blog_category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'tags' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->filled('blog_category_id')) {
            $cat = Category::find($validated['blog_category_id']);
            $validated['category'] = $cat ? $cat->name : ($validated['category'] ?? null);
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

        $blogPost->update($validated);

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