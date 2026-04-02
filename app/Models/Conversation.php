<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [];

    // 🔥 relasi ke user (pivot)
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user');
    }

    // 🔥 relasi ke messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // 🔥 ambil message terakhir (opsional tapi penting)
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}