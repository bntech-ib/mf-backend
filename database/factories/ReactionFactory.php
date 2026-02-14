<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
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
        'reactable_id' => \App\Models\Post::inRandomOrder()->first()->id,
        'reactable_type' => \App\Models\Post::class,
        'type' => fake()->randomElement(['like', 'love', 'fire']),
    ];


    
    }
}
