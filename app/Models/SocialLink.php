<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SocialLink extends Model
{
    protected $fillable = [
        'platform',
        'url',
        'icon',
        'is_active',
        'sort_order',
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
        static::saved(fn() => Cache::forget('social_links.active'));
        static::deleted(fn() => Cache::forget('social_links.active'));
    }
}
