<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}

