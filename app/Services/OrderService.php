<?php

// Juan Manuel Hernandez Martelo

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrderFromCart(array $items, float $totalAmount, int $userId): Order
    {
        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setTotalAmount($totalAmount);
        $order->setStatus('pending');
        $order->setUserId($userId);
        $order->save();

        foreach ($items as $item) {
            $orderItem = new OrderItem;
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setUnitPrice($item['product']->getPrice());
            $orderItem->setSubtotal($item['subtotal']);
            $orderItem->setProductId($item['product']->getId());
            $orderItem->setOrderId($order->getId());
            $orderItem->save();
        }

        return $order;
    }

    public function processPayment(Order $order, array $paymentData): Payment
    {
        $payment = new Payment;
        $payment->setAmount((float) $paymentData['amount']);
        $payment->setMethod($paymentData['method']);
        $payment->setReference($paymentData['reference']);
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

    public function createOrderFromWishlists($wishlists, float $totalAmount, int $userId): Order
    {
        $order = new Order;
        $order->setOrderNumber('ORD-'.strtoupper(Str::random(10)));
        $order->setTotalAmount($totalAmount);
        $order->setStatus('pending');
        $order->setUserId($userId);
        $order->save();

        foreach ($wishlists as $wishlist) {
            $product = $wishlist->getProduct();
            $orderItem = new OrderItem;
            $orderItem->setQuantity(1);
            $orderItem->setUnitPrice($product->getPrice());
            $orderItem->setSubtotal($product->getPrice());
            $orderItem->setProductId($product->getId());
            $orderItem->setOrderId($order->getId());
            $orderItem->save();
        }

        return $order;
    }
}
