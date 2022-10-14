<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Map extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setExpiredAttribute($value)
    {
        $this->attributes['expired'] = date('Y-m-t', strtotime($value));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
