{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-ab6bc014">
    <div class="es-3cc856c9">
        <h2 class="es-6b5830b5">{{ __('messages.btn_edit') }}</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.update') }}">
            @csrf
            @method('PUT')
            
            <div class="profile-field">
                <label class="profile-label" for="name">{{ __('messages.lbl_name') }}</label>
                <input class="profile-input" id="name" type="text" name="name" value="{{ old('name', $viewData['user']->getName()) }}" required>
            </div>

            <div class="profile-field">
                <label class="profile-label" for="email">{{ __('messages.lbl_email') }}</label>
                <input class="profile-input" id="email" type="email" value="{{ $viewData['user']->getEmail() }}" disabled>
            </div>

            <div class="profile-field">
                <label class="profile-label" for="phone">{{ __('messages.lbl_phone') }}</label>
                <input class="profile-input" id="phone" type="tel" name="phone" value="{{ old('phone', $viewData['user']->getPhone()) }}">
            </div>

            <div class="profile-field profile-field--last">
                <label class="profile-label" for="address">{{ __('messages.lbl_address') }}</label>
                <input class="profile-input" id="address" type="text" name="address" value="{{ old('address', $viewData['user']->getAddress()) }}">
            </div>

            <div class="profile-actions">
                <button type="submit" class="btn">{{ __('messages.btn_save') }}</button>
                <a href="{{ route('user.profile') }}" class="btn btn-cancel">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
