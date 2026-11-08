<?php

// Juan Manuel Hernandez Martelo

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@urbanvibe.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+57 300 123 4567',
            'address' => 'Av. El Poblado #10-25, Medellín',
        ]);

        $client1 = User::factory()->create([
            'name' => 'Esteban Alvarez',
            'email' => 'esteban@urbanvibe.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+57 310 987 6543',
            'address' => 'Calle 50 #40-12, Medellín',
        ]);

        $client2 = User::factory()->create([
            'name' => 'Yan Frank Rios',
            'email' => 'frank@urbanvibe.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+57 320 555 1234',
            'address' => 'Carrera 70 #32-15, Medellín',
        ]);

        $catCamisas = Category::factory()->create(['name' => 'Camisas']);
        $catPantalones = Category::factory()->create(['name' => 'Pantalones']);
        $catBusos = Category::factory()->create(['name' => 'Busos']);
        $catAccesorios = Category::factory()->create(['name' => 'Accesorios']);

        $productsData = [
            [
                'name' => 'Camiseta Oversize Street Drop',
                'description' => 'Camiseta de algodón pesado de 240 GSM con corte oversize, cuello acanalado reforzado y logo bordado en el pecho.',
                'price' => 25.50,
                'discount' => 5.0,
                'size' => 'L',
                'color' => 'Negro',
                'material' => 'Algodón 100%',
                'stock' => 100,
                'category_id' => $catCamisas->getId(),
                'image' => 'products/camisata-oversize-street.png',
            ],
            [
                'name' => 'Joggers Cargo City Runner',
                'description' => 'Pantalones tipo cargo con ajuste elástico en los tobillos, cinta ajustable y seis bolsillos utilitarios.',
                'price' => 42.00,
                'discount' => 10.0,
                'size' => 'M',
                'color' => 'Verde Militar',
                'material' => 'Ripstop / Algodón',
                'stock' => 85,
                'category_id' => $catPantalones->getId(),
                'image' => 'products/Jogger-cargo-city-runner.png',
            ],
            [
                'name' => 'Sudadera con Capucha Night Owl',
                'description' => 'Hoodie de corte relajado, interior de felpa cepillada suave e impresión gráfica reflectante en la espalda.',
                'price' => 48.99,
                'discount' => 0.0,
                'size' => 'XL',
                'color' => 'Gris Jaspe',
                'material' => 'Algodón y Poliéster',
                'stock' => 60,
                'category_id' => $catBusos->getId(),
                'image' => 'products/sudadera-con-capucha-night-owl.png',
            ],
            [
                'name' => 'Chaqueta Cortavientos Neon Vibe',
                'description' => 'Cortavientos técnico ligero e impermeable con cremalleras termoselladas y detalles en colores neón.',
                'price' => 55.00,
                'discount' => 15.0,
                'size' => 'L',
                'color' => 'Negro / Neón',
                'material' => 'Nylon Impermeable',
                'stock' => 40,
                'category_id' => $catBusos->getId(),
                'image' => 'products/chaqueta-cortavientos-neon-vibe.png',
            ],
            [
                'name' => 'Gorro Beanie Urban Basic',
                'description' => 'Gorro de punto acanalado grueso, ajuste cómodo y etiqueta tejida en el doblez frontal.',
                'price' => 15.00,
                'discount' => 0.0,
                'size' => 'Única',
                'color' => 'Naranja Óxido',
                'material' => 'Acrílico Térmico',
                'stock' => 120,
                'category_id' => $catAccesorios->getId(),
                'image' => 'products/beanie-urban-basic.png',
            ],
            [
                'name' => 'Pantalón Denim Vintage Skate',
                'description' => 'Jeans de corte holgado estilo años 90, lavado vintage stone wash y tela de mezclilla resistente.',
                'price' => 50.00,
                'discount' => 0.0,
                'size' => '32',
                'color' => 'Azul Lavado',
                'material' => 'Denim Rígido',
                'stock' => 55,
                'category_id' => $catPantalones->getId(),
                'image' => 'products/pantalon-denim-vintage-skate.png',
            ],
            [
                'name' => 'Camiseta Boxy Fit Acid Wash',
                'description' => 'Corte boxy moderno con efecto acid wash artesanal. Estilo urbano crudo y atemporal.',
                'price' => 28.00,
                'discount' => 0.0,
                'size' => 'M',
                'color' => 'Gris Carbón',
                'material' => 'Algodón Peinado',
                'stock' => 45,
                'category_id' => $catCamisas->getId(),
                'image' => null,
            ],
            [
                'name' => 'Hoodie Heavyweight Underground',
                'description' => 'Sudadera premium ultra pesada de 450 GSM, capucha de doble capa y bolsillo canguro frontal.',
                'price' => 65.00,
                'discount' => 10.0,
                'size' => 'L',
                'color' => 'Blanco Hueso',
                'material' => 'French Terry',
                'stock' => 30,
                'category_id' => $catBusos->getId(),
                'image' => null,
            ],
            [
                'name' => 'Pantalón Parachute Cargo Tech',
                'description' => 'Pantalón parachute ligero con tancas ajustables en cintura y botamanga. Corte holgado techwear.',
                'price' => 46.00,
                'discount' => 5.0,
                'size' => 'L',
                'color' => 'Negro Mate',
                'material' => 'Poliamida',
                'stock' => 35,
                'category_id' => $catPantalones->getId(),
                'image' => null,
            ],
            [
                'name' => 'Gorra Snapback Urban Street',
                'description' => 'Gorra snapback de 6 paneles con visera plana estructurada y broche trasero regulable.',
                'price' => 22.00,
                'discount' => 0.0,
                'size' => 'Ajustable',
                'color' => 'Negro / Blanco',
                'material' => 'Sarga de Algodón',
                'stock' => 80,
                'category_id' => $catAccesorios->getId(),
                'image' => null,
            ],
            [
                'name' => 'Bolso Crossbody Chest Rig',
                'description' => 'Pequeño bolso cruzado táctico impermeable con múltiples divisiones para llaves, smartphone y billetera.',
                'price' => 32.50,
                'discount' => 0.0,
                'size' => 'Mediano',
                'color' => 'Negro',
                'material' => 'Cordura 600D',
                'stock' => 50,
                'category_id' => $catAccesorios->getId(),
                'image' => null,
            ],
            [
                'name' => 'Buzo Cuello Redondo Retro Minimalist',
                'description' => 'Crewneck clásico sin capota con rib elástico en puños y pretina. Cómodo para cualquier outfit.',
                'price' => 38.00,
                'discount' => 0.0,
                'size' => 'M',
                'color' => 'Azul Marino',
                'material' => 'Algodón Peinado',
                'stock' => 50,
                'category_id' => $catBusos->getId(),
                'image' => null,
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $data) {
            $createdProducts[] = Product::factory()->create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'] ?? 0,
                'size' => $data['size'] ?? 'M',
                'color' => $data['color'] ?? 'Negro',
                'material' => $data['material'] ?? 'Algodón',
                'stock' => $data['stock'],
                'category_id' => $data['category_id'],
                'image' => $data['image'],
            ]);
        }

        // Seed Reviews
        $reviewsData = [
            ['rating' => 5, 'comment' => 'Excelente calidad de la tela, la talla oversize queda impecable.'],
            ['rating' => 4, 'comment' => 'Muy cómodo para el día a día. Llegó en perfectas condiciones.'],
            ['rating' => 5, 'comment' => 'El mejor hoodie que he comprado, el estampado reflectante se ve genial de noche.'],
            ['rating' => 5, 'comment' => 'El material es resistente y el corte se ajusta exactamente como se describe.'],
            ['rating' => 4, 'comment' => 'Buena relación calidad-precio. Recomendado 100%.'],
        ];

        foreach ($createdProducts as $index => $prod) {
            $rev = $reviewsData[$index % count($reviewsData)];
            Review::factory()->create([
                'product_id' => $prod->getId(),
                'user_id' => ($index % 2 === 0) ? $client1->getId() : $client2->getId(),
                'rating' => $rev['rating'],
                'comment' => $rev['comment'],
            ]);
        }

        // Seed Sample Orders, Items and Payments
        $order1 = Order::factory()->create([
            'order_number' => 'ORD-'.strtoupper(Str::random(10)),
            'total_amount' => 74.49,
            'status' => 'paid',
            'user_id' => $client1->getId(),
        ]);

        OrderItem::factory()->create([
            'order_id' => $order1->getId(),
            'product_id' => $createdProducts[0]->getId(),
            'quantity' => 1,
            'unit_price' => 25.50,
            'subtotal' => 25.50,
        ]);

        OrderItem::factory()->create([
            'order_id' => $order1->getId(),
            'product_id' => $createdProducts[2]->getId(),
            'quantity' => 1,
            'unit_price' => 48.99,
            'subtotal' => 48.99,
        ]);

        Payment::factory()->create([
            'order_id' => $order1->getId(),
            'amount' => 74.49,
            'method' => 'credit_card',
            'reference' => 'PAY-'.strtoupper(Str::random(10)),
            'status' => 'approved',
        ]);

        $order2 = Order::factory()->create([
            'order_number' => 'ORD-'.strtoupper(Str::random(10)),
            'total_amount' => 42.00,
            'status' => 'pending',
            'user_id' => $client2->getId(),
        ]);

        OrderItem::factory()->create([
            'order_id' => $order2->getId(),
            'product_id' => $createdProducts[1]->getId(),
            'quantity' => 1,
            'unit_price' => 42.00,
            'subtotal' => 42.00,
        ]);

        // Seed Sample Wishlists
        Wishlist::factory()->create([
            'user_id' => $client1->getId(),
            'product_id' => $createdProducts[1]->getId(),
        ]);

        Wishlist::factory()->create([
            'user_id' => $client1->getId(),
            'product_id' => $createdProducts[3]->getId(),
        ]);

        Wishlist::factory()->create([
            'user_id' => $client2->getId(),
            'product_id' => $createdProducts[0]->getId(),
        ]);
    }
}
