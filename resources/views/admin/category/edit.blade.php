{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="es-b0d1bae9">
    <h2 class="es-d3297f95">Editar Categoría: {{ $viewData['category']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="es-552f38ac">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categories.update', ['id' => $viewData['category']->getId()]) }}" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf
        @method('PUT')
        
        <div>
            <label class="es-4e832e11">{{ __('messages.category_name') }}</label>
            <input type="text" name="name" value="{{ old('name', $viewData['category']->getName()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>

        <div class="es-4a9a10b0">
            <button type="submit" class="btn">{{ __('messages.btn_update') }}</button>
            <a href="{{ route('categories.index') }}" class="btn es-cfd0a5ab">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection