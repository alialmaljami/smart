<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Gallery;
use App\Models\Neighborhood;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class CityController extends Controller
{
    public function show(string $slug): View
    {
        $city = City::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $cityNeighborhoodIds = Neighborhood::where('city', $city->slug)->pluck('id');
        $cityNames = [$city->name];
        $projects = Project::where('is_active', true)
            ->where(function ($q) use ($cityNeighborhoodIds, $cityNames) {
                $q->whereIn('neighborhood_id', $cityNeighborhoodIds);
                foreach ($cityNames as $name) {
                    $q->orWhere('title', 'like', "%{$name}%")
                      ->orWhere('description', 'like', "%{$name}%");
                }
            })
            ->orderBy('sort_order', 'desc')
            ->take(6)
            ->get();

        $services = Service::where('is_active', true)->get();
        $galleries = Gallery::where('is_active', true)->latest()->take(8)->get();
        $neighborhoods = Neighborhood::active()->byCity($city->slug)->orderBy('sort_order')->get();

        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => $city->name, 'url' => route('city.show', $city->slug)],
        ];

        return view('frontend.city', compact('city', 'projects', 'services', 'galleries', 'neighborhoods', 'breadcrumbs'));
    }
}
