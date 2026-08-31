@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Gestión de Clientes (Usuarios)</h2>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['users'] as $user)
            <tr>
                <td>{{ $user->getId() }}</td>
                <td>{{ $user->getName() }}</td>
                <td>{{ $user->getEmail() }}</td>
                <td>{{ $user->getPhone() ?? 'N/A' }}</td>
                <td>{{ $user->getAddress() ?? 'N/A' }}</td>
                <td>
                    <span style="padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background-color: {{ $user->getRole() === 'admin' ? '#fee2e2' : '#dbeafe' }}; color: {{ $user->getRole() === 'admin' ? '#991b1b' : '#1e40af' }};">
                        {{ ucfirst($user->getRole()) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('users.edit', ['id' => $user->getId()]) }}" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Editar</a>
                        
                        <form action="{{ route('users.destroy', ['id' => $user->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
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
    
    @if(count($viewData['users']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">
            No hay usuarios registrados en el sistema.
        </div>
    @endif
</div>
@endsection