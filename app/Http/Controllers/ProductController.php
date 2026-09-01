<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Catálogo de Productos - Urbanvibe Wear';
        $viewData['products'] = Product::with('category')->get();

        return view('product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Registrar Producto';
        $viewData['categories'] = Category::all();

        return view('product.create')->with('viewData', $viewData);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = new Product;
        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));
        $product->setStock($request->input('stock'));
        $product->setCategoryId($request->input('category_id'));

        if ($request->filled('discount')) {
            $product->setDiscount($request->input('discount'));
        }
        if ($request->filled('size')) {
            $product->setSize($request->input('size'));
        }
        if ($request->filled('color')) {
            $product->setColor($request->input('color'));
        }
        if ($request->filled('material')) {
            $product->setMaterial($request->input('material'));
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar Producto';
        $viewData['product'] = Product::findOrFail($id);
        $viewData['categories'] = Category::all();

        return view('product.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));
        $product->setStock($request->input('stock'));
        $product->setCategoryId($request->input('category_id'));

        $product->setDiscount($request->input('discount', 0));
        $product->setSize($request->input('size'));
        $product->setColor($request->input('color'));
        $product->setMaterial($request->input('material'));

        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
