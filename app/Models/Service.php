<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Service extends Model
{
    use TracksViews;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'images',
        'videos',
        'sort_order',
        'views',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'service_project');
    }

    public function materialCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'service_material_category', 'service_id', 'material_category_id');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function likeCount(): int
    {
        return $this->likes()->count();
    }

    public function isLikedByCurrentUser(): bool
    {
        return $this->likes()->where('ip_address', request()->ip())->exists();
    }
}
