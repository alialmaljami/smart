<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class BlogPost extends Model
{
    use TracksViews;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'category',
        'blog_category_id',
        'image',
        'images',
        'tags',
        'views',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'tags' => 'array',
    ];

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

    public function tagItems(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeWithImagesFirst(Builder $query): Builder
    {
        return $query->orderByRaw(
            "CASE WHEN (COALESCE(NULLIF(image, ''), NULL) IS NOT NULL)
                    OR (images IS NOT NULL AND JSON_LENGTH(images) > 0 AND JSON_SEARCH(images, 'one', '') IS NULL)
                  THEN 0 ELSE 1 END, created_at DESC"
        );
    }
}
