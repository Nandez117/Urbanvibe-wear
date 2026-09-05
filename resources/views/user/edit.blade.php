@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 600px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
    <h2 style="margin-bottom: 1.5rem;">Editar Usuario: {{ $viewData['user']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', ['id' => $viewData['user']->getId()]) }}" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf
        @method('PUT')
        
        <div>
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $viewData['user']->getName()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>

        <div>
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Email</label>
            <input type="email" name="email" value="{{ old('email', $viewData['user']->getEmail()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>
        
        <div>
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Teléfono</label>
            <input type="text" name="phone" value="{{ old('phone', $viewData['user']->getPhone()) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
        </div>

        <div>
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Dirección (Domicilio)</label>
            <textarea name="address" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('address', $viewData['user']->getAddress()) }}</textarea>
        </div>
        
        <div>
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Rol</label>
            <select name="role" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="client" {{ old('role', $viewData['user']->getRole()) === 'client' ? 'selected' : '' }}>Cliente</option>
                <option value="admin" {{ old('role', $viewData['user']->getRole()) === 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <div style="margin-top: 1rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn">Actualizar Usuario</button>
            <a href="{{ route('users.index') }}" class="btn" style="background-color: #6b7280;">Cancelar</a>
        </div>
    </form>
</div>
@endsection