<?php

// Yan Frank Ríos López

namespace App\Services\Payments;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;

class CreditCardPaymentGateway implements PaymentGatewayInterface
{
    public function process(Order $order, array $paymentData): Payment
    {
        $reference = $paymentData['reference'] ?? 'CC-'.strtoupper(Str::random(10));

        $payment = new Payment;
        $payment->setAmount((float) $paymentData['amount']);
        $payment->setMethod('credit_card');
        $payment->setReference($reference);
        $payment->setStatus('approved');
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

        $order->setStatus('paid');
        $order->save();

        return $payment;
    }

    public function getGatewayName(): string
    {
        return 'credit_card';
    }
}
