<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class ReviewController extends Controller
{




    public function create(Book $book)
    {
        return view('books.reviews.create', ['book' => $book]);
    }

    // we need book as this is a scoped request
    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'review' => 'required|min:15',
            'rating' => 'required|min:1|max:5|integer',
        ]);

        // it will create a new instance of the review and automatically associate with this specific book,so to create the model has to have the properties you are passing fillable and we have already defined those properties
        $book->reviews()->create($data);

        return redirect()->route('books.show', $book);
    }



}