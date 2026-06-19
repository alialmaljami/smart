<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'key',
        'type',
        'title',
        'subtitle',
        'content',
        'image',
        'icon',
        'button_text',
        'button_url',
        'button_text_2',
        'button_url_2',
        'extra',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function getSection(string $key, $default = null): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first() ?? $default;
    }
}
