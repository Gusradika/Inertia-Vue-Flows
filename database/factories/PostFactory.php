<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "body" => $this->faker->sentence(20), // Use $this->faker instead of Faker::sentence
            "title" => $this->faker->sentence(1), // Use $this->faker and modify the sentence length as needed
        ];
    }
}
