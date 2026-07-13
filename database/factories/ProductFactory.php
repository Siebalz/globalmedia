<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);
        return [
            'name'        => $name,
            'slug'        => \Illuminate\Support\Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),
            'category'    => fake()->randomElement(['router', 'switch', 'access-point', 'radio']),
            'price'       => fake()->numberBetween(100000, 5000000),
            'description' => fake()->paragraph(),
            'is_active'   => true,
            'sold_count'  => 0,
            'created_by'  => User::factory(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
