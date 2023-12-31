<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class ReviewController extends Controller
{


    // to apply some middleware to a specific action for a resource controller, you will have to define a constructor
    public function __construct()
    {
        $this->middleware('throttle:reviews')->only(['store']);

    }

    public function create(Book $book)
    {
        return view('books.reviews.create', ['book' => $book]);
    }


    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'review' => 'required|min:15',
            'rating' => 'required|min:1|max:5|integer',
        ]);

        $book->reviews()->create($data);

        return redirect()->route('books.show', $book);
    }



}