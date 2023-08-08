<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // i would like to generate 100 books and each of those books should have at least 5 but not more then 30 reviews 
        // so we've got 33 books, but we can then do something about every single one of them and this is done using each() and define a callback function that would be called for every single of those generated book model thats why the argument here is book, so we will now work with every single instance of that book.
        Book::factory(33)->create()->each(function ($book) {
            // first thing we need to do is we need to figure out how many reviews we want generated,for that we use random_int() form php where min is 5 and max is 30
            $numReviews = random_int(5, 30);
            // so at this point we know how many reviews we want for a particular book
            // so now we generate review using review model where we specify in count() how many reviews we want,and then we call one of the state methods,lets say good as i want to produce 33 books with good reviews
            //  the next thing we call is the for method and this will associate the created review with the book so laravel knows how those 2 models are related, It knows which column on the reviews table from the review model is used to create this relationship on the database level so this means laravel will set the value for this missing book_id to be the id of the created book as at this point the create method stores those books inside the datebase so they have the id so we can use it, you can pass the book to this for method. And finally we call the create mehtod which will just create a new modle and immediately store it inside the database
            Review::factory()->count($numReviews)->good()->for($book)->create();
        });

        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->average()->for($book)->create();
        });


        Book::factory(34)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->bad()->for($book)->create();
        });
    }
}