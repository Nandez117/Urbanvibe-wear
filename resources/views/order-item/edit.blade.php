{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-9b7d0058">
    <h2>{{ __('messages.edit_order_detail') }}</h2>
    <p>Producto: {{ $viewData['orderItem']->getProduct()->getName() }}</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('order-items.update', ['id' => $viewData['orderItem']->getId()]) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="order_id">{{ __('messages.order') }}</label>
            <select id="order_id" name="order_id" required>
                @foreach ($viewData['orders'] as $order)
                    <option value="{{ $order->getId() }}" {{ old('order_id', $viewData['orderItem']->getOrderId()) == $order->getId() ? 'selected' : '' }}>{{ $order->getOrderNumber() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="quantity">{{ __('messages.quantity') }}</label>
            <input id="quantity" type="number" name="quantity" min="1" value="{{ old('quantity', $viewData['orderItem']->getQuantity()) }}" required>
        </div>
        <button type="submit" class="btn">{{ __('messages.update_detail') }}</button>
        <a href="{{ route('order-items.index') }}" class="btn">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
