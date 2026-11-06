<?php

// Esteban Alvarez Garcia

namespace App\Interfaces;

use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

interface InvoiceExporterInterface
{
    public function export(Order $order): Response;

    public function getFormat(): string;
}
