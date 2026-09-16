{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-9b7d0058">
    <h2>{{ __('messages.register_detail') }} de pedido</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('order-items.store') }}">
        @csrf
        <div>
            <label for="order_id">{{ __('messages.order') }}</label>
            <select id="order_id" name="order_id" required>
                <option value="">{{ __('messages.select_order') }}</option>
                @foreach ($viewData['orders'] as $order)
                    <option value="{{ $order->getId() }}" {{ old('order_id') == $order->getId() ? 'selected' : '' }}>{{ $order->getOrderNumber() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="product_id">{{ __('messages.product_label') }}</label>
            <select id="product_id" name="product_id" required>
                <option value="">{{ __('messages.select_product') }}</option>
                @foreach ($viewData['products'] as $product)
                    <option value="{{ $product->getId() }}" {{ old('product_id') == $product->getId() ? 'selected' : '' }}>{{ $product->getName() }} (Stock: {{ $product->getStock() }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="quantity">{{ __('messages.quantity') }}</label>
            <input id="quantity" type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
        </div>
        <button type="submit" class="btn">{{ __('messages.register_detail') }}</button>
        <a href="{{ route('order-items.index') }}" class="btn">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
