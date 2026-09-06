<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['stats' => 'array', 'areas' => 'array', 'why_choose_us' => 'array']; }
}
