{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.order_details') }}</h2>
    <a href="{{ route('orderItem.create') }}" class="btn">{{ __('messages.register_detail') }}</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.order') }}</th>
                <th>{{ __('messages.product_label') }}</th>
                <th>{{ __('messages.quantity') }}</th>
                <th>{{ __('messages.unit_price') }}</th>
                <th>{{ __('messages.subtotal') }}</th>
                <th>{{ __('messages.lbl_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['orderItems'] as $orderItem)
            <tr>
                <td>{{ $orderItem->getOrder()->getOrderNumber() }}</td>
                <td>{{ $orderItem->getProduct()->getName() }}</td>
                <td>{{ $orderItem->getQuantity() }}</td>
                <td>${{ number_format($orderItem->getUnitPrice(), 2) }}</td>
                <td>${{ number_format($orderItem->getSubtotal(), 2) }}</td>
                <td>
                    <div class="actions-row">
                        <a href="{{ route('orderItem.edit', ['id' => $orderItem->getId()]) }}" class="btn btn-sm btn-secondary">{{ __('messages.btn_edit') }}</a>
                        <form action="{{ route('orderItem.destroy', ['id' => $orderItem->getId()]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.btn_delete') }}</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['orderItems']) === 0)
        <div class="es-80f9a287">{{ __('messages.no_order_details') }}</div>
    @endif
</div>
@endsection
