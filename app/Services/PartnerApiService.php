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
        $this->apiUrl = (string) config('services.partner.url', 'http://127.0.0.1:8000/api/v1/products');
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
                        'source' => $json['team'] ?? 'Tienda Aliada (Equipo Precedente)',
                        'is_fallback' => false,
                        'products' => $this->normalizeProducts($items),
                    ];
                }
            }
        } catch (Exception $e) {
            Log::warning('Partner API request failed: '.$e->getMessage());
        }

        return [
            'source' => 'Urban Retro Footwear (Servicio Aliado - Demostración)',
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

        $fallback = collect($this->getFallbackProducts())->firstWhere('id', (int) $id);

        return $fallback ?: null;
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
        $category = 'General';
        if (isset($item['category'])) {
            $category = is_array($item['category']) ? ($item['category']['name'] ?? 'General') : (string) $item['category'];
        }

        return [
            'id' => $item['id'] ?? rand(100, 999),
            'name' => $item['name'] ?? 'Producto Aliado',
            'description' => $item['description'] ?? 'Producto suministrado por la tienda aliada del equipo precedente.',
            'price' => (float) ($item['price'] ?? 0),
            'discount' => (float) ($item['discount'] ?? 0),
            'final_price' => (float) ($item['final_price'] ?? $item['price'] ?? 0),
            'category' => $category,
            'image' => $item['image'] ?? null,
            'stock' => (int) ($item['stock'] ?? 10),
            'rating' => $item['rating_average'] ?? $item['rating'] ?? null,
        ];
    }

    private function getFallbackProducts(): array
    {
        return [
            [
                'id' => 101,
                'name' => 'Retro Skate High Tops 1994',
                'description' => 'Zapatillas de caña alta estilo skate vintage, suela de goma vulcanizada y lona de alta durabilidad.',
                'price' => 79.99,
                'discount' => 10.0,
                'final_price' => 71.99,
                'category' => 'Calzado / Sneakers',
                'image' => null,
                'stock' => 18,
                'rating' => 4.8,
            ],
            [
                'id' => 102,
                'name' => 'Runner Pro Reflective Edition',
                'description' => 'Sneakers urbanos con amortiguación reactiva, paneles reflectivos de noche y tejido transpirable.',
                'price' => 89.50,
                'discount' => 0.0,
                'final_price' => 89.50,
                'category' => 'Calzado / Sneakers',
                'image' => null,
                'stock' => 12,
                'rating' => 4.9,
            ],
            [
                'id' => 103,
                'name' => 'Chunky Sole Street Stompers',
                'description' => 'Calzado urbano contemporáneo con plataforma gruesa y cordones bicolores. Tendencia streetwear.',
                'price' => 95.00,
                'discount' => 15.0,
                'final_price' => 80.75,
                'category' => 'Calzado / Sneakers',
                'image' => null,
                'stock' => 8,
                'rating' => 4.6,
            ],
            [
                'id' => 104,
                'name' => 'Vintage Canvas Low-Cut',
                'description' => 'Clásicas zapatillas de lona de corte bajo, perfectas para combinar con bermudas y pantalones oversize.',
                'price' => 49.99,
                'discount' => 0.0,
                'final_price' => 49.99,
                'category' => 'Calzado / Sneakers',
                'image' => null,
                'stock' => 25,
                'rating' => 4.4,
            ],
        ];
    }
}
