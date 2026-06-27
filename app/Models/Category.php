<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'image',
        'tags',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn() => Cache::forget('material_categories.active'));
        static::deleted(fn() => Cache::forget('material_categories.active'));
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'material_category_id');
    }

    public function relatedProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'material_category_project', 'material_category_id', 'project_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_material_category', 'material_category_id', 'service_id');
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id');
    }
}
