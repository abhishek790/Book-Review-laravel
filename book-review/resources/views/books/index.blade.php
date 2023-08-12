@extends('layouts.app')

@section('content')
    <h1 class = "mb-10 text-2xl">Books</h1>

    <form action=""></form>

    <ul>
        @forelse($books as $book)
        <li class="mb-4">
            <div class="book-item">
              <div
                class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                    {{-- we can just pass the book variable for it as it only has one parameter and laravel is smart enough that it will know that this one has one parameter,it will know that it needs to pass a book ID because this is an object here and it has this id property--}}
                  <a href="{{route('books.show', $book)}}" class="book-title">{{$book->title}}</a>
                  <span class="book-author">{{$book->author}}</span>
                </div>
                <div>
                  <div class="book-rating">
                    {{$book->rating}}
                  </div>
                  <div class="book-review-count">
                    out of 5 reviews
                  </div>
                </div>
              </div>
            </div>
          </li>
        
        @empty
        
        @endforelse
    </ul>
@endsection