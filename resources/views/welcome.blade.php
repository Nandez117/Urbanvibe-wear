{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', __('messages.welcome_title'))

@section('content')
<section class="hero-glitch-container">
    <div class="hero-grid-bg" aria-hidden="true"></div>
    <div class="hero-scanlines" aria-hidden="true"></div>

    <div class="hero-inner">
        <h1 class="hero-glitch-title" data-text="URBANVIBE WEAR" aria-label="Urbanvibe Wear">
            URBANVIBE WEAR
        </h1>

        <p class="hero-typewriter" id="hero-typewriter" aria-live="polite"></p>

        <div class="hero-actions">
            <a href="{{ route('product.index') }}" class="btn hero-btn-primary">
                <i class="fa-solid fa-shirt" aria-hidden="true"></i> {{ __('messages.nav_catalog') }}
            </a>
            <a href="{{ route('weather.index') }}" class="btn hero-btn-outline">
                <i class="fa-solid fa-cloud-sun" aria-hidden="true"></i> {{ __('messages.nav_weather') }}
            </a>
            <a href="{{ route('partner.index') }}" class="btn hero-btn-outline">
                <i class="fa-solid fa-handshake" aria-hidden="true"></i> {{ __('messages.nav_partner') }}
            </a>
            @auth
                @if (Auth::user()->getRole() === 'admin')
                    <a href="{{ route('admin.user.index') }}" class="btn hero-btn-outline">{{ __('messages.manage_users') }}</a>
                @endif
            @endauth
        </div>
    </div>
</section>

<section class="features-container">
    <div class="feature-card">
        <i class="fa-solid fa-shield-halved feature-icon" aria-hidden="true"></i>
        <h3 class="feature-title">{{ __('messages.secure_payments') }}</h3>
        <p>{{ __('messages.secure_payments_desc') }}</p>
    </div>
    <div class="feature-card">
        <i class="fa-solid fa-cloud-sun feature-icon" aria-hidden="true"></i>
        <h3 class="feature-title">{{ __('messages.weather_outfit_title') }}</h3>
        <p>{{ __('messages.weather_outfit_desc') }}</p>
    </div>
    <div class="feature-card">
        <i class="fa-solid fa-handshake feature-icon" aria-hidden="true"></i>
        <h3 class="feature-title">{{ __('messages.partner_store_feature_title') }}</h3>
        <p>{{ __('messages.partner_store_feature_desc') }}</p>
    </div>
    <div class="feature-card">
        <i class="fa-solid fa-rotate-left feature-icon" aria-hidden="true"></i>
        <h3 class="feature-title">{{ __('messages.returns') }}</h3>
        <p>{{ __('messages.returns_desc') }}</p>
    </div>
</section>

@push('styles')
<script>
    (function () {
        var phrases = [
            '{{ __('messages.welcome_subtitle') }}',
            '{{ __('messages.ticker_shipping') }}',
            '{{ __('messages.ticker_returns') }}'
        ];
        var el = document.getElementById('hero-typewriter');
        var phraseIndex = 0;
        var charIndex = 0;
        var deleting = false;
        var TYPING_SPEED = 45;
        var DELETING_SPEED = 22;
        var PAUSE_END = 2200;
        var PAUSE_START = 400;

        function tick() {
            var current = phrases[phraseIndex];
            if (deleting) {
                charIndex--;
                el.textContent = current.slice(0, charIndex);
                if (charIndex === 0) {
                    deleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    setTimeout(tick, PAUSE_START);
                    return;
                }
                setTimeout(tick, DELETING_SPEED);
            } else {
                charIndex++;
                el.textContent = current.slice(0, charIndex);
                if (charIndex === current.length) {
                    deleting = true;
                    setTimeout(tick, PAUSE_END);
                    return;
                }
                setTimeout(tick, TYPING_SPEED);
            }
        }

        setTimeout(tick, 800);
    }());
</script>
@endpush
@endsection
