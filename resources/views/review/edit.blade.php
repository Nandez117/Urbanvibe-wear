{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem;">
    <h2>{{ __('messages.edit_review') }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.update', ['id' => $viewData['review']->getId()]) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="user_id">{{ __('messages.user_label') }}</label>
            <select id="user_id" name="user_id" required>
                @foreach ($viewData['users'] as $user)
                    <option value="{{ $user->getId() }}" {{ old('user_id', $viewData['review']->getUserId()) == $user->getId() ? 'selected' : '' }}>{{ $user->getName() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="product_id">{{ __('messages.product_label') }}</label>
            <select id="product_id" name="product_id" required>
                @foreach ($viewData['products'] as $product)
                    <option value="{{ $product->getId() }}" {{ old('product_id', $viewData['review']->getProductId()) == $product->getId() ? 'selected' : '' }}>{{ $product->getName() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="rating">{{ __('messages.rating_label') }}</label>
            <input id="rating" type="number" name="rating" min="1" max="5" value="{{ old('rating', $viewData['review']->getRating()) }}" required>
        </div>
        <div>
            <label for="comment">{{ __('messages.comment_label') }}</label>
            <textarea id="comment" name="comment">{{ old('comment', $viewData['review']->getComment()) }}</textarea>
        </div>
        <button type="submit" class="btn">{{ __('messages.update_review') }}</button>
        <a href="{{ route('reviews.index') }}" class="btn">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
