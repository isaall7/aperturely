<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'camera_type',
        'genre',
        'status',
        'ban_reason',
        'ai_reason',
    ];
    public $timestamp = true;

    // --- RELASI ---

    public function photos()
    {
        return $this->hasMany(Photo::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->whereNull('reply_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(Likes_photo::class, 'post_id');
    }

    // --- REPORTING ---

    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id');
    }

    public function bans()
    {
        return $this->hasMany(Banned::class);
    }

    // --- HELPER ---

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
