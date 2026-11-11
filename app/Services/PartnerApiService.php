<?php

// Esteban Alvarez Garcia

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PartnerApiService
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = (string) config('services.partner.url', 'http://34.60.117.225/api/products');
    }

    public function getProducts(): array
    {
        try {
            $response = Http::timeout(3)->get($this->apiUrl);

            if ($response->successful()) {
                $json = $response->json();
                $items = $json['data'] ?? $json['products'] ?? $json;

                if (is_array($items) && ! empty($items)) {
                    return [
                        'source' => $json['team'] ?? __('messages.partner_source_precedent'),
                        'is_fallback' => false,
                        'products' => $this->normalizeProducts($items),
                    ];
                }
            }
        } catch (Exception $e) {
            Log::warning('Partner API request failed: '.$e->getMessage());
        }

        return [
            'source' => __('messages.partner_source_fallback'),
            'is_fallback' => true,
            'products' => $this->getFallbackProducts(),
        ];
    }

    public function getProduct(string $id): ?array
    {
        try {
            $singleUrl = rtrim($this->apiUrl, '/').'/'.$id;
            $response = Http::timeout(3)->get($singleUrl);

            if ($response->successful()) {
                $json = $response->json();
                $data = $json['data'] ?? $json['product'] ?? $json;
                if (is_array($data)) {
                    return $this->normalizeSingleProduct($data);
                }
            }
        } catch (Exception $e) {
            Log::warning('Partner API single product request failed: '.$e->getMessage());
        }

        $all = $this->getProducts()['products'];
        $product = collect($all)->firstWhere('id', (int) $id);

        return $product ?: null;
    }

    private function normalizeProducts(array $items): array
    {
        $normalized = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $normalized[] = $this->normalizeSingleProduct($item);
            }
        }

        return $normalized;
    }

    private function normalizeSingleProduct(array $item): array
    {
        $category = __('messages.partner_category_general');
        if (isset($item['category'])) {
            $category = is_array($item['category'])
                ? ($item['category']['name'] ?? __('messages.partner_category_general'))
                : (string) $item['category'];
        }

        return [
            'id' => (int) ($item['id'] ?? rand(100, 999)),
            'name' => (string) ($item['name'] ?? __('messages.partner_default_product_name')),
            'description' => (string) ($item['description'] ?? __('messages.partner_default_product_description')),
            'price' => (float) ($item['price'] ?? 0),
            'discount' => (float) ($item['discount'] ?? 0),
            'final_price' => (float) ($item['final_price'] ?? $item['price'] ?? 0),
            'category' => $category,
            'brand' => isset($item['brand']) ? (string) $item['brand'] : null,
            'image' => $item['image'] ?? null,
            'url' => isset($item['url']) ? (string) $item['url'] : null,
            'stock' => (int) ($item['stock'] ?? 10),
            'rating' => isset($item['rating_average']) || isset($item['rating']) ? (float) ($item['rating_average'] ?? $item['rating']) : null,
        ];
    }

    private function getFallbackProducts(): array
    {
        $file = database_path('data/products-equipo2.json');
        if (file_exists($file)) {
            $raw = file_get_contents($file);
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && ! empty($decoded)) {
                return $this->normalizeProducts($decoded);
            }
        }

        return [
            [
                'id' => 1,
                'name' => 'ThinkPad X1',
                'description' => 'Producto de prueba: ThinkPad X1',
                'price' => 1800.00,
                'discount' => 0.0,
                'final_price' => 1800.00,
                'category' => 'Laptops',
                'brand' => 'Lenovo',
                'image' => null,
                'url' => 'http://34.60.117.225/products/1',
                'stock' => 9,
                'rating' => 4.8,
            ],
        ];
    }
}
