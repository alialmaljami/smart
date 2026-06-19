<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $materialCategories = Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
        $projects = Project::with(['services', 'materialCategories', 'category'])->latest()->get();
        return view('admin.projects.index', compact('projects', 'services', 'materialCategories'));
    }

    public function create(): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $materialCategories = Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('type', 'project')->where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.projects.create', compact('services', 'materialCategories', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'videos' => ['nullable', 'string'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'completion_date' => ['nullable', 'date'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'material_category_ids' => ['nullable', 'array'],
            'material_category_ids.*' => ['exists:categories,id'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('projects/gallery', 'public');
            }
            $validated['images'] = $paths;
        }

        if ($request->filled('videos')) {
            $validated['videos'] = array_filter(array_map('trim', explode("\n", $request->videos)));
        }

        $project = Project::create($validated);

        if ($request->has('service_ids')) {
            $project->services()->sync($request->service_ids);
        }

        if ($request->has('material_category_ids')) {
            $project->materialCategories()->sync($request->material_category_ids);
        }

        return redirect()->route('admin.projects.index')->with('success', 'تم إضافة المشروع بنجاح');
    }

    public function edit(Project $project): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $materialCategories = Category::where('type', 'material')->where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('type', 'project')->where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.projects.edit', compact('project', 'services', 'materialCategories', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,' . $project->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:10240'],
            'videos' => ['nullable', 'string'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'completion_date' => ['nullable', 'date'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'material_category_ids' => ['nullable', 'array'],
            'material_category_ids.*' => ['exists:categories,id'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        if ($request->hasFile('images')) {
            $paths = $project->images ?? [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('projects/gallery', 'public');
            }
            $validated['images'] = $paths;
        }

        if ($request->filled('videos')) {
            $validated['videos'] = array_filter(array_map('trim', explode("\n", $request->videos)));
        }

        $project->update($validated);

        $project->services()->sync($request->service_ids ?? []);
        $project->materialCategories()->sync($request->material_category_ids ?? []);

        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function toggleActive(Project $project): RedirectResponse
    {
        $project->update(['is_active' => !$project->is_active]);
        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث حالة المشروع بنجاح');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع بنجاح');
    }
}