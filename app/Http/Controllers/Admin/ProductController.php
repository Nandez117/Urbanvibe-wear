<?php

// Juan Manuel Hernandez Martelo

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', __('messages.access_denied_admin'));
        }

        $viewData = [];
        $viewData['title'] = __('messages.products');
        $viewData['products'] = Product::all();

        return view('admin.product.index')->with('viewData', $viewData);
    }

    public function create(): View|RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', __('messages.access_denied_admin'));
        }

        $viewData = [];
        $viewData['title'] = __('messages.product_create_title');
        $viewData['categories'] = Category::all();

        return view('admin.product.create')->with('viewData', $viewData);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', __('messages.access_denied_admin'));
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

        return redirect()->route('admin.products.index')->with('success', __('messages.product_create_success'));
    }

    public function edit(string $id): View|RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', __('messages.access_denied_admin'));
        }

        $viewData = [];
        $viewData['title'] = __('messages.title_edit_product');
        $viewData['product'] = Product::findOrFail($id);
        $viewData['categories'] = Category::all();

        return view('admin.product.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', __('messages.access_denied_admin'));
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

        return redirect()->route('admin.products.index')->with('success', __('messages.product_update_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        if (! Auth::check() || Auth::user()->getRole() !== 'admin') {
            return redirect()->route('products.index')->with('error', __('messages.access_denied_admin'));
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('messages.product_delete_success'));
    }
}
