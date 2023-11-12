<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first(),
            'author_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->text(800)
        ];
    }
}
