<?php

// Yan Frank Ríos López

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PartnerProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_products_page_is_accessible(): void
    {
        Http::fake([
            'http://34.60.117.225/*' => Http::response([
                [
                    'id' => 1,
                    'name' => 'ThinkPad X1',
                    'description' => 'Laptop de alto rendimiento',
                    'price' => '1800.00',
                    'stock' => 9,
                    'brand' => 'Lenovo',
                    'category' => 'Laptops',
                    'url' => 'http://34.60.117.225/products/1',
                ],
            ], 200),
        ]);

        $response = $this->get('/partner-products');

        $response->assertStatus(200);
    }
}
