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
}
