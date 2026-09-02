@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Pedidos</h2>
    <a href="{{ route('orders.create') }}" class="btn">Crear pedido</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Número de pedido</th>
                <th>Cliente</th>
                <th>Fecha de creación</th>
                <th>Monto total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['orders'] as $order)
            <tr>
                <td>{{ $order->getOrderNumber() }}</td>
                <td>{{ $order->getUser()->getName() }}</td>
                <td>{{ $order->getCreationDate() }}</td>
                <td>${{ number_format($order->getTotalAmount(), 2) }}</td>
                <td>{{ $order->getStatus() }}</td>
                <td>
                    <a href="{{ route('orders.edit', ['id' => $order->getId()]) }}" class="btn">Editar</a>
                    <form action="{{ route('orders.destroy', ['id' => $order->getId()]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #ef4444;">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['orders']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">No hay pedidos registrados.</div>
    @endif
</div>
@endsection
