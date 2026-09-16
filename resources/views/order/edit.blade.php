{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/order-edit.css') }}">
@endpush

<div class="es-9b7d0058">
    <h2>Pedido: {{ $viewData['order']->getOrderNumber() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.update', ['id' => $viewData['order']->getId()]) }}">
        @csrf
        @method('PUT')
        <div class="order-form-field">
            <label for="status">{{ __('messages.order_status') }}</label>
            <select id="status" name="status" required class="es-de2eb184">
                <option value="Pendiente" {{ old('status', $viewData['order']->getStatus()) === 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
            </select>
        </div>
        <div class="order-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            <button type="submit" class="btn">{{ __('messages.save_order') }}</button>
        </div>
    </form>

    <section class="order-section">
        <h3>{{ __('messages.order_products') }}</h3>
        @forelse ($viewData['order']->getItems() as $item)
            <div class="es-d2041e54">
                <span>{{ $item->getProduct()->getName() }} x {{ $item->getQuantity() }}</span>
                <strong>${{ number_format($item->get{{ __('messages.subtotal') }}(), 2) }}</strong>
            </div>
        @empty
            <p class="es-1e36e7c9">{{ __('messages.no_products_in_order') }}</p>
        @endforelse
    </section>

    <section class="order-section">
        <h3>{{ __('messages.add_product') }}</h3>
        <form method="POST" action="{{ route('order-items.store') }}">
            @csrf
            <input type="hidden" name="order_id" value="{{ $viewData['order']->getId() }}">
            <div class="order-form-field">
                <label for="product_id">{{ __('messages.product_label') }}</label>
                <select id="product_id" name="product_id" required>
                    <option value="">{{ __('messages.select_product') }}</option>
                    @foreach ($viewData['products'] as $product)
                        <option value="{{ $product->getId() }}" data-stock="{{ $product->getStock() }}">{{ $product->getName() }} · {{ $product->getStock() }} disponibles</option>
                    @endforeach
                </select>
            </div>
            <div class="order-form-field">
                <label for="quantity">{{ __('messages.quantity') }}</label>
                <div class="quantity-control">
                    <button class="quantity-button" type="button" data-quantity-action="decrease" aria-label="Disminuir cantidad">−</button>
                    <input class="quantity-input" id="quantity" type="number" name="quantity" min="1" value="1" required>
                    <button class="quantity-button" type="button" data-quantity-action="increase" aria-label="Aumentar cantidad">+</button>
                </div>
            </div>
            <button type="submit" class="btn">{{ __('messages.add_product') }}</button>
        </form>
    </section>
</div>

<script>
    const quantityInput = document.getElementById('quantity');
    const productSelect = document.getElementById('product_id');

    function updateQuantity(value) {
        const maximum = Number(quantityInput.max) || Number.MAX_SAFE_INTEGER;
        quantityInput.value = Math.min(Math.max(value, 1), maximum);
    }

    document.querySelectorAll('[data-quantity-action]').forEach((button) => {
        button.addEventListener('click', () => {
            const change = button.dataset.quantityAction === 'increase' ? 1 : -1;
            updateQuantity(Number(quantityInput.value) + change);
        });
    });

    productSelect.addEventListener('change', () => {
        const selectedProduct = productSelect.options[productSelect.selectedIndex];
        quantityInput.max = selectedProduct.dataset.stock || '';
        updateQuantity(Number(quantityInput.value));
    });
</script>
@endsection
