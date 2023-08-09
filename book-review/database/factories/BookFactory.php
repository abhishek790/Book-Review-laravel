<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // sentence with 3 words
            'title' => fake()->sentence(3),
            'author' => fake()->name,
            // we set the created at and updated at manually
            // adding books and reviews in the last 2 years
            'created_at' => fake()->dateTimeBetween('-2 years'),
            // function (array $attributes) { ... }: This is an anonymous function (also called a closure) that defines how the value for the updated_at column should be generated. The function takes an array of $attributes as a parameter. This array typically contains the attribute values of the model that are already defined. In this case, it seems like the function is using the created_at attribute's value.

            // dateTimeBetween($attributes['created_at'], 'now'): This method call generates a random date and time between two given dates. The first argument is the lower bound (the created_at value from the $attributes array), and the second argument is the upper bound (which is 'now', representing the current date and time).
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            }

        ];
    }
}