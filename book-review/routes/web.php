<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class)

    ->only(['index', 'show']);


Route::resource('books.reviews', ReviewController::class)
    ->scoped(['review' => 'book'])
    ->only(['create', 'store']);

// rate limiting is a concept of limiting the amount of times a certain action can be performed in a given time frame, so rate limiting is often used with APIs
// we will limit the amount of reviews a user can leave and behind the scenes,it's using the same abstraction as the cache mechanism in laravel