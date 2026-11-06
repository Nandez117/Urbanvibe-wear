<?php

// Esteban Alvarez Garcia

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\Invoices\InvoiceExporterFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.orders_title');
        $viewData['orders'] = Order::with(['user', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

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

        return redirect()->route('order.edit', ['id' => $order->getId()])
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

        return redirect()->route('order.index')->with('success', __('messages.order_update_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'paid', 403, __('messages.paid_orders_cannot_delete'));
        $order->delete();

        return redirect()->route('order.index')->with('success', __('messages.order_delete_success'));
    }

    public function downloadInvoice(string $id, Request $request, InvoiceExporterFactory $factory): Response
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product', 'user', 'payment')
            ->findOrFail($id);

        abort_if($order->getStatus() !== 'paid', 403, __('messages.invoice_only_paid'));

        $format = (string) $request->query('format', 'pdf');
        $exporter = $factory->getExporter($format);

        return $exporter->export($order);
    }
}
