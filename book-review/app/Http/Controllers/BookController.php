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

        // match is similar to switch statement,but the diff is it lets you return a value
        $books = match ($filter) {

            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6month' => $books->popularLast6Month(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6month' => $books->highestRatedLast6Month(),
            default => $books->latest()
        };

        $cacheKey = 'books:' . $filter . ':' . $title;
        echo $cacheKey;
        $books = cache()->remember('books', 3600, function () use ($books) {
            return $books->get();
        });


        return view('books.index', ['books' => $books]);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show(Book $book)
    {
        $cacheKey = 'book:' . $book->id;
        $book = cache()->remember($cacheKey, 3600, fn() => $book->load([
            'reviews' => fn($query) => $query->latest()
        ]));
        return view(
            'books.show',
            [
                'book' => $book
            ]
        );
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}