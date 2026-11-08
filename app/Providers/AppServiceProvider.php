<?php

// Juan Manuel Hernandez Martelo, Esteban Alvarez Garcia, Yan Frank Ríos López

namespace App\Providers;

use App\Interfaces\InvoiceExporterInterface;
use App\Interfaces\PaymentGatewayInterface;
use App\Services\Invoices\PdfInvoiceExporter;
use App\Services\Payments\CreditCardPaymentGateway;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(InvoiceExporterInterface::class, PdfInvoiceExporter::class);
        $this->app->bind(PaymentGatewayInterface::class, CreditCardPaymentGateway::class);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
