<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use Illuminate\View\View;

class NeighborhoodController extends Controller
{
    public function show(string $slug): View
    {
        $neighborhood = Neighborhood::where('is_active', true)->where('slug', $slug)->firstOrFail();
        $neighborhood->incrementViews();

        $projects = $neighborhood->projects()->where('is_active', true)->orderBy('sort_order', 'desc')->get();
        $services = \App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();

        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Areas We Serve'), 'url' => route('areas.we.serve')],
            ['name' => $neighborhood->city_name, 'url' => route('city.show', $neighborhood->city)],
            ['name' => $neighborhood->name, 'url' => ''],
        ];

        return view('frontend.neighborhoods.show', compact('neighborhood', 'projects', 'services', 'breadcrumbs'));
    }
}
