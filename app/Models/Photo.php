<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'filename', 'thumb_path', 'frame_id', 'original_filename', 'caption'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function frame()
    {
        return $this->belongsTo(\App\Models\Frame::class);
    }
}
