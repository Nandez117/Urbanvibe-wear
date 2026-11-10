{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="product-detail">
    <a href="{{ route('product.index') }}" class="product-back-link">
        <i class="fa-solid fa-arrow-left"></i> {{ __('messages.back_to_catalog') }}
    </a>

    <div class="product-detail-layout">
        <div class="product-detail-image">
            <x-product-image
                :src="$viewData['product']->getImage() ? asset('storage/' . $viewData['product']->getImage()) : null"
                :alt="$viewData['product']->getName()"
                :category="$viewData['product']->getCategory()->getName()"
                class="img-cover"
            />
        </div>

        <div class="product-detail-info">
            <div class="product-detail-category">
                {{ $viewData['product']->getCategory()->getTranslatedName() }}
            </div>
            <h1 class="product-detail-title">
                {{ $viewData['product']->getName() }}
            </h1>
            <div class="product-detail-price">
                ${{ number_format($viewData['product']->getPrice(), 2) }} USD
            </div>

            <p class="product-detail-desc">
                {{ $viewData['product']->getDescription() }}
            </p>

            <div class="product-specs">
                <div class="product-spec-row"><strong>{{ __('messages.availability') }}</strong> 
                    <span class="{{ $viewData['product']->getStock() > 0 ? 'stock-available' : 'stock-out' }}">
                        {{ $viewData['product']->getStock() > 0 ? $viewData['product']->getStock() . ' ' . __('messages.in_stock') : __('messages.out_of_stock') }}
                    </span>
                </div>
                @if($viewData['product']->getSize())
                    <div class="product-spec-row"><strong>{{ __('messages.size_label') }}</strong> {{ $viewData['product']->getSize() }}</div>
                @endif
                @if($viewData['product']->getMaterial())
                    <div class="product-spec-row"><strong>{{ __('messages.material_label') }}</strong> {{ $viewData['product']->getMaterial() }}</div>
                @endif
                @if($viewData['product']->getColor())
                    <div><strong>{{ __('messages.color_colon') }}</strong> {{ $viewData['product']->getColor() }}</div>
                @endif
            </div>

            @if ($viewData['product']->getStock() > 0)
                <form action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}" method="POST" class="mt-auto">
                    @csrf
                    <div class="add-to-cart-row">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $viewData['product']->getStock() }}" class="qty-input qty-input--detail">
                        <button type="submit" class="btn-buy add-to-cart-btn">
                            <i class="fa-solid fa-cart-plus"></i> {{ __('messages.add_to_cart') }}
                        </button>
                    </div>
                </form>
            @else
                <button class="btn-buy btn-buy-disabled" disabled>{{ __('messages.out_of_stock') }}</button>
            @endif

            @auth
                <form action="{{ route('wishlist.store', ['id' => $viewData['product']->getId()]) }}" method="POST" class="mt-sm">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-full">
                        <i class="fa-regular fa-heart"></i> {{ __('messages.btn_add_wishlist') }}
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>
    
<div class="reviews-section">
    <h2 class="reviews-title">{{ __('messages.user_reviews') }}</h2>
    
    <div class="reviews-layout">
        
        <div class="reviews-list">
            @if(count($viewData['product']->getReviews()) > 0)
                @foreach($viewData['product']->getReviews() as $review)
                    <div class="review-card">
                        <div class="review-card-head">
                            <strong>{{ $review->getUser()->getName() }}</strong>
                            <span class="review-rating"><i class="fa-solid fa-star"></i> {{ $review->getRating() }}/5</span>
                        </div>
                        <p class="review-comment">{{ $review->getComment() }}</p>
                        <small class="review-date">{{ $review->getCreatedAt() }}</small>
                    </div>
                @endforeach
            @else
                <p class="review-muted">{{ __('messages.no_reviews_yet') }}</p>
            @endif
        </div>

        <div class="review-form-col">
            @auth
                <div class="review-form-box">
                    <h3 class="mb-1">{{ __('messages.leave_review') }}</h3>

                    @if ($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="from_product" value="1">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->getId() }}">
                        <input type="hidden" name="product_id" value="{{ $viewData['product']->getId() }}">
                        
                        <div class="mb-1">
                            <label class="review-field-label" for="review-rating">{{ __('messages.rating_1_5') }}:</label>
                            <input id="review-rating" type="number" name="rating" min="1" max="5" value="{{ old('rating', 5) }}" required class="form-input-sm">
                            @error('rating')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-1">
                            <label class="review-field-label" for="review-comment">{{ __('messages.comment') }}:</label>
                            <textarea id="review-comment" name="comment" rows="3" required class="form-input-sm">{{ old('comment') }}</textarea>
                            @error('comment')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-buy btn-wide">{{ __('messages.publish_review') }}</button>
                    </form>
                </div>
            @else
                <div class="review-login-box">
                    <p class="review-login-text">{{ __('messages.must_login_review') }}</p>
                    <a href="{{ route('login.index') }}" class="btn-buy review-login-link">{{ __('messages.login_btn') }}</a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
