{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="content-card content-card--lg">
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

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.product.update', ['id' => $viewData['product']->getId()]) }}" class="admin-form-container">
        @csrf
        @method('PUT')
        
        <div class="form-grid-2">
            <div>
                <label class="admin-form-label" for="name">{{ __('messages.lbl_name') }} *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $viewData['product']->getName()) }}" required class="admin-form-input">
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="admin-form-label" for="category_id">{{ __('messages.lbl_category') }} *</label>
                <select id="category_id" name="category_id" required class="admin-form-input">
                    @foreach ($viewData['categories'] as $category)
                        <option value="{{ $category->getId() }}" {{ (old('category_id') ?? $viewData['product']->getCategoryId()) == $category->getId() ? 'selected' : '' }}>
                            {{ $category->getTranslatedName() }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div>
            <label class="admin-form-label" for="description">{{ __('messages.lbl_description') }} *</label>
            <textarea id="description" name="description" rows="3" required class="admin-form-input">{{ old('description', $viewData['product']->getDescription()) }}</textarea>
            @error('description')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="admin-grid-3">
            <div>
                <label class="admin-form-label" for="price">{{ __('messages.lbl_price') }} *</label>
                <input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $viewData['product']->getPrice()) }}" required class="admin-form-input">
                @error('price')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="admin-form-label" for="discount">{{ __('messages.lbl_discount') }}</label>
                <input id="discount" type="number" step="0.01" min="0" max="100" name="discount" value="{{ old('discount', $viewData['product']->getDiscount()) }}" class="admin-form-input">
                @error('discount')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="admin-form-label" for="stock">{{ __('messages.lbl_stock') }} *</label>
                <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $viewData['product']->getStock()) }}" required class="admin-form-input">
                @error('stock')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="admin-grid-3">
            <div>
                <label class="admin-form-label" for="size">{{ __('messages.lbl_size') }}</label>
                <input id="size" type="text" name="size" value="{{ old('size', $viewData['product']->getSize()) }}" placeholder="{{ __('messages.size_placeholder') }}" class="admin-form-input">
                @error('size')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="admin-form-label" for="color">{{ __('messages.lbl_color') }}</label>
                <input id="color" type="text" name="color" value="{{ old('color', $viewData['product']->getColor()) }}" class="admin-form-input">
                @error('color')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="admin-form-label" for="material">{{ __('messages.lbl_material') }}</label>
                <input id="material" type="text" name="material" value="{{ old('material', $viewData['product']->getMaterial()) }}" class="admin-form-input">
                @error('material')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="admin-mt-4">
            <label class="admin-form-label" for="image">{{ __('messages.lbl_product_image') }}</label>
            <input id="image" type="file" name="image" accept="image/*" class="admin-form-input">
            @error('image')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="admin-action-bar">
            <button type="submit" class="btn">{{ __('messages.btn_update_product') }}</button>
            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
