<?php

namespace App\Models;

use App\Traits\TracksViews;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use TracksViews;

    protected $fillable = [
        'name',
        'slug',
        'city',
        'description',
        'content',
        'image',
        'images',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'sort_order',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'views' => 'integer',
            'images' => 'array',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCity($query, string $city)
    {
        return $query->where('city', $city);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'neighborhood_id');
    }

    public function getCityNameAttribute(): string
    {
        $city = City::where('slug', $this->city)->first();
        return $city ? $city->name : ($this->city === 'mecca' ? 'مكة المكرمة' : 'جدة');
    }

    public function getCitySlugAttribute(): string
    {
        $city = City::where('slug', $this->city)->first();
        return $city ? $city->slug : ($this->city === 'mecca' ? 'mecca' : 'jeddah');
    }
}
