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
