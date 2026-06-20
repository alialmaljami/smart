<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        'client_name',
        'completion_date',
        'service_id',
        'category_id',
        'views',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'completion_date' => 'date',
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
