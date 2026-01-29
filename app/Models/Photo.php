<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'post_id',
        'photo',
    ];

    public function post()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }
}
