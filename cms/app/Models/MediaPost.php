<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaPost extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['tags' => 'array', 'event_date' => 'datetime', 'published_at' => 'datetime']; }
}
