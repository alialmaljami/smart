<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Project;
use App\Models\Service;
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
            ['loc' => route('sitemap.projects'), 'lastmod' => $this->lastMod(Project::class)],
            ['loc' => route('sitemap.images'), 'lastmod' => $this->lastMod(Gallery::class)],
            ['loc' => route('sitemap.blog'), 'lastmod' => $this->lastMod(BlogPost::class)],
            ['loc' => route('sitemap.services'), 'lastmod' => $this->lastMod(Service::class)],
            ['loc' => route('sitemap.materials'), 'lastmod' => $this->lastMod(Material::class)],
            ['loc' => route('sitemap.cities'), 'lastmod' => $this->lastMod(VisitorQuestion::class)],
        ];

        return response()
            ->view('sitemap.index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml');
    }

    public function projects(): Response
    {
        $items = Project::where('is_active', true)->where('is_indexed', true)->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'project.show', 'changefreq' => 'weekly', 'priority' => '0.8'])
            ->header('Content-Type', 'application/xml');
    }

    public function images(): Response
    {
        $items = Gallery::where('is_active', true)->where('is_indexed', true)->latest('updated_at')->get(['id', 'slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'gallery.show', 'params' => ['id' => 'id', 'slug' => 'slug'], 'changefreq' => 'weekly', 'priority' => '0.6'])
            ->header('Content-Type', 'application/xml');
    }

    public function blog(): Response
    {
        $items = BlogPost::where('is_active', true)->where('is_indexed', true)->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'blog.post', 'changefreq' => 'monthly', 'priority' => '0.7'])
            ->header('Content-Type', 'application/xml');
    }

    public function services(): Response
    {
        $items = Service::where('is_active', true)->where('is_indexed', true)->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'service.show', 'changefreq' => 'monthly', 'priority' => '0.9'])
            ->header('Content-Type', 'application/xml');
    }

    public function materials(): Response
    {
        $items = Material::where('is_active', true)->where('is_indexed', true)->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.items', ['items' => $items, 'route' => 'material.show', 'changefreq' => 'monthly', 'priority' => '0.7'])
            ->header('Content-Type', 'application/xml');
    }

    public function cities(): Response
    {
        $staticCities = [
            ['loc' => route('city.jeddah'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('city.mecca'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ];
        $questions = VisitorQuestion::where('is_active', true)->latest('updated_at')->get(['slug', 'updated_at']);
        return response()
            ->view('sitemap.cities', compact('staticCities', 'questions'))
            ->header('Content-Type', 'application/xml');
    }
}
