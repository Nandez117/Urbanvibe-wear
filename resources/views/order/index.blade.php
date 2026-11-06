{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.orders_title') }}</h2>
    <a href="{{ route('product.index') }}" class="btn">{{ __('messages.nav_catalog') }}</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.lbl_order_number') }}</th>
                <th>{{ __('messages.lbl_client') }}</th>
                <th>{{ __('messages.lbl_creation_date') }}</th>
                <th>{{ __('messages.lbl_total_amount') }}</th>
                <th>{{ __('messages.lbl_status') }}</th>
                <th>{{ __('messages.lbl_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['orders'] as $order)
            <tr>
                <td>{{ $order->getOrderNumber() }}</td>
                <td>{{ $order->getUser()->getName() }}</td>
                <td>{{ $order->getCreatedAt() }}</td>
                <td>${{ number_format($order->getTotalAmount(), 2) }} USD</td>
                <td>{{ $order->getStatus() === 'paid' ? __('messages.status_paid') : __('messages.status_pending') }}</td>
                <td>
                    <div class="actions-row">
                        @if (!$order->getPayment())
                            <a href="{{ route('payment.create', ['id' => $order->getId()]) }}" class="btn btn-sm btn-success">{{ __('messages.btn_register_payment') }}</a>
                        @else
                            <a href="{{ route('order.invoice', ['id' => $order->getId(), 'format' => 'pdf']) }}" class="btn btn-sm btn-secondary" title="{{ __('messages.download_pdf') }}">
                                <i class="fa-solid fa-file-pdf"></i> PDF
                            </a>
                            <a href="{{ route('order.invoice', ['id' => $order->getId(), 'format' => 'csv']) }}" class="btn btn-sm btn-secondary" title="{{ __('messages.download_csv') }}">
                                <i class="fa-solid fa-file-csv"></i> CSV
                            </a>
                        @endif
                        @if ($order->getStatus() !== 'paid')
                            <a href="{{ route('order.edit', ['id' => $order->getId()]) }}" class="btn btn-sm">{{ __('messages.btn_edit') }}</a>
                            <form action="{{ route('order.destroy', ['id' => $order->getId()]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.btn_delete') }}</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($viewData['orders']->total() === 0)
        <div class="es-80f9a287">{{ __('messages.no_orders') }}</div>
    @elseif ($viewData['orders']->hasPages())
        <div class="admin-mt-4" style="display: flex; justify-content: center; padding: 1rem 0;">
            {{ $viewData['orders']->links() }}
        </div>
    @endif
</div>
@endsection
