@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Detalles de pedidos</h2>
    <a href="{{ route('order-items.create') }}" class="btn">Registrar detalle</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
                <th>Acciones</th>
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
                    <a href="{{ route('order-items.edit', ['id' => $orderItem->getId()]) }}" class="btn">Editar</a>
                    <form action="{{ route('order-items.destroy', ['id' => $orderItem->getId()]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #ef4444;">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['orderItems']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">No hay detalles de pedidos registrados.</div>
    @endif
</div>
@endsection
