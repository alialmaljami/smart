<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Material extends Model
{
    use TracksViews;

    protected $fillable = [
        'material_category_id',
        'name',
        'slug',
        'description',
        'image',
        'images',
        'price',
        'specifications',
        'tags',
        'views',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'is_indexed',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_active' => 'boolean',
            'is_indexed' => 'boolean',
            'tags' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'material_category_id');
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
