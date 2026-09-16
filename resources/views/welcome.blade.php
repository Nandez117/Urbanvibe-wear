{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', __('messages.welcome_title'))

@section('content')
<div style="text-align: center; padding: 4rem 1rem;">
    <h1 style="font-size: 3rem; font-weight: 700; color: var(--primary-blue); margin-bottom: 1rem;">{{ __('messages.welcome_main') }}</h1>
    <p style="font-size: 1.25rem; color: var(--text-gray); max-width: 600px; margin: 0 auto 2rem auto;">
        {{ __('messages.welcome_subtitle') }}
    </p>
    
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.125rem; padding: 0.75rem 2rem;">{{ __('messages.nav_catalog') }}</a>
        @auth
            @if (Auth::user()->getRole() === 'admin')
                <a href="{{ route('users.index') }}" class="btn" style="font-size: 1.125rem; padding: 0.75rem 2rem; background-color: var(--white); color: var(--primary-blue); border: 2px solid var(--primary-blue);">{{ __('messages.manage_users') }}</a>
            @endif
        @endauth
    </div>
</div>

<div style="display: flex; justify-content: space-around; margin-top: 4rem; text-align: center; color: var(--text-gray);">
    <div>
        <i class="fa-solid fa-shield-halved" style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.125rem; color: var(--text-dark); margin-bottom: 0.5rem;">{{ __('messages.secure_payments') }}</h3>
        <p>{{ __('messages.secure_payments_desc') }}</p>
    </div>
    <div>
        <i class="fa-solid fa-rotate-left" style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.125rem; color: var(--text-dark); margin-bottom: 0.5rem;">{{ __('messages.returns') }}</h3>
        <p>{{ __('messages.returns_desc') }}</p>
    </div>
</div>
@endsection