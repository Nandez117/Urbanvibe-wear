<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
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

        $catCamisas = Category::firstOrCreate(['name' => 'Camisas']);
        $catPantalones = Category::firstOrCreate(['name' => 'Pantalones']);
        $catBusos = Category::firstOrCreate(['name' => 'Busos']);
        $catAccesorios = Category::firstOrCreate(['name' => 'Accesorios']);

        $productsData = [
            [
                'name' => 'Camiseta Oversize Street Drop',
                'description' => 'Camiseta de algodón pesado con corte oversize y logo bordado en el pecho.',
                'price' => 25.50,
                'stock' => 100,
                'category_id' => $catCamisas->getId(),
                'image' => 'products/camisata-oversize-street.png',
            ],
            [
                'name' => 'Joggers Cargo City Runner',
                'description' => 'Pantalones tipo cargo con ajuste elástico en los tobillos y múltiples bolsillos utilitarios.',
                'price' => 42.00,
                'stock' => 85,
                'category_id' => $catPantalones->getId(),
                'image' => 'products/Jogger-cargo-city-runner.png',
            ],
            [
                'name' => 'Sudadera con Capucha Night Owl',
                'description' => 'Hoodie de corte relajado, interior de felpa suave e impresión gráfica reflectante en la espalda.',
                'price' => 48.99,
                'stock' => 60,
                'category_id' => $catBusos->getId(),
                'image' => 'products/sudadera-con-capucha-night-owl.png',
            ],
            [
                'name' => 'Chaqueta Cortavientos Neon Vibe',
                'description' => 'Cortavientos ligero e impermeable con detalles en colores neón, ideal para la ciudad.',
                'price' => 55.00,
                'stock' => 40,
                'category_id' => $catBusos->getId(),
                'image' => 'products/chaqueta-cortavientos-neon-vibe.png',
            ],
            [
                'name' => 'Gorro Beanie Urban Basic',
                'description' => 'Gorro de punto acanalado, ajuste cómodo para cualquier talla. Estilo minimalista.',
                'price' => 15.00,
                'stock' => 120,
                'category_id' => $catAccesorios->getId(),
                'image' => 'products/beanie-urban-basic.png',
            ],
            [
                'name' => 'Pantalón Denim Vintage Skate',
                'description' => 'Jeans de corte holgado estilo años 90, lavado vintage y tela resistente para el día a día.',
                'price' => 50.00,
                'stock' => 55,
                'category_id' => $catPantalones->getId(),
                'image' => 'products/pantalon-denim-vintage-skate.png',
            ],
        ];

        foreach ($productsData as $data) {
            $product = new Product;
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $product->setCategoryId($data['category_id']);
            $product->setImage($data['image']);
            $product->save();
        }
    }
}