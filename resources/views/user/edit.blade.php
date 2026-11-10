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
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">{{ __('messages.lbl_name') }}</label>
                <input type="text" name="name" value="{{ old('name', $viewData['user']->getName()) }}" required style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">{{ __('messages.lbl_email') }}</label>
                <input type="email" value="{{ $viewData['user']->getEmail() }}" disabled style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border-subtle); background: var(--surface-elevated); color: var(--text-secondary); cursor: not-allowed;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">{{ __('messages.lbl_phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone', $viewData['user']->getPhone()) }}" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-secondary);">{{ __('messages.lbl_address') }}</label>
                <input type="text" name="address" value="{{ old('address', $viewData['user']->getAddress()) }}" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn" style="flex: 1;">{{ __('messages.btn_save') }}</button>
                <a href="{{ route('user.profile') }}" class="btn" style="flex: 1; text-align: center; background: transparent; border: 1px solid var(--border-subtle); color: var(--text-secondary);">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
