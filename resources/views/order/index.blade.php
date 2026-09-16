{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.orders_title') }}</h2>
    <a href="{{ route('products.index') }}" class="btn">{{ __('messages.nav_catalog') }}</a>
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
                <td>${{ number_format($order->getTotalAmount(), 2) }}</td>
                <td>{{ $order->getStatus() }}</td>
                <td>
                    <div class="actions-row">
                        @if (!$order->getPayment())
                            <a href="{{ route('payments.create', ['id' => $order->getId()]) }}" class="btn btn-sm btn-success">{{ __('messages.btn_register_payment') }}</a>
                        @else
                            <span style="color: var(--success); font-weight: 600;">{{ __('messages.status_paid') }}</span>
                        @endif
                        @if ($order->getStatus() !== 'Pagado')
                            <a href="{{ route('orders.edit', ['id' => $order->getId()]) }}" class="btn btn-sm">{{ __('messages.btn_edit') }}</a>
                            <form action="{{ route('orders.destroy', ['id' => $order->getId()]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.btn_delete') }}</button>
                            </form>
                        @else
                            <span style="color: var(--text-gray);"></span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['orders']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">{{ __('messages.no_orders') }}</div>
    @endif
</div>
@endsection