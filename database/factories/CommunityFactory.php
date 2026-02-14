<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


    
    return [
        'name' => fake()->unique()->word(),
        'slug' => fake()->unique()->slug(),
        'description' => fake()->sentence(),
        'owner_id' => \App\Models\User::inRandomOrder()->first()->id,
        'privacy' => fake()->randomElement(['public', 'private']),
    ];


    }

}
