<?php

// Juan Manuel Hernandez Martelo

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'discount' => 0,
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color' => $this->faker->randomElement(['Rojo', 'Azul', 'Negro', 'Blanco', 'Gris', 'Verde', 'Amarillo', 'Morado']),
            'material' => $this->faker->randomElement(['Algodón', 'Poliéster', 'Lana', 'Denim', 'Cuero sintético', 'Nylon']),
            'stock' => $this->faker->numberBetween(10, 200),
            'image' => 'products/default.png',
            'category_id' => Category::factory(),
        ];
    }
}
