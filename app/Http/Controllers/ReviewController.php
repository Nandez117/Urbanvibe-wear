<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Reseñas - Urbanvibe Wear';
        $viewData['reviews'] = Review::with(['user', 'product'])->get();

        return view('review.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Registrar reseña';
        $viewData['users'] = User::all();
        $viewData['products'] = Product::all();

        return view('review.create')->with('viewData', $viewData);
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $review = new Review;
        $review->setRating((int) $request->input('rating'));
        $review->setComment($request->input('comment'));
        $review->setCreationDate(now()->toDateString());
        $review->setUserId((int) $request->input('user_id'));
        $review->setProductId((int) $request->input('product_id'));
        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Reseña registrada correctamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar reseña';
        $viewData['review'] = Review::findOrFail($id);
        $viewData['users'] = User::all();
        $viewData['products'] = Product::all();

        return view('review.edit')->with('viewData', $viewData);
    }

    public function update(UpdateReviewRequest $request, string $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $review->setRating((int) $request->input('rating'));
        $review->setComment($request->input('comment'));
        $review->setUserId((int) $request->input('user_id'));
        $review->setProductId((int) $request->input('product_id'));
        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Reseña actualizada correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Reseña eliminada correctamente.');
    }
}
