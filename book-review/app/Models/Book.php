<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    // define 1 to many relationship
    // this function is the name of the relationship
    public function reviews()
    { // now you return type of relationship, this hasMany() method inside the book would define a one to many relationship between the book and the review and this basically says that the book can have many reviews
        return $this->hasMany(Review::class);
    }
}