@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="catalog-layout">
    <!-- Sidebar Filters -->
    <aside class="catalog-sidebar">
        <h3>Filtros</h3>
        
        <div class="sidebar-section">
            <h4>Categoría</h4>
            <label class="sidebar-checkbox">
                <input type="checkbox" checked> Toda la Ropa
            </label>
            <label class="sidebar-checkbox">
                <input type="checkbox"> Camisetas
            </label>
            <label class="sidebar-checkbox">
                <input type="checkbox"> Pantalones
            </label>
            <label class="sidebar-checkbox">
                <input type="checkbox"> Accesorios
            </label>
        </div>

        <div class="sidebar-section">
            <h4>Precio (USD)</h4>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <input type="number" placeholder="Min" class="qty-input" style="width: 100%;">
                <span>-</span>
                <input type="number" placeholder="Max" class="qty-input" style="width: 100%;">
            </div>
        </div>
        
        <div class="sidebar-section">
            <h4>Tallas</h4>
            <label class="sidebar-checkbox">
                <input type="checkbox"> S
            </label>
            <label class="sidebar-checkbox">
                <input type="checkbox"> M
            </label>
            <label class="sidebar-checkbox">
                <input type="checkbox"> L
            </label>
            <label class="sidebar-checkbox">
                <input type="checkbox"> XL
            </label>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="catalog-content">
        <div class="catalog-topbar">
            <div>
                <strong>Resultados encontrados:</strong> {{ count($viewData['products']) }}
            </div>
            @if(Auth::check() && Auth::user()->getRole() === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-sm">Registrar Nuevo Producto</a>
            @else
                <div style="color: var(--text-secondary); font-size: 0.9rem;">
                    <i class="fa-solid fa-arrow-down-a-z"></i> Ordenar por: Relevancia
                </div>
            @endif
        </div>

        <div class="product-grid">
            @foreach ($viewData['products'] as $product)
                <div class="product-card">
                    <div class="product-badge">
                        {{ $product->getStock() > 0 ? 'EN STOCK' : 'AGOTADO' }}
                    </div>
                    
                    <div class="product-image-container">
                        <i class="fa-solid fa-shirt product-image-placeholder"></i>
                    </div>

                    <div class="product-details">
                        <div class="product-category">{{ $product->getCategory()->getName() }}</div>
                        <h3 class="product-title">{{ $product->getName() }}</h3>
                        <div class="product-price">${{ number_format($product->getPrice(), 2) }} USD</div>
                        
                        @if ($product->getStock() > 0)
                            <form action="{{ route('cart.add', ['id' => $product->getId()]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-buy">
                                    Añadir al carrito
                                </button>
                            </form>
                        @else
                            <button class="btn-buy" style="background: var(--surface-input); color: var(--text-secondary); cursor: not-allowed;" disabled>
                                Agotado
                            </button>
                        @endif

                        @if(Auth::check() && Auth::user()->getRole() === 'admin')
                            <div class="admin-actions">
                                <a href="{{ route('products.edit', ['id' => $product->getId()]) }}" class="btn btn-sm btn-admin">Editar</a>
                                <form action="{{ route('products.destroy', ['id' => $product->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-admin">Borrar</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        @if(count($viewData['products']) === 0)
            <div style="padding: 3rem; text-align: center; color: var(--text-secondary); border: 1px dashed var(--border-subtle); border-radius: 12px;">
                <i class="fa-solid fa-box-open" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p>No hay productos registrados en el catálogo.</p>
            </div>
        @endif
    </main>
</div>
@endsection