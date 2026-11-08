{{--  Yan Frank Ríos López  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="partner-header-section es-c1d199b6">
    <span class="role-badge-client es-35c98830">
        <i class="fa-solid fa-handshake"></i> {{ __('messages.partner_badge') }}
    </span>
    <h1 class="welcome-title es-9bde6a43">{{ __('messages.partner_store_title') }}</h1>
    <p class="welcome-subtitle">
        {{ __('messages.partner_source_label') }}: <strong>{{ $viewData['partnerSource'] }}</strong>
    </p>

    @if($viewData['isFallback'])
        <div class="alert alert-info es-85f50244">
            <i class="fa-solid fa-circle-info"></i> {{ __('messages.partner_demo_mode_notice') }}
        </div>
    @endif
</div>

<div class="product-grid">
    @forelse ($viewData['partnerProducts'] as $product)
        <div class="product-card">
            <a href="{{ route('partner.show', ['id' => $product['id']]) }}" class="es-9ef793ad">
                <div class="product-badge es-ee238a7d">
                    <span>
                        <i class="fa-solid fa-shop"></i> {{ $product['category'] }}
                    </span>
                    @if($product['rating'])
                        <span class="es-58e8f199">
                            <i class="fa-solid fa-star"></i> {{ $product['rating'] }}
                        </span>
                    @endif
                </div>

                <div class="product-image-container">
                    @if(!empty($product['image']))
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="es-85f50244">
                    @elseif(in_array(strtolower($product['category']), ['laptops', 'celulares', 'tablets', 'consolas', 'audio', 'smartwatches']))
                        <i class="fa-solid fa-laptop product-image-placeholder"></i>
                    @else
                        <i class="fa-solid fa-box-open product-image-placeholder"></i>
                    @endif
                </div>

                <div class="product-details">
                    <div class="product-category">
                        {{ $product['category'] }}
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
                <a href="{{ route('partner.show', ['id' => $product['id']]) }}" class="btn btn-secondary es-9923df7b">
                    <i class="fa-solid fa-eye"></i> {{ __('messages.btn_details') }}
                </a>
                @if(!empty($product['url']))
                    <a href="{{ $product['url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary es-9923df7b">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ __('messages.btn_view_on_partner_store') }}
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="es-c1d199b6">
            <p>{{ __('messages.partner_no_products') }}</p>
        </div>
    @endforelse
</div>
@endsection
