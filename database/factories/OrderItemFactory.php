<?php

// Esteban Alvarez Garcia

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 3);
        $unitPrice = $this->faker->randomFloat(2, 15, 80);

        return [
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => round($quantity * $unitPrice, 2),
            'product_id' => Product::factory(),
            'order_id' => Order::factory(),
        ];
    }
}
