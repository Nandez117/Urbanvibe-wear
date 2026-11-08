<?php

// Yan Frank Ríos López

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(string $id): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.payment_create_title');
        $viewData['order'] = Order::where('user_id', Auth::id())->findOrFail($id);

        abort_if($viewData['order']->getStatus() === 'paid', 403, __('messages.order_already_paid'));

        return view('payment.create')->with('viewData', $viewData);
    }

    public function store(StorePaymentRequest $request, string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'paid', 403, __('messages.order_already_paid'));
        abort_if($order->items()->doesntExist(), 422, __('messages.cannot_pay_empty_order'));

        $this->orderService->processPayment($order, $request->only(['amount', 'method', 'reference']));

        return redirect()->route('payment.success', ['id' => $order->getId()]);
    }

    public function success(string $id): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.payment_success_title');
        $viewData['order'] = Order::where('user_id', Auth::id())->findOrFail($id);

        return view('payment.success')->with('viewData', $viewData);
    }
}
