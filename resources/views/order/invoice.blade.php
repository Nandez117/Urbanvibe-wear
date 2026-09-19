{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', __('messages.invoice_title') . ' ' . $viewData['order']->getOrderNumber())
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
@endpush

@section('content')
    <div class="header">
        <h1>Urbanvibe Wear</h1>
        <p>{{ __('messages.electronic_receipt') }}</p>
    </div>

    <table class="details">
        <tr>
            <td>
                <strong>{{ __('messages.lbl_client') }}:</strong> {{ $viewData['order']->getUser()->getName() }}<br>
                <strong>{{ __('messages.lbl_email') }}:</strong> {{ $viewData['order']->getUser()->getEmail() }}
            </td>
            <td>
                <strong>{{ __('messages.lbl_order_number') }}:</strong> {{ $viewData['order']->getOrderNumber() }}<br>
                <strong>{{ __('messages.lbl_date') }}:</strong> {{ $viewData['order']->getCreatedAt() }}<br>
                <strong>{{ __('messages.lbl_status') }}:</strong> {{ $viewData['order']->getStatus() }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>{{ __('messages.lbl_product') }}</th>
                <th>{{ __('messages.lbl_unit_price') }}</th>
                <th>{{ __('messages.lbl_quantity') }}</th>
                <th>{{ __('messages.lbl_subtotal') }}</th>
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
                <td colspan="3" class="es-7851dbc0">{{ __('messages.lbl_total_paid') }}:</td>
                <td>${{ number_format($viewData['order']->getTotalAmount(), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>{{ __('messages.invoice_footer') }}</p>
    </div>
@endsection