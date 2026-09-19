
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<h2>{{ __('messages.cart_title') }}</h2>

<div class="table-container es-185d793c">
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
                    <form action="{{ route('cart.update', ['id' => $item['product']->getId()]) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->getStock() }}"
                               style="width: 60px; padding: 0.25rem; border-radius: 6px; border: 1px solid var(--border-subtle); background-color: var(--surface-input); color: var(--text-primary);">
                        <button type="submit" class="btn es-8fb9526e">{{ __('messages.btn_update') }}</button>
                    </form>
                </td>
                <td>${{ number_format($item['subtotal'], 2) }}</td>
                <td>
                    <form action="{{ route('cart.remove', ['id' => $item['product']->getId()]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn es-f04bb9c8">{{ __('messages.btn_delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['items']) === 0)
        <div class="es-80f9a287">{{ __('messages.cart_empty') }}</div>
    @endif
</div>

@if (count($viewData['items']) > 0)
<div class="es-78c73b27">
    <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('messages.btn_continue_shopping') }}</a>
    <div class="es-62eecf9b">
        <span class="es-9cf61fc5">{{ __('messages.lbl_total') }}: ${{ number_format($viewData['total'], 2) }}</span>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">{{ __('messages.btn_checkout') }}</button>
        </form>
    </div>
</div>
@else
<div class="es-cafd824d">
    <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('messages.nav_catalog') }}</a>
</div>
@endif
@endsection