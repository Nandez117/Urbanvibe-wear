<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Registrar pago';
        $viewData['order'] = Order::findOrFail($id);

        return view('payment.create')->with('viewData', $viewData);
    }

    public function store(StorePaymentRequest $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $payment = new Payment;
        $payment->setAmount((float) $request->input('amount'));
        $payment->setMethod($request->input('method'));
        $payment->setReference($request->input('reference'));
        $payment->setStatus('Aprobado');
        $payment->setOrderId($order->getId());
        $payment->save();

        $order->setStatus('Pagado');
        $order->save();

        return redirect()->route('payment.success', ['id' => $order->getId()]);
    }

    public function success(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Pago exitoso';
        $viewData['order'] = Order::findOrFail($id);

        return view('payment.success')->with('viewData', $viewData);
    }
}
