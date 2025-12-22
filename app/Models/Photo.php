<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'caption',
        'camera_type',
        'genre',
        'status',
        'ban_reason',
        'ai_reason',
    ];
    public $timestamp = true;

    // --- RELASI ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes_photo::class);
    }

    // --- REPORTING ---

    public function reports()
    {
        return $this->hasMany(Report::class);
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
