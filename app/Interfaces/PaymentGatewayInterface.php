<?php

// Yan Frank Ríos López

namespace App\Interfaces;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function process(Order $order, array $paymentData): Payment;

    public function getGatewayName(): string;
}
