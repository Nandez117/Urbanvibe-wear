{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="admin-container-box">
    <h2 class="admin-title">Editar Usuario: {{ $viewData['user']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="admin-mt-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', ['id' => $viewData['user']->getId()]) }}" class="admin-form-container">
        @csrf
        @method('PUT')
        
        <div>
            <label class="admin-form-label">{{ __('messages.lbl_name') }}</label>
            <input type="text" name="name" value="{{ old('name', $viewData['user']->getName()) }}" required class="admin-form-input">
        </div>

        <div>
            <label class="admin-form-label">{{ __('messages.email') }}</label>
            <input type="email" name="email" value="{{ old('email', $viewData['user']->getEmail()) }}" required class="admin-form-input">
        </div>
        
        <div>
            <label class="admin-form-label">{{ __('messages.phone') }}</label>
            <input type="text" name="phone" value="{{ old('phone', $viewData['user']->getPhone()) }}" class="admin-form-input">
        </div>

        <div>
            <label class="admin-form-label">{{ __('messages.address_domicile') }}</label>
            <textarea name="address" rows="3" class="admin-form-input">{{ old('address', $viewData['user']->getAddress()) }}</textarea>
        </div>
        
        <div>
            <label class="admin-form-label">{{ __('messages.role') }}</label>
            <select name="role" class="admin-form-input">
                <option value="client" {{ old('role', $viewData['user']->getRole()) === 'client' ? 'selected' : '' }}>{{ __('messages.client') }}</option>
                <option value="admin" {{ old('role', $viewData['user']->getRole()) === 'admin' ? 'selected' : '' }}>{{ __('messages.administrator') }}</option>
            </select>
        </div>

        <div class="admin-action-bar">
            <button type="submit" class="btn">{{ __('messages.update_user') }}</button>
            <a href="{{ route('users.index') }}" class="btn" class="btn-secondary">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection