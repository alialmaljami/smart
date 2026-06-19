<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Like;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:project,material,gallery'],
            'id' => ['required', 'integer'],
        ]);

        $model = match ($validated['type']) {
            'project' => Project::findOrFail($validated['id']),
            'material' => Material::findOrFail($validated['id']),
            'gallery' => Gallery::findOrFail($validated['id']),
        };

        $ip = $request->ip();
        $like = Like::where('likeable_id', $model->id)
            ->where('likeable_type', get_class($model))
            ->where('ip_address', $ip)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $model->likes()->create(['ip_address' => $ip]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $model->likes()->count(),
        ]);
    }
}
