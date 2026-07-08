<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Material;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function show(string $type, string $slug, int $index): View
    {
        $entity = match ($type) {
            'project' => Project::where('is_active', true)->where('slug', $slug)->firstOrFail(),
            'blog' => BlogPost::where('is_active', true)->where('slug', $slug)->firstOrFail(),
            'service' => Service::where('is_active', true)->where('slug', $slug)->firstOrFail(),
            'material' => Material::where('is_active', true)->where('slug', $slug)->firstOrFail(),
            default => abort(404),
        };

        $images = $entity->images ?? [];
        if (!is_array($images) || !isset($images[$index])) {
            abort(404);
        }

        $imagePath = $images[$index];
        $totalImages = count($images);
        $prevIndex = $index > 0 ? $index - 1 : null;
        $nextIndex = $index < $totalImages - 1 ? $index + 1 : null;

        $entityRoute = match ($type) {
            'project' => route('project.show', $entity->slug),
            'blog' => route('blog.post', $entity->slug),
            'service' => route('service.show', $entity->slug),
            'material' => route('material.show', $entity->slug),
            default => '#',
        };

        $entityName = match ($type) {
            'project' => $entity->title,
            'blog' => $entity->title,
            'service' => $entity->name,
            'material' => $entity->name,
            default => '',
        };

        $typeLabel = match ($type) {
            'project' => __('Project'),
            'blog' => __('Article'),
            'service' => __('Service'),
            'material' => __('Material'),
            default => '',
        };

        $entityDescription = strip_tags(match ($type) {
            'project' => $entity->meta_description ?? $entity->description ?? '',
            'blog' => $entity->meta_description ?? $entity->excerpt ?? strip_tags($entity->content ?? ''),
            'service' => $entity->meta_description ?? $entity->description ?? '',
            'material' => $entity->meta_description ?? $entity->description ?? '',
            default => '',
        });
        $entityDescription = Str::limit($entityDescription, 300);

        $imageNum = $index + 1;
        $metaTitle = $entityName . ' - ' . __('Image') . ' ' . $imageNum;
        $metaDescription = $entityName . ' - ' . $typeLabel . ' ' . __('Image') . ' ' . $imageNum;

        $breadcrumbs = match ($type) {
            'project' => [
                ['name' => __('Home'), 'url' => route('home')],
                ['name' => __('Projects'), 'url' => route('projects')],
                ['name' => $entityName, 'url' => $entityRoute],
                ['name' => __('Image') . ' ' . $imageNum, 'url' => ''],
            ],
            'blog' => [
                ['name' => __('Home'), 'url' => route('home')],
                ['name' => __('Blog'), 'url' => route('blog')],
                ['name' => $entityName, 'url' => $entityRoute],
                ['name' => __('Image') . ' ' . $imageNum, 'url' => ''],
            ],
            'service' => [
                ['name' => __('Home'), 'url' => route('home')],
                ['name' => __('Services'), 'url' => route('services')],
                ['name' => $entityName, 'url' => $entityRoute],
                ['name' => __('Image') . ' ' . $imageNum, 'url' => ''],
            ],
            'material' => [
                ['name' => __('Home'), 'url' => route('home')],
                ['name' => __('Decoration Materials'), 'url' => route('materials')],
                ['name' => $entityName, 'url' => $entityRoute],
                ['name' => __('Image') . ' ' . $imageNum, 'url' => ''],
            ],
            default => [],
        };

        return view('frontend.media.show', compact(
            'imagePath', 'entity', 'entityName', 'entityDescription', 'entityRoute', 'type', 'typeLabel',
            'index', 'totalImages', 'prevIndex', 'nextIndex', 'images',
            'metaTitle', 'metaDescription', 'breadcrumbs'
        ));
    }
}
