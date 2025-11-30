<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Frame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image_path', 'active'
    ];

    public function photos()
    {
        return $this->hasMany(\App\Models\Photo::class);
    }
}
