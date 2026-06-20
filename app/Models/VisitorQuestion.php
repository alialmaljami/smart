<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VisitorQuestion extends Model
{
    protected $fillable = [
        'question',
        'slug',
        'answer',
        'asked_by',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $q) {
            if (!$q->slug) {
                $q->slug = Str::slug($q->question);
            }
        });
    }
}
