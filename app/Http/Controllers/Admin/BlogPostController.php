<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::latest()->paginate(15);
        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog-posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_posts'],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog', 'public');
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('blog/gallery', 'public');
            }
            $validated['images'] = $paths;
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog-posts.index')->with('success', 'تم إضافة المقال بنجاح');
    }

    public function edit(BlogPost $blogPost): View
    {
        return view('admin.blog-posts.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blog_posts,slug,' . $blogPost->id],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog', 'public');
        }

        if ($request->hasFile('images')) {
            $paths = $blogPost->images ?? [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('blog/gallery', 'public');
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
        $blogPost->delete();
        return redirect()->route('admin.blog-posts.index')->with('success', 'تم حذف المقال بنجاح');
    }
}