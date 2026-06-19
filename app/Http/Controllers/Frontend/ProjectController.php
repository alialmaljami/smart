<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::where('is_active', true)->with(['services', 'materialCategories'])->latest()->paginate(12);
        return view('frontend.projects.index', compact('projects'));
    }

    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)->where('is_active', true)->with(['services', 'materialCategories'])->firstOrFail();
        return view('frontend.projects.show', compact('project'));
    }
}
