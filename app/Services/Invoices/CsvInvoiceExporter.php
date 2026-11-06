<?php

// Esteban Alvarez Garcia

namespace App\Services\Invoices;

use App\Interfaces\InvoiceExporterInterface;
use App\Models\Order;
use Illuminate\Http\Response;

class CsvInvoiceExporter implements InvoiceExporterInterface
{
    public function export(Order $order): Response
    {
        $orderNumber = $order->getOrderNumber();
        $date = $order->getCreatedAt();
        $customer = $order->getUser()->getName();
        $email = $order->getUser()->getEmail();
        $total = number_format($order->getTotalAmount(), 2);
        $status = $order->getStatus();

        $rows = [];
        $rows[] = ['URBANVIBE WEAR - INVOICE'];
        $rows[] = ['Order Number', $orderNumber];
        $rows[] = ['Customer', $customer];
        $rows[] = ['Email', $email];
        $rows[] = ['Date', $date];
        $rows[] = ['Status', $status];
        $rows[] = [];
        $rows[] = ['Item ID', 'Product', 'Unit Price (USD)', 'Quantity', 'Subtotal (USD)'];

        foreach ($order->getItems() as $item) {
            $productName = $item->getProduct() ? $item->getProduct()->getName() : 'N/A';
            $rows[] = [
                $item->getId(),
                $productName,
                number_format($item->getUnitPrice(), 2),
                $item->getQuantity(),
                number_format($item->getSubtotal(), 2),
            ];
        }

        $rows[] = [];
        $rows[] = ['', '', '', 'TOTAL (USD):', '$'.$total];

        $output = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        $filename = 'invoice_'.$orderNumber.'.csv';

        return new Response($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function getFormat(): string
    {
        return 'csv';
    }
}
