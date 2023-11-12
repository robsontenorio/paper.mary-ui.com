<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(5)->create();

        $users = User::factory(200)->create();

        // Make sure things get shuffled
        $users->each(function (User $user) {
            Post::factory(3)
                ->for($user, 'author')
                ->state(new Sequence(
                    ['updated_at' => fake()->dateTimeThisYear],
                    ['updated_at' => fake()->dateTimeThisYear],
                    ['updated_at' => fake()->dateTimeThisYear],
                ))
                ->create();

            Comment::factory(7)
                ->for($user, 'author')
                ->create();
        });
    }
}
