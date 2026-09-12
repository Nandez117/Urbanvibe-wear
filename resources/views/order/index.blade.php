{{-- Autor: Esteban Alvarez Garcia --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Pedidos</h2>
    <a href="{{ route('products.index') }}" class="btn">Ir al catálogo</a>
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
                <th>{{ __('messages.lbl_actions') }}</th>
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
                    <div class="actions-row">
                        @if (!$order->getPayment())
                            <a href="{{ route('payments.create', ['id' => $order->getId()]) }}" class="btn btn-sm btn-success">Registrar pago</a>
                        @else
                            <span style="color: var(--success); font-weight: 600;">Pagado</span>
                        @endif
                        @if ($order->getStatus() !== 'Pagado')
                            <a href="{{ route('orders.edit', ['id' => $order->getId()]) }}" class="btn btn-sm">{{ __('messages.btn_edit') }}</a>
                            <form action="{{ route('orders.destroy', ['id' => $order->getId()]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.btn_delete') }}</button>
                            </form>
                        @else
                            <span style="color: var(--text-gray);"></span>
                        @endif
                    </div>
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