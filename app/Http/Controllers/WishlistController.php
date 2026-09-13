<?php

// Autor: Juan Manuel Hernandez Martelo

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $viewData = [];
        $viewData['title'] = __('messages.wishlist_title');
        $viewData['wishlists'] = Wishlist::with('product')->where('user_id', Auth::id())->get();

        return view('wishlist.index')->with('viewData', $viewData);
    }

    public function store(string $productId): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
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
            return redirect()->route('login');
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
            return redirect()->route('login');
        }

        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();

        if ($wishlists->isEmpty()) {
            return redirect()->route('wishlist.index')->with('error', 'Tu lista de deseos está vacía.');
        }

        $totalAmount = 0;
        foreach ($wishlists as $wishlist) {
            $totalAmount += $wishlist->getProduct()->getPrice();
        }

        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setCreationDate(now()->toDateString());
        $order->setTotalAmount($totalAmount);
        $order->setStatus('Pendiente');
        $order->setUserId(Auth::id());
        $order->save();

        foreach ($wishlists as $wishlist) {
            $product = $wishlist->getProduct();
            $orderItem = new OrderItem;
            $orderItem->setQuantity(1);
            $orderItem->setUnitPrice($product->getPrice());
            $orderItem->setSubtotal($product->getPrice());
            $orderItem->setProductId($product->getId());
            $orderItem->setOrderId($order->getId());
            $orderItem->save();
        }

        // Clear wishlist after creating order
        Wishlist::where('user_id', Auth::id())->delete();

        return redirect()->route('payments.create', ['id' => $order->getId()])
            ->with('success', 'Pedido creado desde tu lista de deseos. Ahora completa tu pago.');
    }
}
