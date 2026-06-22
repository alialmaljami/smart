<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        return view('frontend.favorites.index');
    }
    public function items(Request $request): JsonResponse
    {
        $types = $request->input('types', []);

        $result = [];

        if (isset($types['project'])) {
            $result['project'] = Project::whereIn('id', $types['project'])
                ->where('is_active', true)
                ->get(['id', 'title', 'slug', 'image', 'images', 'client_name', 'created_at']);
        }
        if (isset($types['blog'])) {
            $result['blog'] = BlogPost::whereIn('id', $types['blog'])
                ->where('is_active', true)
                ->get(['id', 'title', 'slug', 'image', 'created_at']);
        }
        if (isset($types['service'])) {
            $result['service'] = Service::whereIn('id', $types['service'])
                ->where('is_active', true)
                ->get(['id', 'name', 'slug', 'image', 'icon', 'description', 'created_at']);
        }
        if (isset($types['material'])) {
            $result['material'] = Material::whereIn('id', $types['material'])
                ->where('is_active', true)
                ->get(['id', 'name', 'slug', 'image', 'category_id', 'created_at']);
        }
        if (isset($types['gallery'])) {
            $result['gallery'] = Gallery::whereIn('id', $types['gallery'])
                ->where('is_active', true)
                ->get(['id', 'title', 'slug', 'image', 'alt_text', 'created_at']);
        }

        return response()->json($result);
    }
}
