{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="content-card">
    <h2>{{ __('messages.register_review') }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('review.store') }}">
        @csrf
        <div class="form-field">
            <label for="product_id">{{ __('messages.product_label') }}</label>
            <select id="product_id" name="product_id" required>
                <option value="">{{ __('messages.select_product') }}</option>
                @foreach ($viewData['products'] as $product)
                    <option value="{{ $product->getId() }}" {{ old('product_id') == $product->getId() ? 'selected' : '' }}>{{ $product->getName() }}</option>
                @endforeach
            </select>
            @error('product_id')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-field">
            <label for="rating">{{ __('messages.rating_label') }}</label>
            <input id="rating" type="number" name="rating" min="1" max="5" value="{{ old('rating') }}" required>
            @error('rating')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-field">
            <label for="comment">{{ __('messages.comment_label') }}</label>
            <textarea id="comment" name="comment" rows="4">{{ old('comment') }}</textarea>
            @error('comment')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn">{{ __('messages.register_review') }}</button>
            <a href="{{ route('review.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
