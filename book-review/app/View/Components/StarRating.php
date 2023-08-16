<?php
// // componenets are reusable blade templates that work on some part of your UI
namespace App\View\Components;

use Illuminate\View\Component;

class StarRating extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct(
        public readonly ?float $rating
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */


    public function render()
    {
        return view('components.star-rating');
    }
}