@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<h2>Carrito de compras</h2>

<div class="table-container" style="margin-top: 1.5rem;">
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
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
                        <button type="submit" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Actualizar</button>
                    </form>
                </td>
                <td>${{ number_format($item['subtotal'], 2) }}</td>
                <td>
                    <form action="{{ route('cart.remove', ['id' => $item['product']->getId()]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: var(--danger);">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['items']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">Tu carrito está vacío.</div>
    @endif
</div>

@if (count($viewData['items']) > 0)
<div style="display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; margin-top: 1.5rem; flex-wrap: wrap;">
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Seguir comprando</a>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <span style="font-size: 1.25rem; font-weight: 700;">Total: ${{ number_format($viewData['total'], 2) }}</span>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Proceder al pago</button>
        </form>
    </div>
</div>
@else
<div style="text-align: center; margin-top: 1.5rem;">
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Ver catálogo</a>
</div>
@endif
@endsection