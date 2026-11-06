<?php

// Esteban Alvarez Garcia

namespace App\Services\Invoices;

use App\Interfaces\InvoiceExporterInterface;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class PdfInvoiceExporter implements InvoiceExporterInterface
{
    public function export(Order $order): Response
    {
        $viewData = [];
        $viewData['order'] = $order;
        $viewData['title'] = __('messages.invoice_title').' #'.$order->getOrderNumber();

        $pdf = Pdf::loadView('order.invoice', ['viewData' => $viewData]);

        return $pdf->download('invoice_'.$order->getOrderNumber().'.pdf');
    }

    public function getFormat(): string
    {
        return 'pdf';
    }
}
