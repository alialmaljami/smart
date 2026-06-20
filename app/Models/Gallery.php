<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Gallery extends Model
{
    use TracksViews;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'alt_text',
        'image',
        'category',
        'category_id',
        'sort_order',
        'tags',
        'service_id',
        'project_id',
        'meta_title',
        'meta_description',
        'views',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Service::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Project::class);
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
