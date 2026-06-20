<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Material;
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

    public function showMaterial(string $slug): View
    {
        $material = Material::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $material->incrementViews();
        $relatedMaterials = Material::where('material_category_id', $material->material_category_id)
            ->where('id', '!=', $material->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Decoration Materials'), 'url' => route('materials')],
            ['name' => $material->category?->name ?? '', 'url' => route('material.category.show', $material->category?->slug ?? '#')],
            ['name' => $material->name, 'url' => route('material.show', $material->slug)],
        ];
        return view('frontend.materials.show-material', compact('material', 'relatedMaterials', 'breadcrumbs'));
    }
}
