<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Pedidos - Urbanvibe Wear';
        $viewData['orders'] = Order::with('user')->get();

        return view('order.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Crear pedido';
        $viewData['users'] = User::all();

        return view('order.create')->with('viewData', $viewData);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setCreationDate(now()->toDateString());
        $order->setTotalAmount((float) $request->input('totalAmount'));
        $order->setStatus('Pendiente');
        $order->setUserId((int) $request->input('user_id'));
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Pedido creado correctamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar pedido';
        $viewData['order'] = Order::findOrFail($id);
        $viewData['users'] = User::all();

        return view('order.edit')->with('viewData', $viewData);
    }

    public function update(UpdateOrderRequest $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $order->setTotalAmount((float) $request->input('totalAmount'));
        $order->setStatus($request->input('status'));
        $order->setUserId((int) $request->input('user_id'));
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
