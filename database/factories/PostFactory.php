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
            'user_id' => fake()->randomElement([1, 2, 3, 4]),
            'category_id' => fake()->randomElement([1, 2, 3, 4]),
            'body' => fake()->text($maxNbChars = 30),
            'image_url' => "https://www.momastore.jp/img/goods/2/4589593767843_2_detail.jpg"
        ];
    }
}
