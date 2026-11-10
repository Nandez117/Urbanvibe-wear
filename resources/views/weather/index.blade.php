{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="weather-page-container">
    <div class="weather-hero-card es-c1d199b6">
        <div class="weather-city-selector-bar admin-mb-4">
            <span class="lbl-city">{{ __('messages.weather_select_city') }}:</span>
            <div class="city-pills es-85f50244 admin-mt-4">
                @foreach ($viewData['cities'] as $key => $cityInfo)
                    <a href="{{ route('weather.index', ['city' => $key]) }}"
                       class="btn btn-sm {{ $viewData['selectedCity'] === $key ? 'btn-primary' : 'btn-secondary' }}">
                        {{ $cityInfo['name'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="weather-main-display es-47118b4a">
            <div class="weather-icon-badge">
                <i class="fa-solid {{ $viewData['weather']['icon'] }} es-35c98830" style="font-size: 3.5rem;"></i>
            </div>
            <div class="weather-numbers">
                <h1 class="weather-temp" style="font-size: 3.2rem; margin: 0;">{{ $viewData['weather']['temperature'] }}°C</h1>
                <p class="weather-condition" style="font-size: 1.2rem; color: var(--text-secondary); margin: 0.25rem 0;">
                    {{ __($viewData['weather']['condition']) }}
                </p>
                <small>{{ __('messages.weather_feels_like') }}: {{ $viewData['weather']['apparent_temperature'] }}°C</small>
            </div>
            <div class="weather-metrics es-9f13cd59">
                <div>
                    <i class="fa-solid fa-droplet"></i>
                    <strong>{{ __('messages.weather_humidity') }}:</strong> {{ $viewData['weather']['humidity'] }}%
                </div>
                <div>
                    <i class="fa-solid fa-wind"></i>
                    <strong>{{ __('messages.weather_wind') }}:</strong> {{ $viewData['weather']['wind_speed'] }} km/h
                </div>
                <div>
                    <i class="fa-solid fa-location-dot"></i>
                    <strong>{{ __('messages.weather_location') }}:</strong> {{ $viewData['weather']['city_name'] }}
                </div>
            </div>
        </div>

        <div class="weather-recommendation-box alert alert-success admin-mt-4">
            <h4 style="margin: 0 0 0.5rem 0;">
                <i class="fa-solid fa-vest-patches"></i>
                {{ __('messages.weather_recommendation_title') }}: {{ __($viewData['weather']['recommendation']['tag']) }}
            </h4>
            <p style="margin: 0;">
                {{ __($viewData['weather']['recommendation']['description']) }}
            </p>
        </div>
    </div>

    <div class="title-section admin-mt-4">
        <h2>{{ __('messages.weather_recommended_products') }}</h2>
    </div>

    <div class="product-grid">
        @foreach ($viewData['products'] as $product)
            <div class="product-card">
                <a href="{{ route('product.show', ['id' => $product->getId()]) }}" class="es-9ef793ad">
                    <div class="product-badge es-ee238a7d">
                        <span>{{ $product->getCategory()->getTranslatedName() }}</span>
                        <span class="es-58e8f199">
                            <i class="fa-solid fa-shirt"></i> {{ __('messages.weather_recommended_tag') }}
                        </span>
                    </div>

                    <div class="product-image-container">
                        <x-product-image
                            :src="$product->getImage() ? asset('storage/' . $product->getImage()) : null"
                            :alt="$product->getName()"
                            :category="$product->getCategory()->getName()"
                        />
                    </div>

                    <div class="product-details">
                        <div class="product-category">{{ $product->getCategory()->getTranslatedName() }}</div>
                        <h3 class="product-title">{{ $product->getName() }}</h3>
                        <div class="product-price">${{ number_format($product->getPrice(), 2) }} USD</div>
                    </div>
                </a>

                <div class="product-card-actions">
                    <form action="{{ route('cart.add', ['id' => $product->getId()]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-buy">
                            {{ __('messages.btn_add_cart') }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
