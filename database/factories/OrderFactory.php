<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'orderNumber' => 'ORD-'.$this->faker->unique()->numerify('##########'),
            'creationDate' => $this->faker->date(),
            'totalAmount' => $this->faker->randomFloat(2, 0, 1000),
            'status' => 'Pendiente',
            'user_id' => User::factory(),
        ];
    }
}
