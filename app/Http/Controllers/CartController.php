<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private Cart $cart) {}

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Carrito de compras';
        $viewData['items'] = $this->cart->getItems();
        $viewData['total'] = $this->cart->getTotal();

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(AddToCartRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $this->cart->addProduct($product->getId(), (int) $request->input('quantity'));

        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito.');
    }

    public function update(UpdateCartRequest $request, string $id): RedirectResponse
    {
        $this->cart->updateQuantity((int) $id, (int) $request->input('quantity'));

        return redirect()->route('cart.index')->with('success', 'Carrito actualizado.');
    }

    public function remove(string $id): RedirectResponse
    {
        $this->cart->removeProduct((int) $id);

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    public function checkout(): RedirectResponse
    {
        $items = $this->cart->getItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setCreationDate(now()->toDateString());
        $order->setTotalAmount($this->cart->getTotal());
        $order->setStatus('Pendiente');
        $order->setUserId(Auth::id());
        $order->save();

        foreach ($items as $item) {
            $orderItem = new OrderItem;
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setUnitPrice($item['product']->getPrice());
            $orderItem->setSubtotal($item['subtotal']);
            $orderItem->setProductId($item['product']->getId());
            $orderItem->setOrderId($order->getId());
            $orderItem->save();
        }

        $this->cart->clear();

        return redirect()->route('payments.create', ['id' => $order->getId()])
            ->with('success', 'Pedido creado. Ahora completa tu pago.');
    }
}