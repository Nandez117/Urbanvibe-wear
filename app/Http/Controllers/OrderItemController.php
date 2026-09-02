<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
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
        $viewData['title'] = 'Registrar detalle de pedido';
        $viewData['products'] = Product::all();
        $viewData['orders'] = Order::all();

        return view('order-item.create')->with('viewData', $viewData);
    }

    public function store(StoreOrderItemRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $product = Product::findOrFail($request->input('product_id'));
            $orderItem = new OrderItem;
            $orderItem->setQuantity((int) $request->input('quantity'));
            $orderItem->setUnitPrice($product->getPrice());
            $orderItem->setSubtotal($orderItem->calculateSubtotal());
            $orderItem->setProductId($product->getId());
            $orderItem->setOrderId((int) $request->input('order_id'));
            $orderItem->save();

            $product->setStock($product->getStock() - $orderItem->getQuantity());
            $product->save();
        });

        return redirect()->route('order-items.index')->with('success', 'Detalle de pedido registrado correctamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar detalle de pedido';
        $viewData['orderItem'] = OrderItem::findOrFail($id);
        $viewData['orders'] = Order::all();

        return view('order-item.edit')->with('viewData', $viewData);
    }

    public function update(UpdateOrderItemRequest $request, string $id): RedirectResponse
    {
        DB::transaction(function () use ($request, $id): void {
            $orderItem = OrderItem::with('product')->findOrFail($id);
            $product = $orderItem->getProduct();
            $quantityDifference = (int) $request->input('quantity') - $orderItem->getQuantity();
            $orderItem->setQuantity((int) $request->input('quantity'));
            $orderItem->setSubtotal($orderItem->calculateSubtotal());
            $orderItem->setOrderId((int) $request->input('order_id'));
            $orderItem->save();

            $product->setStock($product->getStock() - $quantityDifference);
            $product->save();
        });

        return redirect()->route('order-items.index')->with('success', 'Detalle de pedido actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        DB::transaction(function () use ($id): void {
            $orderItem = OrderItem::with('product')->findOrFail($id);
            $product = $orderItem->getProduct();
            $product->setStock($product->getStock() + $orderItem->getQuantity());
            $product->save();
            $orderItem->delete();
        });

        return redirect()->route('order-items.index')->with('success', 'Detalle de pedido eliminado correctamente.');
    }
}
