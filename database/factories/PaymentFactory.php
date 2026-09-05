<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reference' => strtoupper($this->faker->unique()->bothify('TXN-########')),
            'method' => $this->faker->randomElement(['Tarjeta de crédito', 'PSE', 'Efectivo']),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'status' => 'Aprobado',
            'order_id' => Order::factory(),
        ];
    }
}
