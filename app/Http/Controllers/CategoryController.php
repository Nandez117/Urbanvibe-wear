<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Categorías - Urbanvibe Wear';
        $viewData['categories'] = Category::all();

        return view('category.index')->with('viewData', $viewData);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = new Category;
        $category->setName($request->input('name'));
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar Categoría';
        $viewData['category'] = Category::findOrFail($id);

        return view('category.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->setName($request->input('name'));
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        // Regla de integridad referencial: No eliminar si hay productos asociados
        $hasProducts = Product::where('category_id', $category->getId())->exists();

        if ($hasProducts) {
            return redirect()->route('categories.index')->with('error', 'No se puede eliminar la categoría porque tiene productos asignados. Reasigna los productos primero.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
