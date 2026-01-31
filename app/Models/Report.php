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
        'post_id',
        'comment_id',
        'reason',
        'description',
        'status'
    ];

    public $timestamps = true; // Perbaiki dari $timestamp ke $timestamps

    // --- RELASI ---

    public function photos()
    {
        return $this->hasMany(Photo::class, 'post_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function post()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    // Helper method untuk mendapatkan label reason
    public function getReasonLabelAttribute()
    {
        $reasons = [
            'spam' => 'Spam',
            'bullying' => 'Bullying atau Pelecehan',
            'hate_speech' => 'Ujaran Kebencian (SARA)',
            'pornography' => 'Konten Pornografi',
            'violence' => 'Kekerasan',
            'scam' => 'Penipuan',
            'copyright' => 'Pelanggaran Hak Cipta',
            'misinformation' => 'Informasi Menyesatkan',
            'other' => 'Lainnya'
        ];

        return $reasons[$this->reason] ?? $this->reason;
    }

    // Helper untuk cek apakah laporan untuk post atau comment
    public function getReportTypeAttribute()
    {
        if ($this->post_id) {
            return 'post';
        } elseif ($this->comment_id) {
            return 'comment';
        }
        return null;
    }
}