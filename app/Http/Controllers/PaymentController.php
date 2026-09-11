<?php

// Yan Frank Ríos López

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(string $id): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.payment_create_title');
        $viewData['order'] = Order::where('user_id', Auth::id())->findOrFail($id);

        abort_if($viewData['order']->getStatus() === 'Pagado', 403, 'Este pedido ya fue pagado.');

        return view('payment.create')->with('viewData', $viewData);
    }

    public function store(StorePaymentRequest $request, string $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        abort_if($order->getStatus() === 'Pagado', 403, 'Este pedido ya fue pagado.');
        abort_if($order->items()->doesntExist(), 422, 'No se puede pagar un pedido sin productos.');

        $payment = new Payment;
        $payment->setAmount((float) $request->input('amount'));
        $payment->setMethod($request->input('method'));
        $payment->setReference($request->input('reference'));
        $payment->setStatus('Aprobado');
        $payment->setOrderId($order->getId());
        $payment->save();

        foreach ($order->getItems() as $item) {
            $product = $item->getProduct();
            if ($product) {
                $newStock = $product->getStock() - $item->getQuantity();
                $product->setStock(max(0, $newStock));
                $product->save();
            }
        }

        $order->setStatus('Pagado');
        $order->save();

        return redirect()->route('payment.success', ['id' => $order->getId()]);
    }

    public function success(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Pago exitoso';
        $viewData['order'] = Order::where('user_id', Auth::id())->findOrFail($id);

        return view('payment.success')->with('viewData', $viewData);
    }
}
