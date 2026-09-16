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
        <a href="{{ route('products.index') }}" class="btn" class="hero-btn-primary">{{ __('messages.nav_catalog') }}</a>
        @auth
            @if (Auth::user()->getRole() === 'admin')
                <a href="{{ route('users.index') }}" class="btn" class="hero-btn-outline">{{ __('messages.manage_users') }}</a>
            @endif
        @endauth
    </div>
</div>

<div class="features-container">
    <div>
        <i class="fa-solid fa-shield-halved" class="feature-icon"></i>
        <h3 class="feature-title">{{ __('messages.secure_payments') }}</h3>
        <p>{{ __('messages.secure_payments_desc') }}</p>
    </div>
    <div>
        <i class="fa-solid fa-rotate-left" class="feature-icon"></i>
        <h3 class="feature-title">{{ __('messages.returns') }}</h3>
        <p>{{ __('messages.returns_desc') }}</p>
    </div>
</div>
@endsection