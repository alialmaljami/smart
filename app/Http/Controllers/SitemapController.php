<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tag;
use App\Models\VisitorQuestion;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    protected function lastMod($model): Carbon
    {
        $val = $model::where('is_active', true)->max('updated_at');
        return $val ? Carbon::parse($val) : now();
    }

    public function index(): Response
    {
        $sitemaps = [
            ['loc' => route('sitemap.pages'), 'lastmod' => now()],
            ['loc' => route('sitemap.projects'), 'lastmod' => $this->lastMod(Project::class)],
            ['loc' => route('sitemap.images'), 'lastmod' => $this->lastMod(Gallery::class)],
            ['loc' => route('sitemap.blog'), 'lastmod' => $this->lastMod(BlogPost::class)],
            ['loc' => route('sitemap.services'), 'lastmod' => $this->lastMod(Service::class)],
            ['loc' => route('sitemap.materials'), 'lastmod' => $this->lastMod(Material::class)],
            ['loc' => route('sitemap.cities'), 'lastmod' => $this->lastMod(City::class)],
            ['loc' => route('sitemap.neighborhoods'), 'lastmod' => $this->lastMod(Neighborhood::class)],
            ['loc' => route('sitemap.tags'), 'lastmod' => Tag::max('updated_at') ? Carbon::parse(Tag::max('updated_at')) : now()],
        ];

        return response()
            ->view('sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }

    public function projects(): Response
    {
        $items = Project::where('is_active', true)->where('is_indexed', true)
            ->where('slug', 'not like', '% %')
            ->select('slug', \DB::raw('MAX(updated_at) as updated_at'))
            ->groupBy('slug')
            ->orderByDesc('updated_at')->get();
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'project.show', 'changefreq' => 'weekly', 'priority' => '0.8'])
            ->header('Content-Type', 'application/xml');
    }

    public function images(): Response
    {
        $items = Gallery::where('is_active', true)->where('is_indexed', true)
            ->where('slug', 'not like', '% %')
            ->select('id', 'slug', \DB::raw('MAX(updated_at) as updated_at'))
            ->groupBy('slug', 'id')
            ->orderByDesc('updated_at')->get();
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'gallery.show', 'params' => ['id' => 'id', 'slug' => 'slug'], 'changefreq' => 'weekly', 'priority' => '0.6'])
            ->header('Content-Type', 'application/xml');
    }

    public function blog(): Response
    {
        $items = BlogPost::where('is_active', true)->where('is_indexed', true)
            ->where('slug', 'not like', '% %')
            ->select('slug', \DB::raw('MAX(updated_at) as updated_at'))
            ->groupBy('slug')
            ->orderByDesc('updated_at')->get();
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'blog.post', 'changefreq' => 'monthly', 'priority' => '0.7'])
            ->header('Content-Type', 'application/xml');
    }

    public function services(): Response
    {
        $items = Service::where('is_active', true)->where('is_indexed', true)
            ->where('slug', 'not like', '% %')
            ->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'service.show', 'changefreq' => 'monthly', 'priority' => '0.9'])
            ->header('Content-Type', 'application/xml');
    }

    public function materials(): Response
    {
        $items = Material::where('is_active', true)->where('is_indexed', true)
            ->where('slug', 'not like', '% %')
            ->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'material.show', 'changefreq' => 'monthly', 'priority' => '0.7'])
            ->header('Content-Type', 'application/xml');
    }

    public function neighborhoods(): Response
    {
        $items = Neighborhood::where('is_active', true)->where('is_indexed', true)
            ->where('slug', 'not like', '% %')
            ->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'area.show', 'changefreq' => 'monthly', 'priority' => '0.7'])
            ->header('Content-Type', 'application/xml');
    }

    public function pages(): Response
    {
        $pages = [
            ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.8', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('services'), 'changefreq' => 'weekly', 'priority' => '0.9', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('projects'), 'changefreq' => 'weekly', 'priority' => '0.8', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('gallery'), 'changefreq' => 'weekly', 'priority' => '0.7', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('blog'), 'changefreq' => 'weekly', 'priority' => '0.8', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('materials'), 'changefreq' => 'weekly', 'priority' => '0.8', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('faq'), 'changefreq' => 'monthly', 'priority' => '0.6', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('privacy'), 'changefreq' => 'yearly', 'priority' => '0.3', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('terms'), 'changefreq' => 'yearly', 'priority' => '0.3', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('areas.we.serve'), 'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => now()->toIso8601String()],
            ['loc' => route('questions'), 'changefreq' => 'weekly', 'priority' => '0.6', 'lastmod' => now()->toIso8601String()],
        ];
        return response()
            ->view('sitemap.pages', compact('pages'))
            ->header('Content-Type', 'application/xml');
    }

    public function tags(): Response
    {
        $tags = Tag::orderBy('name')
            ->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $tags, 'route' => 'tag.slug', 'changefreq' => 'monthly', 'priority' => '0.6'])
            ->header('Content-Type', 'application/xml');
    }

    public function cities(): Response
    {
        $staticCities = City::where('is_active', true)->orderBy('sort_order')->get()->map(fn($c) => [
            'loc' => route('city.show', $c->slug),
            'lastmod' => $c->updated_at ?: now(),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ])->toArray();
        $questions = VisitorQuestion::where('is_active', true)->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.cities', compact('staticCities', 'questions'))
            ->header('Content-Type', 'application/xml');
    }
}
