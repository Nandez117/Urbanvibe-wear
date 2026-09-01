@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Catálogo de Productos</h2>
    <a href="{{ route('products.create') }}" class="btn">Registrar Producto</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['products'] as $product)
            <tr>
                <td>{{ $product->getId() }}</td>
                <td>{{ $product->getName() }}</td>
                <td>{{ $product->getCategory()->getName() }}</td>
                <td>${{ number_format($product->getPrice(), 2) }}</td>
                <td>
                    <span style="padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background-color: {{ $product->getStock() > 0 ? '#dcfce7' : '#fee2e2' }}; color: {{ $product->getStock() > 0 ? '#166534' : '#991b1b' }};">
                        {{ $product->getStock() }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('products.edit', ['id' => $product->getId()]) }}" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Editar</a>
                        
                        <form action="{{ route('products.destroy', ['id' => $product->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
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
    
    @if(count($viewData['products']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">
            No hay productos registrados en el catálogo.
        </div>
    @endif
</div>
@endsection