<?php

// Esteban Alvarez Garcia

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
        $user = auth()->user();

        $query = Review::with(['user', 'product'])->orderBy('id', 'desc');

        // Clients can only see their own reviews; admins see all of them.
        if ($user->getRole() !== 'admin') {
            $query->where('user_id', $user->getId());
        }

        $viewData = [];
        $viewData['title'] = __('messages.review_index_title');
        $viewData['reviews'] = $query->paginate(8);

        return view('review.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.review_create_title');
        $viewData['products'] = Product::all();

        return view('review.create')->with('viewData', $viewData);
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $review = new Review;
        $review->setRating((int) $request->input('rating'));
        $review->setComment($request->input('comment'));
        // The review always belongs to the authenticated user; never trust client input.
        $review->setUserId((int) auth()->id());
        $review->setProductId((int) $request->input('product_id'));
        $review->save();

        if (request()->has('from_product')) {
            return back()->with('success', __('messages.review_create_success'));
        }

        return redirect()->route('review.index')->with('success', __('messages.review_create_success'));
    }

    public function edit(string $id): View
    {
        $review = Review::findOrFail($id);
        $this->authorizeReviewAccess($review);

        $viewData = [];
        $viewData['title'] = __('messages.review_edit_title');
        $viewData['review'] = $review;
        $viewData['products'] = Product::all();

        return view('review.edit')->with('viewData', $viewData);
    }

    public function update(UpdateReviewRequest $request, string $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $this->authorizeReviewAccess($review);

        $review->setRating((int) $request->input('rating'));
        $review->setComment($request->input('comment'));
        $review->setProductId((int) $request->input('product_id'));
        $review->save();

        return redirect()->route('review.index')->with('success', __('messages.review_update_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $this->authorizeReviewAccess($review);

        $review->delete();

        return redirect()->route('review.index')->with('success', __('messages.review_delete_success'));
    }

    /**
     * Only the review owner or an admin may edit/update/delete a review.
     */
    private function authorizeReviewAccess(Review $review): void
    {
        $user = auth()->user();

        abort_unless(
            $user->getRole() === 'admin' || $review->getUserId() === $user->getId(),
            403,
            __('messages.review_access_denied')
        );
    }
}
