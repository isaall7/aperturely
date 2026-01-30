<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function TypeCategories()
    {
        return $this->hasMany(TypeCategories::class);
    }

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
}
