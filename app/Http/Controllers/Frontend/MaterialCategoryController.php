<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class MaterialCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
        return view('frontend.materials.index', compact('categories'));
    }

    public function show(string $slug): View
    {
        $category = Category::where('type', 'material')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $materials = $category->materials()->where('is_active', true)->get();
        $projects = $category->relatedProjects()->where('is_active', true)->latest()->get();

        return view('frontend.materials.show', compact('category', 'materials', 'projects'));
    }
}
