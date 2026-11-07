<?php

// Juan Manuel Hernandez Martelo

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'reviews']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('search')) {
            $search = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        if ($request->filled('limit')) {
            $query->limit((int) $request->input('limit'));
        }

        $products = $query->get()->map(function (Product $product) {
            $avgRating = $product->getReviews()->avg('rating');

            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'discount' => $product->getDiscount(),
                'final_price' => $product->getFinalPrice(),
                'size' => $product->getSize(),
                'color' => $product->getColor(),
                'material' => $product->getMaterial(),
                'stock' => $product->getStock(),
                'brand' => 'Urbanvibe Wear',
                'category' => [
                    'id' => $product->getCategory()->getId(),
                    'name' => $product->getCategory()->getName(),
                ],
                'image' => $product->getImage() ? asset('storage/'.$product->getImage()) : null,
                'url' => url('/products/'.$product->getId()),
                'rating_average' => $avgRating ? round((float) $avgRating, 1) : null,
                'reviews_count' => $product->getReviews()->count(),
                'created_at' => $product->getCreatedAt(),
            ];
        });

        if ($request->query('format') === 'flat' || ! $request->is('api/v1*')) {
            $flat = $products->map(function ($p) {
                return [
                    'id' => $p['id'],
                    'name' => $p['name'],
                    'description' => $p['description'],
                    'price' => number_format((float) $p['final_price'], 2, '.', ''),
                    'stock' => $p['stock'],
                    'brand' => 'Urbanvibe Wear',
                    'category' => $p['category']['name'] ?? 'Ropa Urbana',
                    'url' => $p['url'],
                    'image' => $p['image'],
                ];
            });

            return response()->json($flat->values(), 200);
        }

        return response()->json([
            'status' => 'success',
            'team' => 'Equipo 3 - Urbanvibe Wear',
            'count' => $products->count(),
            'data' => $products,
        ], 200);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $product = Product::with(['category', 'reviews.user'])->find($id);

        if (! $product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        $avgRating = $product->getReviews()->avg('rating');

        $reviews = $product->getReviews()->map(function ($review) {
            return [
                'id' => $review->getId(),
                'author' => $review->getUser() ? $review->getUser()->getName() : 'Anonymous',
                'rating' => $review->getRating(),
                'comment' => $review->getComment(),
                'created_at' => $review->getCreatedAt(),
            ];
        });

        $response = [
            'status' => 'success',
            'team' => 'Equipo 3 - Urbanvibe Wear',
            'data' => [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'discount' => $product->getDiscount(),
                'final_price' => $product->getFinalPrice(),
                'size' => $product->getSize(),
                'color' => $product->getColor(),
                'material' => $product->getMaterial(),
                'stock' => $product->getStock(),
                'brand' => 'Urbanvibe Wear',
                'category' => [
                    'id' => $product->getCategory()->getId(),
                    'name' => $product->getCategory()->getName(),
                ],
                'image' => $product->getImage() ? asset('storage/'.$product->getImage()) : null,
                'url' => url('/products/'.$product->getId()),
                'rating_average' => $avgRating ? round((float) $avgRating, 1) : null,
                'reviews_count' => $reviews->count(),
                'reviews' => $reviews,
                'created_at' => $product->getCreatedAt(),
            ],
        ];

        if ($request->query('format') === 'flat' || ! $request->is('api/v1*')) {
            $item = $response['data'];

            return response()->json([
                'id' => $item['id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => number_format((float) $item['final_price'], 2, '.', ''),
                'stock' => $item['stock'],
                'brand' => 'Urbanvibe Wear',
                'category' => $item['category']['name'] ?? 'Ropa Urbana',
                'url' => $item['url'],
                'image' => $item['image'],
            ], 200);
        }

        return response()->json($response, 200);
    }
}
