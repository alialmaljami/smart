<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\City;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Neighborhood;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $settings = Setting::all()->keyBy('key');
        return view('frontend.about', compact('settings'));
    }

    public function blog(): View
    {
        $categorySlug = request('category');
        $selectedCat = null;
        $posts = BlogPost::where('is_active', true)
            ->when($categorySlug, function($q, $s) use (&$selectedCat) {
                $selectedCat = Category::where('type', 'blog')->where('slug', $s)->first();
                if ($selectedCat) {
                    $q->where('blog_category_id', $selectedCat->id);
                } else {
                    $q->where('category', $s);
                }
            })
            ->latest()->paginate(9);

        $categories = Category::where('type', 'blog')->where('is_active', true)->orderBy('name')->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'categorySlug', 'selectedCat'));
    }

    public function blogPost(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $post->incrementViews();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Blog'), 'url' => route('blog')],
            ['name' => $post->title, 'url' => route('blog.post', $post->slug)],
        ];
        return view('frontend.blog.show', compact('post', 'breadcrumbs'));
    }

    public function faq(): View
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('FAQ'), 'url' => route('faq')],
        ];
        return view('frontend.faq', compact('faqs', 'breadcrumbs'));
    }

    public function privacy(): View
    {
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Privacy Policy'), 'url' => route('privacy')],
        ];
        return view('frontend.privacy', compact('breadcrumbs'));
    }

    public function terms(): View
    {
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Terms & Conditions'), 'url' => route('terms')],
        ];
        return view('frontend.terms', compact('breadcrumbs'));
    }

    public function cityJeddah(): View
    {
        $projects = Project::where('is_active', true)->orderBy('sort_order', 'desc')->take(6)->get();
        $services = Service::where('is_active', true)->get();
        $galleries = Gallery::where('is_active', true)->latest()->take(8)->get();
        $neighborhoods = Neighborhood::active()->byCity('jeddah')->orderBy('sort_order')->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Jeddah Decorations'), 'url' => route('city.jeddah')],
        ];
        return view('frontend.city-jeddah', compact('projects', 'services', 'galleries', 'neighborhoods', 'breadcrumbs'));
    }

    public function cityMecca(): View
    {
        $projects = Project::where('is_active', true)->orderBy('sort_order', 'desc')->take(6)->get();
        $services = Service::where('is_active', true)->get();
        $galleries = Gallery::where('is_active', true)->latest()->take(8)->get();
        $neighborhoods = Neighborhood::active()->byCity('mecca')->orderBy('sort_order')->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Mecca Decorations'), 'url' => route('city.mecca')],
        ];
        return view('frontend.city-mecca', compact('projects', 'services', 'galleries', 'neighborhoods', 'breadcrumbs'));
    }

    public function areasWeServe(): View
    {
        $jeddahProjects = Project::where('is_active', true)
            ->where(function ($q) {
                $q->where('title', 'like', '%جدة%')->orWhere('title', 'like', '%Jeddah%')
                  ->orWhere('description', 'like', '%جدة%')->orWhere('description', 'like', '%Jeddah%');
            })->latest()->take(6)->get();
        $meccaProjects = Project::where('is_active', true)
            ->where(function ($q) {
                $q->where('title', 'like', '%مكة%')->orWhere('title', 'like', '%Mecca%')
                  ->orWhere('description', 'like', '%مكة%')->orWhere('description', 'like', '%Mecca%');
            })->latest()->take(6)->get();
        $jeddahServices = Service::where('is_active', true)
            ->where(function ($q) {
                $q->where('name', 'like', '%جدة%')->orWhere('name', 'like', '%Jeddah%')
                  ->orWhere('description', 'like', '%جدة%')->orWhere('description', 'like', '%Jeddah%');
            })->get();
        $meccaServices = Service::where('is_active', true)
            ->where(function ($q) {
                $q->where('name', 'like', '%مكة%')->orWhere('name', 'like', '%Mecca%')
                  ->orWhere('description', 'like', '%مكة%')->orWhere('description', 'like', '%Mecca%');
            })->get();
        $meccaNeighborhoods = Neighborhood::active()->byCity('mecca')->orderBy('sort_order')->get();
        $jeddahNeighborhoods = Neighborhood::active()->byCity('jeddah')->orderBy('sort_order')->get();
        $cities = City::where('is_active', true)->orderBy('sort_order')->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Areas We Serve'), 'url' => route('areas.we.serve')],
        ];
        return view('frontend.areas-we-serve', compact('jeddahProjects', 'meccaProjects', 'jeddahServices', 'meccaServices', 'meccaNeighborhoods', 'jeddahNeighborhoods', 'cities', 'breadcrumbs'));
    }

    public function mostViewed(): View
    {
        $projects = Project::mostViewed(6)->get();
        $posts = BlogPost::mostViewed(6)->get();
        $galleries = Gallery::mostViewed(8)->get();
        $materials = Material::mostViewed(6)->get();
        $services = Service::mostViewed(6)->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Most Viewed'), 'url' => route('most-viewed')],
        ];
        return view('frontend.most-viewed', compact('projects', 'posts', 'galleries', 'materials', 'services', 'breadcrumbs'));
    }

    public function tag(string $tag): View
    {
        $tagSlug = \Illuminate\Support\Str::slug($tag);

        $services = Service::where('is_active', true)
            ->where(function ($q) use ($tag) {
                $q->where('name', 'like', "%{$tag}%")
                  ->orWhere('description', 'like', "%{$tag}%");
            })->orderBy('sort_order')->get();

        $projects = Project::where('is_active', true)
            ->where(function ($q) use ($tag, $tagSlug) {
                $q->whereJsonContains('tags', $tag)
                  ->orWhere('title', 'like', "%{$tag}%")
                  ->orWhere('description', 'like', "%{$tag}%")
                  ->orWhereHas('tagItems', fn($t) => $t->where('name', 'like', "%{$tag}%")->orWhere('slug', 'like', "%{$tagSlug}%"));
            })->orderBy('sort_order', 'desc')->take(6)->get();

        $posts = BlogPost::where('is_active', true)
            ->where(function ($q) use ($tag, $tagSlug) {
                $q->whereJsonContains('tags', $tag)
                  ->orWhere('title', 'like', "%{$tag}%")
                  ->orWhere('content', 'like', "%{$tag}%")
                  ->orWhereHas('tagItems', fn($t) => $t->where('name', 'like', "%{$tag}%")->orWhere('slug', 'like', "%{$tagSlug}%"));
            })->latest()->take(6)->get();

        $galleries = Gallery::where('is_active', true)
            ->where(function ($q) use ($tag, $tagSlug) {
                $q->whereJsonContains('tags', $tag)
                  ->orWhere('title', 'like', "%{$tag}%")
                  ->orWhere('description', 'like', "%{$tag}%")
                  ->orWhereHas('tagItems', fn($t) => $t->where('name', 'like', "%{$tag}%")->orWhere('slug', 'like', "%{$tagSlug}%"));
            })->latest()->take(8)->get();

        $materials = Material::where('is_active', true)
            ->where(function ($q) use ($tag, $tagSlug) {
                $q->whereJsonContains('tags', $tag)
                  ->orWhere('name', 'like', "%{$tag}%")
                  ->orWhere('description', 'like', "%{$tag}%")
                  ->orWhereHas('tagItems', fn($t) => $t->where('name', 'like', "%{$tag}%")->orWhere('slug', 'like', "%{$tagSlug}%"));
            })->get();

        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Tag') . ': ' . $tag, 'url' => route('tag', $tag)],
        ];

        return view('frontend.tag', compact('tag', 'services', 'projects', 'posts', 'galleries', 'materials', 'breadcrumbs'));
    }
}
