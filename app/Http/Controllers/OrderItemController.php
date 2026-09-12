<?php

// Autor: Esteban Alvarez Garcia

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderItemController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Detalles de pedidos - Urbanvibe Wear';
        $viewData['orderItems'] = OrderItem::with(['product', 'order'])->get();

        return view('order-item.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.order_item_create_title');
        $viewData['products'] = Product::all();
        $viewData['orders'] = Order::all();

        return view('order-item.create')->with('viewData', $viewData);
    }

    public function store(StoreOrderItemRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $product = Product::findOrFail($request->input('product_id'));
            $order = Order::where('user_id', Auth::id())
                ->findOrFail($request->input('order_id'));
            abort_if($order->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden modificar.');
            $orderItem = new OrderItem;
            $orderItem->setQuantity((int) $request->input('quantity'));
            $orderItem->setUnitPrice($product->getPrice());
            $orderItem->setSubtotal($orderItem->calculateSubtotal());
            $orderItem->setProductId($product->getId());
            $orderItem->setOrderId($order->getId());
            $orderItem->save();

            $product->setStock($product->getStock() - $orderItem->getQuantity());
            $product->save();

            $order->setTotalAmount($order->items()->sum('subtotal'));
            $order->save();
        });

        return redirect()->route('orders.edit', ['id' => $request->input('order_id')])
            ->with('success', 'Producto agregado al pedido.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar detalle de pedido';
        $viewData['orderItem'] = OrderItem::with('order')->findOrFail($id);
        abort_if($viewData['orderItem']->getOrder()->getUserId() !== Auth::id(), 404);
        abort_if($viewData['orderItem']->getOrder()->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden modificar.');
        $viewData['orders'] = Order::where('user_id', Auth::id())
            ->where('status', '!=', 'Pagado')
            ->get();

        return view('order-item.edit')->with('viewData', $viewData);
    }

    public function update(UpdateOrderItemRequest $request, string $id): RedirectResponse
    {
        DB::transaction(function () use ($request, $id): void {
            $orderItem = OrderItem::with('product')->findOrFail($id);
            $order = Order::where('user_id', Auth::id())->findOrFail($orderItem->getOrderId());
            abort_if($order->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden modificar.');
            $product = $orderItem->getProduct();
            $quantityDifference = (int) $request->input('quantity') - $orderItem->getQuantity();
            $orderItem->setQuantity((int) $request->input('quantity'));
            $orderItem->setSubtotal($orderItem->calculateSubtotal());
            $orderItem->setOrderId((int) $request->input('order_id'));
            $orderItem->save();

            $product->setStock($product->getStock() - $quantityDifference);
            $product->save();

            $order->setTotalAmount($order->items()->sum('subtotal'));
            $order->save();
        });

        return redirect()->route('order-items.index')->with('success', 'Detalle de pedido actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        DB::transaction(function () use ($id): void {
            $orderItem = OrderItem::with('product')->findOrFail($id);
            $order = Order::where('user_id', Auth::id())->findOrFail($orderItem->getOrderId());
            abort_if($order->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden modificar.');
            $product = $orderItem->getProduct();
            $product->setStock($product->getStock() + $orderItem->getQuantity());
            $product->save();
            $orderItem->delete();

            $order->setTotalAmount($order->items()->sum('subtotal'));
            $order->save();
        });

        return redirect()->route('order-items.index')->with('success', 'Detalle de pedido eliminado correctamente.');
    }
}
