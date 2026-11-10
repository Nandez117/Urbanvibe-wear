{{--  Yan Frank Ríos López  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="partner-header-section empty-state--dashed">
    <span class="role-badge-client badge-count">
        <i class="fa-solid fa-handshake"></i> {{ __('messages.partner_badge') }}
    </span>
    <h1 class="welcome-title content-card--lg">{{ __('messages.partner_store_title') }}</h1>
    <p class="welcome-subtitle">
        {{ __('messages.partner_source_label') }}: <strong>{{ $viewData['partnerSource'] }}</strong>
    </p>

    @if($viewData['isFallback'])
        <div class="alert alert-info form-grid-2">
            <i class="fa-solid fa-circle-info"></i> {{ __('messages.partner_demo_mode_notice') }}
        </div>
    @endif
</div>

<div class="product-grid">
    @forelse ($viewData['partnerProducts'] as $product)
        <div class="product-card">
            <a href="{{ route('partner.show', ['id' => $product['id']]) }}" class="form-input-full">
                <div class="product-badge card-badge-row">
                    <span>
                        <i class="fa-solid fa-shop"></i> {{ \App\Models\Category::translateName($product['category']) }}
                    </span>
                    @if($product['rating'])
                        <span class="badge-rating">
                            <i class="fa-solid fa-star"></i> {{ $product['rating'] }}
                        </span>
                    @endif
                </div>

                <div class="product-image-container">
                    <x-product-image
                        :src="$product['image'] ?? null"
                        :alt="$product['name']"
                        :category="$product['category']"
                    />
                </div>

                <div class="product-details">
                    <div class="product-category">
                        {{ \App\Models\Category::translateName($product['category']) }}
                        @if(!empty($product['brand']))
                            <span class="badge bg-secondary ms-1">{{ $product['brand'] }}</span>
                        @endif
                    </div>
                    <h3 class="product-title">{{ $product['name'] }}</h3>
                    <p class="product-description">{{ Str::limit($product['description'], 85) }}</p>
                    <div class="product-price">
                        ${{ number_format($product['final_price'], 2) }} USD
                        @if($product['discount'] > 0)
                            <span class="discount-badge">-{{ $product['discount'] }}%</span>
                        @endif
                    </div>
                </div>
            </a>

            <div class="product-card-actions">
                <a href="{{ route('partner.show', ['id' => $product['id']]) }}" class="btn btn-secondary btn-outline">
                    <i class="fa-solid fa-eye"></i> {{ __('messages.btn_details') }}
                </a>
                <form action="{{ route('partner.cart.add', ['id' => $product['id']]) }}" method="POST" class="btn-outline">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-buy btn-full">
                        <i class="fa-solid fa-cart-shopping"></i> {{ __('messages.btn_add_cart') }}
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state--dashed">
            <p>{{ __('messages.partner_no_products') }}</p>
        </div>
    @endforelse
</div>
@endsection
