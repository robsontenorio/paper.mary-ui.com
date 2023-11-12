<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Gaming', 'Tech', 'Art', 'Science', 'Travel']),
            'description' => $this->faker->text(),
            'color' => $this->faker->unique()->randomElement(['badge-success', 'badge-info', 'badge-warning', 'badge-error', 'badge-neutral']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
