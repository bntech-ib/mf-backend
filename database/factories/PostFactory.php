<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Community;
use App\Models\Club;
 


class PostFactory extends Factory
{
   

public function definition(): array
{
    $types = collect([
        User::class,
        Community::class,
        Club::class,
    ])->filter(fn ($type) => $type::query()->exists())
      ->values();

    $type = $types->random();

    return [
        'poster_id' => $type::inRandomOrder()->value('id'),
        'poster_type' => $type,

        'content' => fake()->paragraph(),

        'media_url' => fake()->boolean(30)
            ? fake()->imageUrl()
            : null,

        'visibility' => fake()->randomElement([
            'public',
            'followers',
            'members'
        ]),
    ];
}

}

