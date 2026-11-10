{{--  Yan Frank R�os L�pez  --}}
@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<div class="container py-5 text-center">
    <div class="es-f8414db6">
        <i class="fa-solid fa-circle-check text-success es-75c37f04"></i>
        <h2 class="text-white mb-3">{{ __('messages.payment_successful') }}</h2>
        <p class="text-secondary mb-4">{{ __('messages.your_order') }} <strong>{{ $viewData['order']->getOrderNumber() }}</strong> {{ __('messages.processed_successfully') }}</p>
        
        <div class="d-grid gap-3 es-c561bdf0">
            <div style="display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('order.invoice', ['id' => $viewData['order']->getId(), 'format' => 'pdf']) }}" class="btn" style="background: var(--danger); color: var(--text-on-accent); padding: 0.85rem 1.5rem; font-weight: bold; border-radius: 8px;">
                    <i class="fa-solid fa-file-pdf"></i> {{ __('messages.download_pdf') }}
                </a>
                <a href="{{ route('order.invoice', ['id' => $viewData['order']->getId(), 'format' => 'csv']) }}" class="btn" style="background: var(--success); color: var(--text-on-accent); padding: 0.85rem 1.5rem; font-weight: bold; border-radius: 8px;">
                    <i class="fa-solid fa-file-csv"></i> {{ __('messages.download_csv') }}
                </a>
            </div>
            <a href="{{ route('product.index') }}" class="btn btn-outline-light">{{ __('messages.back_to_catalog') }}</a>
            <a href="{{ route('order.index') }}" class="btn btn-outline-light">{{ __('messages.view_my_orders') }}</a>
        </div>
    </div>
</div>
@endsection
