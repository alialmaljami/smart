<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    use TracksViews;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'images',
        'videos',
        'sort_order',
        'tags',
        'service_id',
        'category_id',
        'neighborhood_id',
        'views',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'tags' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_project');
    }

    public function materialCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'material_category_project', 'project_id', 'material_category_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class)->where('is_active', true)->orderBy('sort_order');
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

    public function tagItems(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
