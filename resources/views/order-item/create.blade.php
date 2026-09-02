@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem;">
    <h2>Registrar detalle de pedido</h2>

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
            <label for="order_id">Pedido</label>
            <select id="order_id" name="order_id" required>
                <option value="">Seleccione un pedido</option>
                @foreach ($viewData['orders'] as $order)
                    <option value="{{ $order->getId() }}" {{ old('order_id') == $order->getId() ? 'selected' : '' }}>{{ $order->getOrderNumber() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="product_id">Producto</label>
            <select id="product_id" name="product_id" required>
                <option value="">Seleccione un producto</option>
                @foreach ($viewData['products'] as $product)
                    <option value="{{ $product->getId() }}" {{ old('product_id') == $product->getId() ? 'selected' : '' }}>{{ $product->getName() }} (Stock: {{ $product->getStock() }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="quantity">Cantidad</label>
            <input id="quantity" type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
        </div>
        <button type="submit" class="btn">Registrar detalle</button>
        <a href="{{ route('order-items.index') }}" class="btn">Cancelar</a>
    </form>
</div>
@endsection
