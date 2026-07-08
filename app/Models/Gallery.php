<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Gallery extends Model
{
    use TracksViews;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'alt_text',
        'image',
        'video_url',
        'youtube_id',
        'vimeo_id',
        'tour_url',
        'before_image',
        'after_image',
        'show_comparison',
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
            'tags' => 'array',
            'show_comparison' => 'boolean',
        ];
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
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

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function isTour(): bool
    {
        return $this->type === '360';
    }

    public function isBeforeAfter(): bool
    {
        return $this->type === 'before_after';
    }

    public function tagItems(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function isImage(): bool
    {
        return $this->type === 'image' || is_null($this->type);
    }

    public function isPhotography(): bool
    {
        return $this->type === 'photography';
    }

    public function getVideoEmbedUrl(): ?string
    {
        if ($this->youtube_id) return "https://www.youtube.com/embed/{$this->youtube_id}";
        if ($this->vimeo_id) return "https://player.vimeo.com/video/{$this->vimeo_id}";
        return $this->video_url;
    }

    public function getDisplayImage(): ?string
    {
        return match ($this->type) {
            'before_after' => $this->before_image ?: $this->after_image ?: $this->image,
            default => $this->image ?: $this->before_image ?: $this->after_image,
        };
    }
}
