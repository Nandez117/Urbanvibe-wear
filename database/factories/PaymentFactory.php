<?php

// Yan Frank Ríos López

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reference' => 'PAY-'.strtoupper(Str::random(12)),
            'method' => $this->faker->randomElement(['credit_card', 'paypal', 'pse']),
            'amount' => $this->faker->randomFloat(2, 20, 300),
            'status' => 'approved',
            'order_id' => Order::factory(),
        ];
    }
}
