<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['features' => 'array']; }
    public function children() { return $this->hasMany(self::class, 'parent_id'); }
}
