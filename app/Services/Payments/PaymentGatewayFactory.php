<?php

// Yan Frank Ríos López

namespace App\Services\Payments;

use App\Interfaces\PaymentGatewayInterface;

class PaymentGatewayFactory
{
    private CreditCardPaymentGateway $creditCardGateway;

    private PaypalPaymentGateway $paypalGateway;

    public function __construct(CreditCardPaymentGateway $creditCardGateway, PaypalPaymentGateway $paypalGateway)
    {
        $this->creditCardGateway = $creditCardGateway;
        $this->paypalGateway = $paypalGateway;
    }

    public function getGateway(?string $method = null): PaymentGatewayInterface
    {
        return match (strtolower((string) $method)) {
            'paypal' => $this->paypalGateway,
            default => $this->creditCardGateway,
        };
    }
}
