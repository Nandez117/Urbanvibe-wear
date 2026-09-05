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
                <label for="name">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="auth-field">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="auth-field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="auth-field">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <div class="auth-field">
                <label for="phone">Teléfono</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="auth-field">
                <label for="address">Dirección</label>
                <input id="address" type="text" name="address" value="{{ old('address') }}">
            </div>
            <button type="submit" class="btn btn-block">Crear cuenta</button>
        </form>

        <div class="auth-switch">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </div>
    </div>
</div>
@endsection