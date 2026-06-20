<?php

namespace App\Traits;

trait TracksViews
{
    public static function bootTracksViews(): void
    {
        static::creating(function ($model) {
            if (!isset($model->views)) {
                $model->views = 0;
            }
        });
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function scopeMostViewed($query, int $limit = 5)
    {
        return $query->where('is_active', true)->orderBy('views', 'desc')->limit($limit);
    }
}
