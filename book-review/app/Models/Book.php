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


    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([

            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)

        ])
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }



    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {

        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }

    }

    public function scopePopularLastMonth(Builder $query): Builder
    { // here we create a new date and subtract a month from it using a method,and next date is now
        // we will get all the book that are popular last month till now
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())->minReviews(2);
        // even though we don't really need to sort them by the rating we actually just want to get the actual average rating

    }

    public function scopePopularLast6Month(Builder $query): Builder
    {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())->minReviews(5);

    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder
    { // so the way it works is both query scopes, the popular query scope and highest rated query scope will get both the average rating and the count of rating.but the order in which you call those query scopes matters because they also add sorting and it matters in what order you add sorting because then the results will always be sorted by the first column you specified and the second or subsequent ones will only serve as tiebreakers
        return $query->highestRated(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())->minReviews(2);

    }

    public function scopeHighestRatedLast6Month(Builder $query): Builder
    {
        return $query->highestRated(now()->subMonths(6), now())
            ->popular(now()->subMonths(6), now())->minReviews(5);

    }

}