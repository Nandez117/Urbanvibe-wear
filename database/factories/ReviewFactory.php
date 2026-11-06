<?php

// Esteban Alvarez Garcia

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->sentence(10),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
