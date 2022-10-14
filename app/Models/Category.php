<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Map;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function maps()
    {
        return $this->hasMany(Map::class);
    }
}
