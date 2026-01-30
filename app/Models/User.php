<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // --- RELASI ---

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
    public function posts()
    {
        return $this->hasMany(Posts::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes_photo::class);
    }

    public function reportsSent()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsReceived()
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function bans()
    {
        return $this->hasMany(Banned::class);
    }

    // --- HELPER ---

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getAvatarDisplayAttribute()
{
    if (!$this->avatar) {
        return asset('ui/images/profile/user3.jpg');
    }

    // kalau avatar URL (Google)
    if (str_starts_with($this->avatar, 'http')) {
        return $this->avatar;
    }

    // kalau avatar file lokal
    return asset('storage/' . $this->avatar);
}


}
