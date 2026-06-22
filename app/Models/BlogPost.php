<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use TracksViews;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'category',
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
    ];
}
