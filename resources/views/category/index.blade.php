@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Gestión de Categorías</h2>
</div>

<div style="display: flex; gap: 2rem; align-items: flex-start;">
    <!-- Formulario para crear -->
    <div style="flex: 1; background-color: var(--white); padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
        <h3 style="margin-bottom: 1rem;">Nueva Categoría</h3>
        
        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.store') }}" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Nombre de la Categoría</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej. Tenis" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            <button type="submit" class="btn">Crear Categoría</button>
        </form>
    </div>

    <!-- Tabla -->
    <div style="flex: 2; margin-top: 0;" class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['categories'] as $category)
                <tr>
                    <td>{{ $category->getId() }}</td>
                    <td>{{ $category->getName() }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('categories.edit', ['id' => $category->getId()]) }}" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Editar</a>
                            
                            <form action="{{ route('categories.destroy', ['id' => $category->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem; background-color: #ef4444;">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if(count($viewData['categories']) === 0)
            <div style="padding: 2rem; text-align: center; color: var(--text-gray);">
                No hay categorías registradas en el sistema.
            </div>
        @endif
    </div>
</div>
@endsection