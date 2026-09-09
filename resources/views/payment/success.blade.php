@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<div class="container py-5 text-center">
    <div style="max-width: 500px; margin: 0 auto; background: var(--surface); padding: 3rem; border-radius: 12px; border: 1px solid var(--border-subtle);">
        <i class="fa-solid fa-circle-check text-success" style="font-size: 4rem; color: #22c55e; margin-bottom: 1rem;"></i>
        <h2 class="text-white mb-3">¡Pago Exitoso!</h2>
        <p class="text-secondary mb-4">Tu pedido <strong>{{ $viewData['order']->getOrderNumber() }}</strong> ha sido procesado correctamente.</p>
        
        <div class="d-grid gap-3" style="display:flex; flex-direction:column; gap:1rem;">
            <a href="{{ route('orders.invoice', ['id' => $viewData['order']->getId()]) }}" class="btn" style="background: #ef4444; color: white; padding: 1rem; font-weight: bold; font-size: 1.1rem; border-radius: 8px;">
                <i class="fa-solid fa-file-pdf"></i> Descargar Factura PDF
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light">Volver al Catálogo</a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-light">Ver mis pedidos</a>
        </div>
    </div>
</div>
@endsection