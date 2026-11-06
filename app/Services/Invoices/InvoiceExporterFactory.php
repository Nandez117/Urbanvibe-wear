<?php

// Esteban Alvarez Garcia

namespace App\Services\Invoices;

use App\Interfaces\InvoiceExporterInterface;
use InvalidArgumentException;

class InvoiceExporterFactory
{
    private PdfInvoiceExporter $pdfExporter;

    private CsvInvoiceExporter $csvExporter;

    public function __construct(PdfInvoiceExporter $pdfExporter, CsvInvoiceExporter $csvExporter)
    {
        $this->pdfExporter = $pdfExporter;
        $this->csvExporter = $csvExporter;
    }

    public function getExporter(string $format): InvoiceExporterInterface
    {
        $format = strtolower($format);

        return match ($format) {
            'csv', 'excel' => $this->csvExporter,
            'pdf' => $this->pdfExporter,
            default => throw new InvalidArgumentException("Unsupported invoice export format: [{$format}]. Supported formats: pdf, csv."),
        };
    }
}
