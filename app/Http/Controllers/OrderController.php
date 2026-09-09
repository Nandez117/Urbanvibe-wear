<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Pedidos - Urbanvibe Wear';
        $viewData['orders'] = Order::with('user')
            ->where('user_id', Auth::id())
            ->get();

        return view('order.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Crear pedido';

        return view('order.create')->with('viewData', $viewData);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setCreationDate(now()->toDateString());
        $order->setTotalAmount(0);
        $order->setStatus('Pendiente');
        $order->setUserId(Auth::id());
        $order->save();

        return redirect()->route('orders.edit', ['id' => $order->getId()])
            ->with('success', 'Pedido creado. Ahora agrega los productos.');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar pedido';
        $viewData['order'] = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);

        abort_if($viewData['order']->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden editar.');
        $viewData['products'] = Product::where('stock', '>', 0)->get();

        return view('order.edit')->with('viewData', $viewData);
    }

    public function update(UpdateOrderRequest $request, string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden editar.');
        $order->setStatus($request->input('status'));
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'Pagado', 403, 'Los pedidos pagados no se pueden eliminar.');
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pedido eliminado correctamente.');
    }

    public function downloadInvoice(string $id): Response
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product', 'user', 'payment')
            ->findOrFail($id);

        abort_if($order->getStatus() !== 'Pagado', 403, 'Solo se puede descargar factura de pedidos pagados.');

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['title'] = 'Factura Pedido #'.$order->getOrderNumber();

        $pdf = Pdf::loadView('order.invoice', ['viewData' => $viewData]);

        return $pdf->download('factura_'.$order->getOrderNumber().'.pdf');
    }
}
