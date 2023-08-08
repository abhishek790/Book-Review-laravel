<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    // define 1 to many relationship
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}