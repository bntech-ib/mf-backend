<?php

namespace Database\Seeders;
 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Reaction;
use App\Models\Reward_log as RewardLog;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */



    public function run(): void
{
    // Disable events during seeding
    User::withoutEvents(function () {

        // 1️⃣ Create Users
        $users = User::factory()->count(1000)->create();

        // 2️⃣ Create Communities
        $communities = Community::factory()->count(50)->create();

        // 3️⃣ Attach Community Members
        foreach ($communities as $community) {
            $community->members()->attach(
                $users->random(rand(10, 100))->pluck('id')->toArray()
            );
        }

        // 4️⃣ Create Posts
        $posts = Post::factory()->count(5000)->create();

        // 5️⃣ Create Comments
        Comment::factory()->count(15000)->create();

        // 6️⃣ Create Reactions
        Reaction::factory()->count(20000)->create();

        // 7️⃣ Create Reward Logs
        RewardLog::factory()->count(5000)->create();

        // 8️⃣ Create Followers (Randomized pairs)
        $followers = [];
        foreach ($users as $user) {
            $followTargets = $users->random(rand(5, 30));
            foreach ($followTargets as $target) {
                if ($user->id !== $target->id) {
                    $followers[] = [
                        'follower_id' => $user->id,
                        'following_id' => $target->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('followers')->insertOrIgnore($followers);
    });
}

 }
