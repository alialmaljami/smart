<?php

use App\Models\Tag;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Gallery;
use App\Models\Material;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $allTagNames = collect();

        foreach ([BlogPost::class, Project::class, Gallery::class, Material::class] as $modelClass) {
            $modelClass::whereNotNull('tags')->where('tags', '!=', '[]')
                ->where('tags', '!=', '"[]"')
                ->each(function ($item) use ($allTagNames) {
                    $tags = is_string($item->tags) ? json_decode($item->tags, true) : $item->tags;
                    if (is_array($tags)) {
                        foreach ($tags as $tag) {
                            $allTagNames->push(trim($tag));
                        }
                    }
                });
        }

        $allTagNames = $allTagNames->filter()->unique();

        $tagMap = [];
        foreach ($allTagNames as $name) {
            $slug = Str::slug($name);
            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
            $tagMap[$name] = $tag->id;
        }

        foreach ([BlogPost::class => 'blogPosts', Project::class => 'projects', Gallery::class => 'galleries', Material::class => 'materials'] as $modelClass => $relation) {
            $modelClass::whereNotNull('tags')->where('tags', '!=', '[]')
                ->where('tags', '!=', '"[]"')
                ->each(function ($item) use ($modelClass, $tagMap) {
                    $tags = is_string($item->tags) ? json_decode($item->tags, true) : $item->tags;
                    if (is_array($tags)) {
                        $tagIds = [];
                        foreach ($tags as $tag) {
                            $t = trim($tag);
                            if (isset($tagMap[$t])) {
                                $tagIds[] = $tagMap[$t];
                            }
                        }
                        if ($tagIds) {
                            $item->tagItems()->sync(array_unique($tagIds));
                        }
                    }
                });
        }
    }

    public function down(): void
    {
        DB::table('taggables')->truncate();
        Tag::query()->delete();
    }
};
