<?php

// Yan Frank Ríos López

namespace Tests\Feature;

use App\Services\PartnerApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PartnerProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_api_placeholder_copy_uses_the_current_locale(): void
    {
        Http::fake([
            'http://34.60.117.225/*' => Http::response([['id' => 1]], 200),
        ]);

        foreach (['es', 'en'] as $locale) {
            $this->app->setLocale($locale);
            $result = app(PartnerApiService::class)->getProducts();
            $product = $result['products'][0];

            $this->assertSame(__('messages.partner_source_precedent'), $result['source']);
            $this->assertSame(__('messages.partner_default_product_name'), $product['name']);
            $this->assertSame(__('messages.partner_default_product_description'), $product['description']);
            $this->assertSame(__('messages.partner_category_general'), $product['category']);
        }
    }

    public function test_partner_api_fallback_source_uses_the_current_locale(): void
    {
        Http::fake([
            'http://34.60.117.225/*' => Http::response([], 503),
        ]);
        $this->app->setLocale('es');

        $result = app(PartnerApiService::class)->getProducts();

        $this->assertTrue($result['is_fallback']);
        $this->assertSame(__('messages.partner_source_fallback'), $result['source']);
    }

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

        $response->assertStatus(200)
            ->assertSee('images/products/electronics.svg');
    }

    public function test_partner_product_can_be_added_to_cart(): void
    {
        Http::fake([
            'http://34.60.117.225/*' => Http::response([
                'id' => 1,
                'name' => 'ThinkPad X1',
                'description' => 'Laptop de alto rendimiento',
                'price' => '1800.00',
                'stock' => 9,
                'brand' => 'Lenovo',
                'category' => 'Laptops',
                'url' => 'http://34.60.117.225/products/1',
            ], 200),
        ]);

        $response = $this->post('/partner-products/1/cart', ['quantity' => 1]);

        $response->assertRedirect('/cart');
    }
}
