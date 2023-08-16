<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class)
    // you can call the only method,pass an array and say that you use index and how routes and all the other would be disabled, we do this because we are not using those routes
    ->only(['index', 'show']);

// this itself would register a full set of those actions available for every controller
// we scope it first so that review is in the scope of the book
Route::resource('books.reviews', ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only(['create', 'store']);

// adding new functionality i.e is to add reviews to the books. we will use scoping resource routes for that
// Now i would like to add another controller for reviews but we know that reviews don't exist independently,reviews are always attached and live only in the context of a book so it would make sense that we create a controller that will specify that even as part of the url
// we would like the reviews to always be attached to a specific book, so by  scoping the resource route using this scoped() 
// what we will also get is that all the queries used in the route model binding would be scoped by laravel. what this means is that laravel will try to figure out the relationship using it's conventions and laravel will figure out what is the relationship between reviews and the books because we told laravel about this relationship on the model. so it know that those two are related and it will scope fetching of a review in a way that it would always be fetched as part of a query that is fetching a book,which means if you would change a URL the way that you would ask for a review that doesn't belong to a specific book, it just wouldn't work