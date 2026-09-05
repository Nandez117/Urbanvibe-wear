@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem;">
    <a href="{{ route('products.index') }}" style="color: var(--text-secondary); text-decoration: none; margin-bottom: 2rem; display: inline-block;">
        <i class="fa-solid fa-arrow-left"></i> Volver al catálogo
    </a>

    <div style="display: flex; gap: 3rem; flex-wrap: wrap;">
        <!-- Image Section -->
        <div style="flex: 1; min-width: 300px; aspect-ratio: 3/4; background: var(--surface-elevated); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 5rem; color: var(--border-subtle); border: 1px solid var(--border-subtle);">
            <i class="fa-solid fa-shirt"></i>
        </div>

        <!-- Details Section -->
        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column;">
            <div style="color: var(--accent); font-weight: bold; margin-bottom: 0.5rem; text-transform: uppercase;">
                {{ $viewData['product']->getCategory()->getName() }}
            </div>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--text-primary);">
                {{ $viewData['product']->getName() }}
            </h1>
            <div style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem; color: var(--text-primary);">
                ${{ number_format($viewData['product']->getPrice(), 2) }} USD
            </div>

            <p style="color: var(--text-secondary); line-height: 1.6; margin-bottom: 2rem;">
                {{ $viewData['product']->getDescription() }}
            </p>

            <div style="margin-bottom: 2rem; padding: 1rem; background: var(--surface-elevated); border-radius: 8px; border: 1px solid var(--border-subtle);">
                <div style="margin-bottom: 0.5rem;"><strong>Disponibilidad:</strong> 
                    <span style="color: {{ $viewData['product']->getStock() > 0 ? '#3ddc84' : '#ff5470' }}">
                        {{ $viewData['product']->getStock() > 0 ? $viewData['product']->getStock() . ' en stock' : 'Agotado' }}
                    </span>
                </div>
                @if($viewData['product']->getSize())
                    <div style="margin-bottom: 0.5rem;"><strong>Talla:</strong> {{ $viewData['product']->getSize() }}</div>
                @endif
                @if($viewData['product']->getMaterial())
                    <div style="margin-bottom: 0.5rem;"><strong>Material:</strong> {{ $viewData['product']->getMaterial() }}</div>
                @endif
                @if($viewData['product']->getColor())
                    <div><strong>Color:</strong> {{ $viewData['product']->getColor() }}</div>
                @endif
            </div>

            @if ($viewData['product']->getStock() > 0)
                <form action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $viewData['product']->getStock() }}" class="qty-input" style="width: 80px; text-align: center; font-size: 1.2rem; padding: 0.5rem; border-radius: 6px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);">
                        <button type="submit" class="btn-buy" style="flex: 1; font-size: 1.2rem; padding: 1rem;">
                            <i class="fa-solid fa-cart-plus"></i> Añadir al carrito
                        </button>
                    </div>
                </form>
            @else
                <button class="btn-buy" style="background: var(--surface-input); color: var(--text-secondary); cursor: not-allowed; padding: 1rem; font-size: 1.2rem; margin-top: auto;" disabled>
                    Agotado
                </button>
            @endif
        </div>
    </div>
</div>
@endsection