<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => null,
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => null,
            'sort_order' => 0,
        ];
    }
}