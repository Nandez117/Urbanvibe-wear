{{-- Autor: Esteban Alvarez Garcia --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/order-edit.css') }}">
@endpush

<div style="max-width: 800px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem;">
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
            <label for="status">Estado del pedido</label>
            <select id="status" name="status" required style="width: 100%; padding: 0.65rem; border: 1px solid var(--border-subtle); border-radius: 6px; background-color: var(--surface-input); color: var(--text-primary);">
                <option value="Pendiente" {{ old('status', $viewData['order']->getStatus()) === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            </select>
        </div>
        <div class="order-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn">Guardar pedido</button>
        </div>
    </form>

    <section class="order-section">
        <h3>Productos del pedido</h3>
        @forelse ($viewData['order']->getItems() as $item)
            <div style="display: flex; justify-content: space-between; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-subtle);">
                <span>{{ $item->getProduct()->getName() }} x {{ $item->getQuantity() }}</span>
                <strong>${{ number_format($item->getSubtotal(), 2) }}</strong>
            </div>
        @empty
            <p style="color: var(--text-gray);">Todavía no hay productos en este pedido.</p>
        @endforelse
    </section>

    <section class="order-section">
        <h3>Agregar producto</h3>
        <form method="POST" action="{{ route('order-items.store') }}">
            @csrf
            <input type="hidden" name="order_id" value="{{ $viewData['order']->getId() }}">
            <div class="order-form-field">
                <label for="product_id">Producto</label>
                <select id="product_id" name="product_id" required>
                    <option value="">Seleccione un producto</option>
                    @foreach ($viewData['products'] as $product)
                        <option value="{{ $product->getId() }}" data-stock="{{ $product->getStock() }}">{{ $product->getName() }} · {{ $product->getStock() }} disponibles</option>
                    @endforeach
                </select>
            </div>
            <div class="order-form-field">
                <label for="quantity">Cantidad</label>
                <div class="quantity-control">
                    <button class="quantity-button" type="button" data-quantity-action="decrease" aria-label="Disminuir cantidad">−</button>
                    <input class="quantity-input" id="quantity" type="number" name="quantity" min="1" value="1" required>
                    <button class="quantity-button" type="button" data-quantity-action="increase" aria-label="Aumentar cantidad">+</button>
                </div>
            </div>
            <button type="submit" class="btn">Agregar producto</button>
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
