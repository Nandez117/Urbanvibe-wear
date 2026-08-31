@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 600px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
    <h2 style="margin-bottom: 1.5rem;">Editar Categoría: {{ $viewData['category']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 1.5rem;">
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
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Nombre de la Categoría</label>
            <input type="text" name="name" value="{{ old('name', $viewData['category']->getName()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>

        <div style="margin-top: 1rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('categories.index') }}" class="btn" style="background-color: #6b7280;">Cancelar</a>
        </div>
    </form>
</div>
@endsection