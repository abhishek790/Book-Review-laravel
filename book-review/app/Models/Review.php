<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    // defining relationship
    // so this method inside the review model is used to define a so called inverse side of the one to many relationship between a review and it's book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}