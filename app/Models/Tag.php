<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function blogPosts(): MorphToMany
    {
        return $this->morphedByMany(BlogPost::class, 'taggable');
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }

    public function galleries(): MorphToMany
    {
        return $this->morphedByMany(Gallery::class, 'taggable');
    }

    public function materials(): MorphToMany
    {
        return $this->morphedByMany(Material::class, 'taggable');
    }
}
