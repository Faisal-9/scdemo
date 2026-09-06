<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['scope' => 'array', 'is_featured' => 'boolean', 'is_home_featured' => 'boolean', 'published_at' => 'datetime']; }
    public function images() { return $this->hasMany(ProjectImage::class); }
}
