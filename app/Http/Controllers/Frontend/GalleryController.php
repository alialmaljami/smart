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
}
