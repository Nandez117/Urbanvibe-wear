{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', __('messages.welcome_title'))

@section('content')
<div class="hero-container">
    <h1 class="hero-title">{{ __('messages.welcome_main') }}</h1>
    <p class="hero-subtitle">
        {{ __('messages.welcome_subtitle') }}
    </p>
    
    <div class="hero-buttons">
        <a href="{{ route('product.index') }}" class="btn hero-btn-primary">{{ __('messages.nav_catalog') }}</a>
        <a href="{{ route('weather.index') }}" class="btn hero-btn-outline"><i class="fa-solid fa-cloud-sun"></i> {{ __('messages.nav_weather') }}</a>
        <a href="{{ route('partner.index') }}" class="btn hero-btn-outline"><i class="fa-solid fa-handshake"></i> {{ __('messages.nav_partner') }}</a>
        @auth
            @if (Auth::user()->getRole() === 'admin')
                <a href="{{ route('admin.user.index') }}" class="btn hero-btn-outline">{{ __('messages.manage_users') }}</a>
            @endif
        @endauth
    </div>
</div>

<div class="features-container">
    <div>
        <i class="fa-solid fa-shield-halved feature-icon"></i>
        <h3 class="feature-title">{{ __('messages.secure_payments') }}</h3>
        <p>{{ __('messages.secure_payments_desc') }}</p>
    </div>
    <div>
        <i class="fa-solid fa-cloud-sun feature-icon"></i>
        <h3 class="feature-title">{{ __('messages.weather_outfit_title') }}</h3>
        <p>{{ __('messages.weather_outfit_desc') }}</p>
    </div>
    <div>
        <i class="fa-solid fa-handshake feature-icon"></i>
        <h3 class="feature-title">{{ __('messages.partner_store_feature_title') }}</h3>
        <p>{{ __('messages.partner_store_feature_desc') }}</p>
    </div>
    <div>
        <i class="fa-solid fa-rotate-left feature-icon"></i>
        <h3 class="feature-title">{{ __('messages.returns') }}</h3>
        <p>{{ __('messages.returns_desc') }}</p>
    </div>
</div>
@endsection
