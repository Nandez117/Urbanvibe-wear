<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Catálogo de Productos - Urbanvibe Wear';

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

    public function create(): View|RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', 'Acceso denegado. Solo los administradores pueden realizar esta acción.');
        }

        $viewData = [];
        $viewData['title'] = 'Registrar Producto';
        $viewData['categories'] = Category::all();

        return view('product.create')->with('viewData', $viewData);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', 'Acceso denegado. Solo los administradores pueden realizar esta acción.');
        }

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

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->setImage($imagePath);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function edit(string $id): View|RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', 'Acceso denegado. Solo los administradores pueden realizar esta acción.');
        }

        $viewData = [];
        $viewData['title'] = 'Editar Producto';
        $viewData['product'] = Product::findOrFail($id);
        $viewData['categories'] = Category::all();

        return view('product.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', 'Acceso denegado. Solo los administradores pueden realizar esta acción.');
        }

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

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->setImage($imagePath);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', 'Acceso denegado. Solo los administradores pueden realizar esta acción.');
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
