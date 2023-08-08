<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'book_id' => null,
            'review' => fake()->paragraph,
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => fake()->dateTimeBetween('created_at', 'now'),

        ];
    }

    // problem with generating random numbers is that if we will have enough reviews for a book like 10 or at least 20, All the books will be kind of average so we will end up with an average rating for a book that would be around 3 the more reviews we have ,the more randomly generated number, the more it will be between 1 and 5.
    // So if we would like some more diversity with our generated data,we can use the so called custom state method inside the factories and those state method modify the generated data. In this case , that would be a generated rating to have some diversity with results
    // now the purpose of such state method is that you can override some of the columns that this general definition generate to have some different or more different results
    // The state method in a Laravel factory allows you to define different states or variations for generating fake data within the same factory definition.
    //The purpose of the following methods is to generate reviews with specific ratings for diverse data:

    // good() Method:

    // This method defines a state named good. It modifies the rating attribute to ensure that some generated reviews will have ratings between 4 and 5.

    // average() Method:

    // This method defines a state named average. It modifies the rating attribute to generate reviews with ratings between 2 and 5.

    // bad() Method:

    // This method defines a state named bad. It modifies the rating attribute to generate reviews with ratings between 1 and 3.

    // Each state method uses the state function provided by the Factory class. This function accepts a closure that receives an array of attributes and returns an array of modified attributes


    public function good()
    {
        // {   state() will accept function which gets one parameter of type array called attributes, this would be the values of the columns
        return $this->state(function (array $attributes) {
            return [
                // so now we can guarantee that we wil have some set of books that have reviews between 4 and 5
                'rating' => fake()->numberBetween(4, 5),
            ];
        });
    }


    public function average()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(2, 5)
            ];
        });
    }


    public function bad()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(1, 3),
            ];
        });
    }
}