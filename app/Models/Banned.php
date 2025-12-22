<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banned extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'user_id',
        'photo_id',
        'comment_id',
        'reason',
        'notes'
    ];
    public $timestamp = true;

    // --- RELASI ---

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
