<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // define request object by type hinting an argument with this request object you automatically get access to laravel request object 
    public function index(Request $request)
    {
        //lets get the title and fetch it into a variable we use input() method and pass the name of the parameter which is title
        $title = $request->input('title');

        // getting list of book for that title
        // when=> what it does is you can pass something as a 1st argument to it let's say title and then it has 2nd argument which is a function a closure or arrow function and what this would do is if title is not null or empty it will run this function otherwise it won't, so what this lets you do is if the title would be passed to this endpoint we can do some additional querying but if it is not passed it won't do anything and call get() to to run this query and get the data
        // we need 2 parameters to this function 1st is query,an instance of the query builder and 2nd one is this title
        $books = Book::when($title, function ($query, $title) {
            // its the local query scope defined in Book model
            return $query->title($title);
        })
            ->get();
        // its laravel convention to use same name for route name and view file name
        // what compact does is it will find a variable with the name books and turn it into an array with the key books and the value of the variable with the same name it is same as doing ['books'=>$books]
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}