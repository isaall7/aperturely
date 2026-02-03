<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'reply_id',
        'comment',
        'status',
        'ban_reason',
    ];

    public function post()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // komentar induk
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'reply_id');
    }

    // balasan komentar
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }
    
    public function reports()
    {
        return $this->hasMany(Report::class, 'comment_id');
    }

    public function bans()
    {
        return $this->hasMany(Banned::class, 'comment_id');
    }

    /**
     * Scope untuk comment yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk comment yang di-ban
     */
    public function scopeBanned($query)
    {
        return $query->where('status', 'banned');
    }
}
