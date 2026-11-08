{{--  Yan Frank Ríos López  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="product-detail-container">
    <div class="product-detail-layout">
        <div class="product-gallery">
            <div class="main-image-container">
                @if(!empty($viewData['product']['image']))
                    <img src="{{ $viewData['product']['image'] }}" alt="{{ $viewData['product']['name'] }}" class="es-85f50244">
                @elseif(in_array(strtolower($viewData['product']['category']), ['laptops', 'celulares', 'tablets', 'consolas', 'audio', 'smartwatches']))
                    <i class="fa-solid fa-laptop product-image-placeholder"></i>
                @else
                    <i class="fa-solid fa-box-open product-image-placeholder"></i>
                @endif
            </div>
        </div>

        <div class="product-info-panel">
            <span class="role-badge-client">
                <i class="fa-solid fa-handshake"></i> {{ __('messages.partner_badge') }}
            </span>
            <div class="product-category admin-mt-4">
                {{ \App\Models\Category::translateName($viewData['product']['category']) }}
                @if(!empty($viewData['product']['brand']))
                    <span class="badge bg-secondary ms-2">{{ $viewData['product']['brand'] }}</span>
                @endif
            </div>
            <h1 class="product-title-detail">{{ $viewData['product']['name'] }}</h1>

            <div class="product-price-section">
                <div class="current-price">${{ number_format($viewData['product']['final_price'], 2) }} USD</div>
                @if($viewData['product']['discount'] > 0)
                    <div class="original-price">${{ number_format($viewData['product']['price'], 2) }}</div>
                    <span class="discount-badge">-{{ $viewData['product']['discount'] }}%</span>
                @endif
            </div>

            <div class="detail-block">
                <h4>{{ __('messages.lbl_description') }}</h4>
                <p>{{ $viewData['product']['description'] }}</p>
            </div>

            <div class="detail-block">
                <p><strong>{{ __('messages.lbl_stock') }}:</strong> {{ $viewData['product']['stock'] }}</p>
                @if($viewData['product']['rating'])
                    <p><strong>{{ __('messages.lbl_rating') }}:</strong> <i class="fa-solid fa-star es-58e8f199"></i> {{ $viewData['product']['rating'] }}/5</p>
                @endif
            </div>

            <div class="actions-row admin-mt-4">
                <a href="{{ route('partner.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('messages.btn_back_to_partner') }}
                </a>
                <form action="{{ route('partner.cart.add', ['id' => $viewData['product']['id']]) }}" method="POST" style="display: inline-flex; align-items: center; gap: 0.5rem; margin: 0;">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $viewData['product']['stock'] > 0 ? $viewData['product']['stock'] : 1 }}" class="qty-input es-199b6f0e">
                    <button type="submit" class="btn-buy">
                        <i class="fa-solid fa-cart-shopping"></i> {{ __('messages.btn_add_cart') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
