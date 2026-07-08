<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        return view('frontend.services.index', compact('services'));
    }

    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->with('galleries')->firstOrFail();
        $service->incrementViews();
        $projects = $service->projects()->where('is_active', true)->latest()->get();
        $materialCategories = $service->materialCategories()->where('is_active', true)->orderBy('sort_order')->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Our Services'), 'url' => route('services')],
            ['name' => $service->name, 'url' => route('service.show', $service->slug)],
        ];
        return view('frontend.services.show', compact('service', 'projects', 'materialCategories', 'breadcrumbs'));
    }
}
