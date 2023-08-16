@if($rating)
    @for($i = 1; $i<=5;$i++)
    {{-- since its a float so we check if the current value of the loop is less than equal the rounded rating  --}}
        {{$i<=round($rating)?'★':'☆'}}
    @endfor
@else
    No rating yet
@endif