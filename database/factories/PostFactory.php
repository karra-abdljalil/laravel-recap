<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
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
            "title"=> $this->faker->sentence,
            "description"=> $this->faker->paragraph,
            "user_id"=> $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
