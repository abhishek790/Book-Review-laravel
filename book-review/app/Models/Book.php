<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// we use builder class from eloquent builder not the query
use Illuminate\Database\Eloquent\Builder;
// we can't import two classes from different namespace with the same name so we give alias
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;
    // define 1 to many relationship
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    // let's say movies when they are published are ususally very popular, but then maybe the popularity fades away so we will implement such scenario, allowing those two local query scope to include these additional filters for the time frame from which we want both the review count and the average rating
    // passing $from parameter and initializing it with null same for $to as well,these 2 parameter are expected to be dates
    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    { // in withCount instead of passing name of the relationship as string you can an array in which relationship would be key and it can accepts an optional closure or arrow function that will filter those reviews further
        // so we define a function that also gets a builder as an argument,
        return $query->withCount([
            // we are passing an arrow function, arrow function does not require use() so you have access to the outside variables like $from,$to
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)

        ])
            ->orderBy('reviews_count', 'desc');
    }
    // highest rated query for a given timeline
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    // now that those highest rated and popular now being able to limit the time frame,we might get skewed results for eg we might get averages like 5.0 which might suggest a book is execeptionally good, but in reality it might just have one review 
    // we add another scope that will show results when they have some minimum amount of reviews

    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        // inside here we will be filtering the reviews
        // from set but to not set
        if ($from && !$to) {
            // this would be minimum date
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            // created at should be between from and to
            $query->whereBetween('created_at', [$from, $to]);
        }
        // we don't have to return anything because query is an object and object are passed by reference, not by copy so you will be modifying an existing oject so you don't really have to return anything from this method
    }
    // tinker command line 
    // this will give
    // \App\Models\Book::highestRated('2023-02-01', '2023-03-30')->popular('2023-02-01', '2023-03-30')->minReviews(2)->get();  

}