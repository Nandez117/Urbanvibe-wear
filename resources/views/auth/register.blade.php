@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h2>Crear cuenta</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="auth-field">
                <label for="name">{{ __('messages.lbl_name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="auth-field">
                <label for="email">{{ __('messages.email_long') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="auth-field">
                <label for="password">{{ __('messages.lbl_password') }}</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="auth-field">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <div class="auth-field">
                <label for="phone">{{ __('messages.phone') }}</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="auth-field">
                <label for="address">{{ __('messages.address') }}</label>
                <input id="address" type="text" name="address" value="{{ old('address') }}">
            </div>
            <button type="submit" class="btn btn-block">Crear cuenta</button>
        </form>

        <div class="auth-switch">
            ¿Ya tienes cuenta? <a href="{{ route('login.index') }}">Inicia sesión</a>
        </div>
    </div>
</div>
@endsection