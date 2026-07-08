<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('type', 'gallery')->where('is_active', true)->orderBy('sort_order')->get();
        $galleries = Gallery::where('is_active', true)->with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('frontend.galleries.index', compact('galleries', 'categories'));
    }

    public function videos(): View
    {
        $items = Gallery::byType('video')->where('is_active', true)->with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('frontend.galleries.videos', compact('items'));
    }

    public function tours(): View
    {
        $items = Gallery::byType('360')->where('is_active', true)->with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('frontend.galleries.tours', compact('items'));
    }

    public function beforeAfter(): View
    {
        $items = Gallery::byType('before_after')->where('is_active', true)->with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('frontend.galleries.before-after', compact('items'));
    }

    public function photography(): View
    {
        $items = Gallery::byType('photography')->where('is_active', true)->with('category')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('frontend.galleries.photography', compact('items'));
    }

    public function show(int $id, ?string $slug = null): View
    {
        $query = Gallery::where('is_active', true)
            ->with(['category', 'service', 'project']);

        if ($slug) {
            $item = $query->where('slug', $slug)->firstOrFail();
        } else {
            $item = $query->where('id', $id)->firstOrFail();
        }

        $item->incrementViews();

        $related = Gallery::where('is_active', true)
            ->where('id', '!=', $item->id)
            ->where(function ($q) use ($item) {
                if ($item->category_id) $q->where('category_id', $item->category_id);
            })
            ->limit(8)
            ->get();

        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Gallery'), 'url' => route('gallery')],
            ['name' => $item->title, 'url' => route('gallery.show', [$item->id, $item->slug])],
        ];

        return view('frontend.galleries.show', compact('item', 'related', 'breadcrumbs'));
    }
}
