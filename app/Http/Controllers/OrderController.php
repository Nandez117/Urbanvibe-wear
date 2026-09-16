<?php

// Autor: Esteban Alvarez Garcia

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
        $viewData['title'] = __('messages.orders_title');
        $viewData['orders'] = Order::with('user')
            ->where('user_id', Auth::id())
            ->get();

        return view('order.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.create_order');

        return view('order.create')->with('viewData', $viewData);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setTotalAmount(0);
        $order->setStatus('pending');
        $order->setUserId(Auth::id());
        $order->save();

        return redirect()->route('orders.edit', ['id' => $order->getId()])
            ->with('success', __('messages.order_created_add_products'));
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.edit_order');
        $viewData['order'] = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);

        abort_if($viewData['order']->getStatus() === 'paid', 403, __('messages.paid_orders_cannot_edit'));
        $viewData['products'] = Product::where('stock', '>', 0)->get();

        return view('order.edit')->with('viewData', $viewData);
    }

    public function update(UpdateOrderRequest $request, string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'paid', 403, __('messages.paid_orders_cannot_edit'));
        $order->setStatus($request->input('status'));
        $order->save();

        return redirect()->route('orders.index')->with('success', __('messages.order_update_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'paid', 403, __('messages.paid_orders_cannot_delete'));
        $order->delete();

        return redirect()->route('orders.index')->with('success', __('messages.order_delete_success'));
    }

    public function downloadInvoice(string $id): Response
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product', 'user', 'payment')
            ->findOrFail($id);

        abort_if($order->getStatus() !== 'paid', 403, __('messages.invoice_only_paid'));

        $viewData = [];
        $viewData['order'] = $order;
        $viewData['title'] = __('messages.invoice_title').' #'.$order->getOrderNumber();

        $pdf = Pdf::loadView('order.invoice', ['viewData' => $viewData]);

        return $pdf->download('factura_'.$order->getOrderNumber().'.pdf');
    }
}
