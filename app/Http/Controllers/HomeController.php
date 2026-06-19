<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\HomepageSection;
use App\Models\Material;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $projects = Project::where('is_active', true)->latest()->take(6)->get();
        $settings = Setting::all()->keyBy('key');
        $sections = HomepageSection::where('is_active', true)->orderBy('sort_order')->get()->keyBy('key');

        return view('frontend.home', compact('services', 'projects', 'settings', 'sections'));
    }

    public function search(Request $request): View
    {
        $q = $request->input('q');
        $settings = Setting::all()->keyBy('key');

        if (!$q) {
            return view('frontend.search', [
                'results' => collect(),
                'q' => '',
                'settings' => $settings,
            ]);
        }

        $services = Service::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->get();

        $projects = Project::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->get();

        $blogPosts = BlogPost::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            })
            ->get();

        $materials = Material::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->get();

        $results = collect()
            ->merge($services->map(fn($s) => ['type' => 'service', 'item' => $s]))
            ->merge($projects->map(fn($p) => ['type' => 'project', 'item' => $p]))
            ->merge($blogPosts->map(fn($b) => ['type' => 'blog', 'item' => $b]))
            ->merge($materials->map(fn($m) => ['type' => 'material', 'item' => $m]))
            ->merge($galleries->map(fn($g) => ['type' => 'gallery', 'item' => $g]))
            ->shuffle();

        return view('frontend.search', compact('results', 'q', 'settings'));
    }

    public function submitReview(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:1000'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $validated['is_active'] = false;

        Review::create($validated);

        return redirect()->back()->with('review_success', 'تم إرسال تقييمك بنجاح وسيتم نشره بعد المراجعة!');
    }
}
