<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'text',
        'reply',
        'stars',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'stars' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}