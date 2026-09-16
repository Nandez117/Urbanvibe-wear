<?php

// Autor: Juan Manuel Hernandez Martelo

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.product_catalog_title');

        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->whereIn('category_id', $request->input('category_id'));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->filled('sizes')) {
            $query->whereIn('size', $request->input('sizes'));
        }

        if ($request->filled('sort')) {
            if ($request->input('sort') === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->input('sort') === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->input('sort') === 'newest') {
                $query->orderBy('created_at', 'desc');
            }
        }

        $viewData['products'] = $query->get();
        $viewData['categories'] = Category::all();

        return view('product.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $viewData = [];
        $product = Product::with('category')->findOrFail($id);
        $viewData['title'] = $product->getName().' - Urbanvibe Wear';
        $viewData['product'] = $product;

        return view('product.show')->with('viewData', $viewData);
    }
}
