<?php

// Juan Manuel Hernandez Martelo

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_products_returns_json_list(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create([
            'category_id' => $category->getId(),
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'team',
                'count',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'final_price',
                        'category' => ['id', 'name'],
                    ],
                ],
            ]);
    }

    public function test_api_single_product_returns_details(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->getId(),
        ]);

        $response = $this->getJson('/api/v1/products/'.$product->getId());

        $response->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.id', $product->getId());
    }

    public function test_api_products_flat_format_for_external_teams(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(2)->create([
            'category_id' => $category->getId(),
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'stock',
                    'brand',
                    'category',
                    'url',
                ],
            ]);
    }
}
