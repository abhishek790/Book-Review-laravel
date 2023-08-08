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
            'updated_at' => fake()->dateTimeBetween('created_at', 'now'),

        ];
    }
}