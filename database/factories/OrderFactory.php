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
            'order_number' => 'ORD-'.$this->faker->unique()->numerify('##########'),
            'creation_date' => $this->faker->date(),
            'total_amount' => $this->faker->randomFloat(2, 0, 1000),
            'status' => 'Pendiente',
            'user_id' => User::factory(),
        ];
    }
}
