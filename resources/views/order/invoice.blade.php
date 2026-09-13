{{-- Autor: Esteban Alvarez Garcia --}}
@extends('layouts.app')
@section('title', 'Factura ' . $viewData['order']->getOrderNumber())
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
@endpush

@section('content')
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
            @foreach($viewData['order']->getItems() as $item)
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
@endsection