<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
