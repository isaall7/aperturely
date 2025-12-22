<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'photo_id',
        'comment_id',
        'reason',
        'description',
        'status'
    ];
    public $timestamp = true;

    // --- RELASI ---

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
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
