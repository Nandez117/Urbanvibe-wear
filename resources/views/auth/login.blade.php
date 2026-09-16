
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h2>{{ __('messages.login') }}</h2>

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
                <label for="email">{{ __('messages.email_long') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="auth-field">
                <label for="password">{{ __('messages.lbl_password') }}</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-block">{{ __('messages.login') }}</button>
        </form>

        <div class="auth-switch">
            {{ __('messages.no_account') }} <a href="{{ route('register.index') }}">{{ __('messages.register') }}</a>
        </div>
    </div>
</div>
@endsection