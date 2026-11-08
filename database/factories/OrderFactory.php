<?php

// Esteban Alvarez Garcia

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-'.strtoupper(Str::random(10)),
            'total_amount' => $this->faker->randomFloat(2, 20, 300),
            'status' => $this->faker->randomElement(['pending', 'paid']),
            'user_id' => User::factory(),
        ];
    }
}
