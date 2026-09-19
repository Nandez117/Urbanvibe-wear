{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="es-9bde6a43">
    <h2 class="admin-title">{{ __('messages.edit_product') }} {{ $viewData['product']->getName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="admin-mt-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('products.update', ['id' => $viewData['product']->getId()]) }}" class="admin-form-container">
        @csrf
        @method('PUT')
        
        <div class="es-85f50244">
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_name') }} *</label>
                <input type="text" name="name" value="{{ old('name', $viewData['product']->getName()) }}" required class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_category') }} *</label>
                <select name="category_id" required class="admin-form-input">
                    @foreach ($viewData['categories'] as $category)
                        <option value="{{ $category->getId() }}" {{ (old('category_id') ?? $viewData['product']->getCategoryId()) == $category->getId() ? 'selected' : '' }}>
                            {{ $category->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="admin-form-label">{{ __('messages.lbl_description') }} *</label>
            <textarea name="description" rows="3" required class="admin-form-input">{{ old('description', $viewData['product']->getDescription()) }}</textarea>
        </div>

        <div class="admin-grid-3">
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_price') }} *</label>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $viewData['product']->getPrice()) }}" required class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_discount') }}</label>
                <input type="number" step="0.01" min="0" max="100" name="discount" value="{{ old('discount', $viewData['product']->getDiscount()) }}" class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_stock') }} *</label>
                <input type="number" min="0" name="stock" value="{{ old('stock', $viewData['product']->getStock()) }}" required class="admin-form-input">
            </div>
        </div>

        <div class="admin-grid-3">
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_size') }}</label>
                <input type="text" name="size" value="{{ old('size', $viewData['product']->getSize()) }}" placeholder="{{ __('messages.size_placeholder') }}" class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_color') }}</label>
                <input type="text" name="color" value="{{ old('color', $viewData['product']->getColor()) }}" class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label">{{ __('messages.lbl_material') }}</label>
                <input type="text" name="material" value="{{ old('material', $viewData['product']->getMaterial()) }}" class="admin-form-input">
            </div>
        </div>

                <div class="admin-mt-4">
            <label class="admin-form-label">{{ __('messages.lbl_product_image') }}</label>
            <input type="file" name="image" accept="image/*" class="admin-form-input">
        </div>

        <div class="admin-action-bar">
            <button type="submit" class="btn">{{ __('messages.btn_update_product') }}</button>
            <a href="{{ route('products.index') }}" class="btn" class="btn-secondary">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
