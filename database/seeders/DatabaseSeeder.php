<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@urbanvibe.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Create a default category for the products
        $category = \App\Models\Category::firstOrCreate(['name' => 'Ropa Urbana']);

        $productsData = [
            [
                'name' => 'Camiseta Oversize Street Drop',
                'description' => 'Camiseta de algodón pesado con corte oversize y logo bordado en el pecho.',
                'price' => 25.50,
                'stock' => 100,
            ],
            [
                'name' => 'Joggers Cargo City Runner',
                'description' => 'Pantalones tipo cargo con ajuste elástico en los tobillos y múltiples bolsillos utilitarios.',
                'price' => 42.00,
                'stock' => 85,
            ],
            [
                'name' => 'Sudadera con Capucha Night Owl',
                'description' => 'Hoodie de corte relajado, interior de felpa suave e impresión gráfica reflectante en la espalda.',
                'price' => 48.99,
                'stock' => 60,
            ],
            [
                'name' => 'Chaqueta Cortavientos Neon Vibe',
                'description' => 'Cortavientos ligero e impermeable con detalles en colores neón, ideal para la ciudad.',
                'price' => 55.00,
                'stock' => 40,
            ],
            [
                'name' => 'Gorro Beanie Urban Basic',
                'description' => 'Gorro de punto acanalado, ajuste cómodo para cualquier talla. Estilo minimalista.',
                'price' => 15.00,
                'stock' => 120,
            ],
            [
                'name' => 'Zapatillas Chunky Concrete',
                'description' => 'Zapatillas de suela gruesa con diseño retro-futurista, combinan cuero sintético y malla.',
                'price' => 75.00,
                'stock' => 35,
            ],
            [
                'name' => 'Pantalón Denim Vintage Skate',
                'description' => 'Jeans de corte holgado estilo años 90, lavado vintage y tela resistente para el día a día.',
                'price' => 50.00,
                'stock' => 55,
            ]
        ];

        foreach ($productsData as $data) {
            $product = new \App\Models\Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $product->setCategoryId($category->getId());
            $product->save();
        }
    }
}
