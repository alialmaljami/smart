<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::where('is_active', true)->with(['services', 'materialCategories']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $projects = $query->orderBy('sort_order', 'desc')->paginate(12);
        $categories = Category::whereHas('projects', function ($q) {
            $q->where('is_active', true);
        })->orderBy('name')->get();

        return view('frontend.projects.index', compact('projects', 'categories'));
    }

    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)->where('is_active', true)->with(['services', 'materialCategories', 'galleries'])->firstOrFail();
        $project->incrementViews();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Our Projects'), 'url' => route('projects')],
            ['name' => $project->title, 'url' => route('project.show', $project->slug)],
        ];
        return view('frontend.projects.show', compact('project', 'breadcrumbs'));
    }
}
