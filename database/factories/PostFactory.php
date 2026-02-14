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
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'community_id' => null,
        'content' => fake()->paragraph(),
        'media_url' => fake()->boolean(30) ? fake()->imageUrl() : null,
        'visibility' => fake()->randomElement(['public', 'followers']),
    ]; 
    }
}
