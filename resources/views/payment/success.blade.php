@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<div class="container py-5 text-center">
    <div class="es-f8414db6">
        <i class="fa-solid fa-circle-check text-success es-75c37f04"></i>
        <h2 class="text-white mb-3">{{ __('messages.payment_successful') }}</h2>
        <p class="text-secondary mb-4">{{ __('messages.your_order') }} <strong>{{ $viewData['order']->getOrderNumber() }}</strong> {{ __('messages.processed_successfully') }}</p>
        
        <div class="d-grid gap-3 es-c561bdf0">
            <a href="{{ route('orders.invoice', ['id' => $viewData['order']->getId()]) }}" class="btn" style="background: #ef4444; color: white; padding: 1rem; font-weight: bold; font-size: 1.1rem; border-radius: 8px;">
                <i class="fa-solid fa-file-pdf"></i> {{ __('messages.download_invoice') }}
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light">{{ __('messages.back_to_catalog') }}</a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-light">{{ __('messages.view_my_orders') }}</a>
        </div>
    </div>
</div>
@endsection