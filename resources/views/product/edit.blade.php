@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
    <h2 style="margin-bottom: 1.5rem;">Editar Producto: {{ $viewData['product']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', ['id' => $viewData['product']->getId()]) }}" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $viewData['product']->getName()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Categoría *</label>
                <select name="category_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    @foreach ($viewData['categories'] as $category)
                        <option value="{{ $category->getId() }}" {{ (old('category_id') ?? $viewData['product']->getCategoryId()) == $category->getId() ? 'selected' : '' }}>
                            {{ $category->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Descripción *</label>
            <textarea name="description" rows="3" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('description', $viewData['product']->getDescription()) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Precio *</label>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $viewData['product']->getPrice()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Descuento (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="discount" value="{{ old('discount', $viewData['product']->getDiscount()) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Stock *</label>
                <input type="number" min="0" name="stock" value="{{ old('stock', $viewData['product']->getStock()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Talla</label>
                <input type="text" name="size" value="{{ old('size', $viewData['product']->getSize()) }}" placeholder="S, M, L..." style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Color</label>
                <input type="text" name="color" value="{{ old('color', $viewData['product']->getColor()) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.25rem;">Material</label>
                <input type="text" name="material" value="{{ old('material', $viewData['product']->getMaterial()) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
            </div>
        </div>

        <div style="margin-top: 1rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn">Actualizar Producto</button>
            <a href="{{ route('products.index') }}" class="btn" style="background-color: #6b7280;">Cancelar</a>
        </div>
    </form>
</div>
@endsection