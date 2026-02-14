<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RewardLogFactory extends Factory
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
        'action' => fake()->randomElement([
            'post_created',
            'comment_created',
            'received_like'
        ]),
        'points' => fake()->numberBetween(1, 20),
    ];
    }
}
