<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['scope' => 'array', 'is_featured' => 'boolean', 'is_home_featured' => 'boolean', 'published_at' => 'datetime', 'scheduled_at' => 'datetime', 'reviewed_at' => 'datetime']; }
    public function images() { return $this->hasMany(ProjectImage::class); }
    public function sector() { return $this->belongsTo(Sector::class); }

    public function scopePubliclyVisible($query)
    {
        return $query->where('status', 'published')->where(function ($query): void {
            $query->whereNull('published_at')->orWhere('published_at', '<=', now());
        });
    }
}
