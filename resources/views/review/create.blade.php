{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-9b7d0058">
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

    <form method="POST" action="{{ route('reviews.store') }}">
        @csrf
        <div>
            <label for="user_id">{{ __('messages.user_label') }}</label>
            <select id="user_id" name="user_id" required>
                <option value="">{{ __('messages.select_user') }}</option>
                @foreach ($viewData['users'] as $user)
                    <option value="{{ $user->getId() }}" {{ old('user_id') == $user->getId() ? 'selected' : '' }}>{{ $user->getName() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="product_id">{{ __('messages.product_label') }}</label>
            <select id="product_id" name="product_id" required>
                <option value="">{{ __('messages.select_product') }}</option>
                @foreach ($viewData['products'] as $product)
                    <option value="{{ $product->getId() }}" {{ old('product_id') == $product->getId() ? 'selected' : '' }}>{{ $product->getName() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="rating">{{ __('messages.rating_label') }}</label>
            <input id="rating" type="number" name="rating" min="1" max="5" value="{{ old('rating') }}" required>
        </div>
        <div>
            <label for="comment">{{ __('messages.comment_label') }}</label>
            <textarea id="comment" name="comment">{{ old('comment') }}</textarea>
        </div>
        <button type="submit" class="btn">{{ __('messages.register_review') }}</button>
        <a href="{{ route('reviews.index') }}" class="btn">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
