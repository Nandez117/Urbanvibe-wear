<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $viewData['order']->getOrderNumber() }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        .details { width: 100%; margin-bottom: 30px; }
        .details td { vertical-align: top; width: 50%; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .items-table th { background-color: #f4f4f4; }
        .total-row { font-weight: bold; font-size: 18px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 50px; border-top: 1px solid #ddd; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Urbanvibe Wear</h1>
        <p>Comprobante de Pago Electrónico</p>
    </div>

    <table class="details">
        <tr>
            <td>
                <strong>Cliente:</strong> {{ $viewData['order']->getUser()->getName() }}<br>
                <strong>Email:</strong> {{ $viewData['order']->getUser()->getEmail() }}
            </td>
            <td>
                <strong>No. Pedido:</strong> {{ $viewData['order']->getOrderNumber() }}<br>
                <strong>Fecha:</strong> {{ $viewData['order']->getCreationDate() }}<br>
                <strong>Estado:</strong> {{ $viewData['order']->getStatus() }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unit.</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viewData['order']->items as $item)
            <tr>
                <td>{{ $item->getProduct()->getName() }}</td>
                <td>${{ number_format($item->getUnitPrice(), 2) }}</td>
                <td>{{ $item->getQuantity() }}</td>
                <td>${{ number_format($item->getUnitPrice() * $item->getQuantity(), 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">Total Pagado:</td>
                <td>${{ number_format($viewData['order']->getTotalAmount(), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Gracias por tu compra en Urbanvibe Wear. Si tienes alguna duda, contáctanos a soporte@urbanvibe.com</p>
    </div>
</body>
</html>