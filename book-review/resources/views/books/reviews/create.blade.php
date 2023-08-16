@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl">Add Reviews for {{$book->title}}</h1>

    <form method = POST action="{{route('books.reviews.store',$book)}}">
        @csrf
        <label for="review">Review</label>
        {{-- enforcing validation in html with required --}}
        <textarea name="review" id="review" required class = "input mb-4"></textarea>
        @error('review')
        <p>{{$message}}</p>
        @enderror

        <label for="rating">Rating</label>
        
        <select name="rating" id="rating" class= "input mb-4" required >
            <option value="">Select a Rating</option>
            @for($i=1;$i<=5;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
        </select>
    {{-- this is just for contribution to add in git hub --}}
        <button type="submit" class ="btn">Add Review</button>
    </form>










@endsection
