<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Likes_photo extends Model
{
    use HasFactory;

    protected $table = 'photo_likes';

    protected $fillable = [
        'post_id',
        'user_id'
    ];

    // LIKE MILIK POST
    public function post()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }

    // LIKE MILIK USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
