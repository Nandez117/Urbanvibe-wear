@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h2>Iniciar sesión</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="auth-field">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="auth-field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-block">Iniciar sesión</button>
        </form>

        <div class="auth-switch">
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a>
        </div>
    </div>
</div>
@endsection