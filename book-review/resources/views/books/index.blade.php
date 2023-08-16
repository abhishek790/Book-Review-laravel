@extends('layouts.app')

@section('content')
    <h1 class = "mb-10 text-2xl">Books</h1>
    
    <form action="{{route('books.index')}}" method= "GET">
      {{-- old value if it was sent before,so if we have sent this form before this input would be populated with the previous value --}}
      <input type="text" name="title" placeholder="Search by title" value = "{{request('title')}}">
      {{-- when a tab is clicked this parameter will be sent with other parameter as well separated by &  --}}
      <input type="hidden" name="filter" value="{{request('filter')}}">
      <button type="submit" class="btn">Search</button>
      {{-- this would be used to clear the form,so simplest way to clear the form would be to add a link to a page that will not contain any query --}}
      <a href="{{route('books.index')}}" class="btn">Clear</a>

    </form>

    <div class="filter-container mb-4 flex">
      {{-- defining filter --}}
      @php
        // this array contains key which represent what has to be passed to the query parameters
        $filters = [
          ''=>'Latest',
          'popular_last_month'=>'Popular Last Month',
          'popular_last_6month'=>'Popular Last 6 Month',
          'highest_rated_last_month'=>'Highest Rated Last Month',
          'highest_rated_last_6month'=>'Highest Rated Last 6 Month',

    ];
    @endphp

    @foreach($filters as $key => $label)
    
      <a href="{{route('books.index',[...request()->query(),'filter'=>$key])}}" 
        class="{{request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active':'filter-item'}}">
        {{$label}}  
      </a>
    @endforeach
      
      
    </div>

    <ul>
        @forelse($books as $book)
        <li class="mb-4">
            <div class="book-item">
              <div
                class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                    
                  <a href="{{route('books.show', $book)}}" class="book-title">{{$book->title}}</a>
                  <span class="book-author">{{$book->author}}</span>
                </div>
                <div>
                  <div class="book-rating">
                   
                    {{number_format($book->reviews_avg_rating, 1)}}
                    <x-star-rating :rating="$book->reviews_avg_rating"/>
                  </div>
                  <div class="book-review-count">
                   
                    out of {{$book->reviews_count}} {{Str::plural('review',$book->reviews_count)}}
                  </div>
                </div>
              </div>
            </div>
          </li>
          
        @empty
          <li class = "mb-4">
            <div class ="empty-book-item">
              <p class ="empty-text">No books found </p>
              <a href="{{route('books.index')}}" class ="reset-link">Reset criteria</a>
            </div>
          </li>
          
        @endforelse
       
        @isset($books)
          {{$books->appends(request()->except('page'))->links()}}
          @endisset
    </ul>
    
@endsection