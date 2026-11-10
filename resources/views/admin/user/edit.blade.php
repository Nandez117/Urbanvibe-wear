{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="admin-container-box">
    <h2 class="admin-title">{{ __('messages.title_edit_user') }}: {{ $viewData['user']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="admin-mt-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.user.update', ['id' => $viewData['user']->getId()]) }}" class="admin-form-container">
        @csrf
        @method('PUT')
        
        <div>
            <label class="admin-form-label" for="name">{{ __('messages.lbl_name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name', $viewData['user']->getName()) }}" required class="admin-form-input">
            @error('name')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="admin-form-label" for="email">{{ __('messages.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email', $viewData['user']->getEmail()) }}" required class="admin-form-input">
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        
        <div>
            <label class="admin-form-label" for="phone">{{ __('messages.phone') }}</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone', $viewData['user']->getPhone()) }}" class="admin-form-input">
            @error('phone')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="admin-form-label" for="address">{{ __('messages.address_domicile') }}</label>
            <input id="address" type="text" name="address" value="{{ old('address', $viewData['user']->getAddress()) }}" class="admin-form-input">
            @error('address')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        
        <div>
            <label class="admin-form-label" for="role">{{ __('messages.role') }}</label>
            <select id="role" name="role" class="admin-form-input">
                <option value="client" {{ old('role', $viewData['user']->getRole()) === 'client' ? 'selected' : '' }}>{{ __('messages.client') }}</option>
                <option value="admin" {{ old('role', $viewData['user']->getRole()) === 'admin' ? 'selected' : '' }}>{{ __('messages.administrator') }}</option>
            </select>
            @error('role')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="admin-action-bar">
            <button type="submit" class="btn">{{ __('messages.update_user') }}</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
