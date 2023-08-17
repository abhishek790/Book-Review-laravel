<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

// use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{

    public function index(Request $request)
    {


        $title = $request->input('title');
        // also giving default empty value
        $filter = $request->input('filter', '');

        echo var_dump(request()->query());

        $books = Book::when($title, function ($query, $title) {

            return $query->title($title);
        });


        $books = match ($filter) {

            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6month' => $books->popularLast6Month(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6month' => $books->highestRatedLast6Month(),

            default => $books->latest()->withAverageRating()->withReviewsCount(),
        };

        $cacheKey = 'books:' . $filter . ':' . $title;

        $books = cache()->remember($cacheKey, 3600, function () use ($books) {
            return $books->paginate(10);
        });


        return view('books.index', ['books' => $books]);
    }


    public function show(int $id)
    {
        $cacheKey = 'book:' . $id;
        $book = cache()->remember(
            $cacheKey,
            3600,
            fn() => Book::with([
                'reviews' => fn($query) => $query->latest()
            ])->withAverageRating()->withReviewsCount()->findOrFail($id)
        );
        return view('books.show', ['book' => $book]);
    }



}