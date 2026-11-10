{{--  Yan Frank R�os L�pez  --}}

@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<h2>{{ __('messages.cart_title') }}</h2>

<div class="table-container mt-15">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.lbl_product') }}</th>
                <th>{{ __('messages.lbl_unit_price') }}</th>
                <th>{{ __('messages.lbl_quantity') }}</th>
                <th>{{ __('messages.lbl_subtotal') }}</th>
                <th>{{ __('messages.lbl_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['items'] as $item)
            <tr>
                <td>{{ $item['product']->getName() }}</td>
                <td>${{ number_format($item['product']->getPrice(), 2) }}</td>
                <td>
                    <form action="{{ route('cart.update', ['id' => $item['product']->getId()]) }}" method="POST" class="cart-qty-form">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->getStock() }}" class="cart-qty-input">
                        <button type="submit" class="btn btn-sm">{{ __('messages.btn_update') }}</button>
                    </form>
                </td>
                <td>${{ number_format($item['subtotal'], 2) }}</td>
                <td>
                    <form action="{{ route('cart.remove', ['id' => $item['product']->getId()]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-bg">{{ __('messages.btn_delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['items']) === 0)
        <div class="empty-state">{{ __('messages.cart_empty') }}</div>
    @endif
</div>

@if (count($viewData['items']) > 0)
<div class="cart-footer-bar">
    <a href="{{ route('product.index') }}" class="btn btn-secondary">{{ __('messages.btn_continue_shopping') }}</a>
    <div class="cart-total-group">
        <span class="cart-total-amount">{{ __('messages.lbl_total') }}: ${{ number_format($viewData['total'], 2) }}</span>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">{{ __('messages.btn_checkout') }}</button>
        </form>
    </div>
</div>
@else
<div class="text-center-mt">
    <a href="{{ route('product.index') }}" class="btn btn-secondary">{{ __('messages.nav_catalog') }}</a>
</div>
@endif
@endsection