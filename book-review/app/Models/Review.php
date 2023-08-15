<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating'];

    // defining relationship
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    // how can we invalidate the cache when anything about the book changes?
    // there are some life cycle model events that laravel automatically calls whenever something happens to a model and you can react to those events,so there is a way in laravel to react to all kinds of events that happen within the application
    // since review is cached we write code in review model

    protected static function booted(): void
    { //here we register those events,since we are dealing with updated so use updated event
        // inside updated you can pass closure or arrow function
        // inside to function we can make the code to forget the cache that it has stored whenever the specific review is updated,so when review is updated we want to clear the cache for the book
        // we can get access to cache using cache() and has a method called forget() which accepts a key
        // in our case key is book tabels id so to access a book id in review model we can simply use book_id column which has book tables id
        static::updated(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        // now you need to be aware that this event handler would not be called in all situation,incase of cache invalidation this updated method for this review model won't be called if you modify the db directly because this is outside laravel,  if you use mass assignment which means you would use an update method on a model this also won't be triggered because update method on the model does not first fetch the model,it just runs the query directly so this won't be triggered then,another example is when you use raw SQL query inside laravel also this event handler won't be triggered,if you would use database transactions then it might also not be triggered if the transcation is rolled back
        // but if you just load the model and then modify it by changing the properties, then you can be sure that this will be triggered

        // implementing in tinker
        // $review = \App\Models\Review::findOrFail(192);   
        // $review->rating =4;
        //  $review->save();
        // this will run the above updated function

        // updating with mass assignment
        // $review = \App\Models\Review::findOrFail(192);  
        // $review->update(['rating'=>1]);  
        // this will also run the above method

        // \App\Models\Review::where('id',192)->update(['rating'=>2]);  
        // now this will not run the above method
    }
}