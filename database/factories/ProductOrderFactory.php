<?php

namespace Database\Factories;

use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOrderFactory extends Factory
{
    protected $model = ProductOrder::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'total_price' => fake()->numberBetween(100000, 5000000),
            'status'      => 'pending',
            'notes'       => fake()->optional()->sentence(),
        ];
    }
}
