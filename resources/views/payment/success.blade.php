@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="form-card" style="text-align: center;">
        <i class="fa-solid fa-circle-check" style="font-size: 3rem; color: var(--success); margin-bottom: 1rem;"></i>
        <h2>¡Pago exitoso!</h2>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
            Tu pedido <strong>{{ $viewData['order']->getOrderNumber() }}</strong> por
            ${{ number_format($viewData['order']->getTotalAmount(), 2) }} ha sido pagado correctamente.
        </p>
        <div class="actions-row" style="justify-content: center;">
            <a href="{{ route('home') }}" class="btn">Volver al inicio</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Ver mis pedidos</a>
        </div>
    </div>
</div>
@endsection