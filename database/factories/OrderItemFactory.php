<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $unitPrice = $this->faker->randomFloat(2, 1, 500);
        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'quantity' => $quantity,
            'subtotal' => round($quantity * $unitPrice, 2),
            'unitPrice' => $unitPrice,
            'product_id' => Product::factory(),
            'order_id' => Order::factory(),
        ];
    }
}
