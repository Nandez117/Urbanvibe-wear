<?php

// Juan Manuel Hernandez Martelo

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login.index');
        }

        $viewData = [];
        $viewData['title'] = __('messages.wishlist_title');
        $viewData['wishlists'] = Wishlist::with('product')->where('user_id', Auth::id())->get();

        return view('wishlist.index')->with('viewData', $viewData);
    }

    public function store(string $productId): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login.index');
        }

        $user = Auth::user();

        $exists = Wishlist::where('user_id', $user->getId())
            ->where('product_id', $productId)
            ->exists();

        if (! $exists) {
            $wishlist = new Wishlist;
            $wishlist->setUserId($user->getId());
            $wishlist->setProductId($productId);
            $wishlist->save();
        }

        return redirect()->back()->with('success', __('messages.wishlist_add_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login.index');
        }

        $wishlist = Wishlist::findOrFail($id);

        if ($wishlist->getUserId() === Auth::id()) {
            $wishlist->delete();
        }

        return redirect()->route('wishlist.index')->with('success', __('messages.wishlist_remove_success'));
    }

    public function checkout(): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login.index');
        }

        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();

        if ($wishlists->isEmpty()) {
            return redirect()->route('wishlist.index')->with('error', __('messages.wishlist_empty'));
        }

        $totalAmount = 0;
        foreach ($wishlists as $wishlist) {
            $totalAmount += $wishlist->getProduct()->getPrice();
        }

        $order = $this->orderService->createOrderFromWishlists($wishlists, $totalAmount, Auth::id());

        Wishlist::where('user_id', Auth::id())->delete();

        return redirect()->route('payments.create', ['id' => $order->getId()])
            ->with('success', __('messages.wishlist_order_created'));
    }
}
