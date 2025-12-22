<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_id',
        'user_id',
        'reply_id',
        'comment',
        'status',
        'ban_reason'
    ];
    public $timestamp = true;

    // --- RELASI ---

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // reply comment
    public function reply()
    {
        return $this->belongsTo(Comment::class, 'reply_id');
    }

    // Reply (children)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function bans()
    {
        return $this->hasMany(Banned::class);
    }
}
