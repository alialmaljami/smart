<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'image',
        'images',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'images' => 'array',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'city', 'slug');
    }

    public function projects(): HasManyThrough
    {
        return $this->hasManyThrough(
            Project::class,
            Neighborhood::class,
            'city',
            'neighborhood_id',
            'slug',
            'id'
        );
    }
}
