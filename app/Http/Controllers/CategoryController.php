<?php

// Autor: Juan Manuel Hernandez Martelo

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
        $viewData['title'] = __('messages.category_index_title');
        $viewData['categories'] = Category::all();

        return view('category.index')->with('viewData', $viewData);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = new Category;
        $category->setName($request->input('name'));
        $category->save();

        return redirect()->route('categories.index')->with('success', __('messages.category_create_success'));
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.category_edit_title');
        $viewData['category'] = Category::findOrFail($id);

        return view('category.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->setName($request->input('name'));
        $category->save();

        return redirect()->route('categories.index')->with('success', __('messages.category_update_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $hasProducts = Product::where('category_id', $category->getId())->exists();

        if ($hasProducts) {
            return redirect()->route('categories.index')->with('error', __('messages.category_delete_error'));
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', __('messages.category_delete_success'));
    }
}
