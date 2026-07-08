<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::orderBy('name')->get();
        $usages = [];
        foreach ($tags as $tag) {
            $usages[$tag->id] = $tag->blogPosts()->count() + $tag->projects()->count() + $tag->galleries()->count() + $tag->materials()->count();
        }
        return view('admin.tags.index', compact('tags', 'usages'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tags'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'تم إضافة الوسم بنجاح');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tags,slug,' . $tag->id],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'تم تحديث الوسم بنجاح');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->blogPosts()->detach();
        $tag->projects()->detach();
        $tag->galleries()->detach();
        $tag->materials()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'تم حذف الوسم بنجاح');
    }
}
