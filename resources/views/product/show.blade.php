{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-17bb80f6">
    <a href="{{ route('products.index') }}" class="es-a451d7c8">
        <i class="fa-solid fa-arrow-left"></i> {{ __('messages.back_to_catalog') }}
    </a>

    <div class="es-e9152490">
        <div class="es-1342032c">
            @if($viewData['product']->getImage())
                <img src="{{ asset('storage/' . $viewData['product']->getImage()) }}" alt="{{ $viewData['product']->getName() }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="fa-solid fa-shirt"></i>
            @endif
        </div>

        <div class="es-d004dec4">
            <div class="es-0d330c11">
                {{ $viewData['product']->getCategory()->getName() }}
            </div>
            <h1 class="es-52803023">
                {{ $viewData['product']->getName() }}
            </h1>
            <div class="es-556b5ff1">
                ${{ number_format($viewData['product']->getPrice(), 2) }} USD
            </div>

            <p class="es-26085060">
                {{ $viewData['product']->getDescription() }}
            </p>

            <div class="es-3ff6b0f7">
                <div class="es-ac79cce7"><strong>{{ __('messages.availability') }}</strong> 
                    <span class="es-05ebbaa2">
                        {{ $viewData['product']->getStock() > 0 ? $viewData['product']->getStock() . ' en stock' : __('messages.out_of_stock') }}
                    </span>
                </div>
                @if($viewData['product']->getSize())
                    <div class="es-ac79cce7"><strong>{{ __('messages.size_label') }}</strong> {{ $viewData['product']->getSize() }}</div>
                @endif
                @if($viewData['product']->getMaterial())
                    <div class="es-ac79cce7"><strong>{{ __('messages.material_label') }}</strong> {{ $viewData['product']->getMaterial() }}</div>
                @endif
                @if($viewData['product']->getColor())
                    <div><strong>{{ __('messages.color_colon') }}</strong> {{ $viewData['product']->getColor() }}</div>
                @endif
            </div>

            @if ($viewData['product']->getStock() > 0)
                <form action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <div class="es-efd1e0b2">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $viewData['product']->getStock() }}" class="qty-input" style="width: 80px; text-align: center; font-size: 1.2rem; padding: 0.5rem; border-radius: 6px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);">
                        <button type="submit" class="btn-buy es-0aeb2496">
                            <i class="fa-solid fa-cart-plus"></i>{{ __('messages.add_to_cart') }}</button>
                    </div>
                </form>
            @else
                <button class="btn-buy es-650a5d67" disabled>{{ __('messages.out_of_stock') }}</button>
            @endif
        </div>
    </div>
</div>
    
    <div class="es-d4723293">
        <h2 class="es-bc908ede">{{ __('messages.user_reviews') }}</h2>
        
        <div class="es-cca366fa">
            
            <div class="es-4c074ded">
                @if(count($viewData['product']->getReviews()) > 0)
                    @foreach($viewData['product']->getReviews() as $review)
                        <div class="es-8b295a5f">
                            <div class="es-9156260e">
                                <strong>{{ $review->getUser()->getName() }}</strong>
                                <span class="es-c06d9c6c"><i class="fa-solid fa-star"></i> {{ $review->getRating() }}/5</span>
                            </div>
                            <p class="es-60b3f67e">{{ $review->getComment() }}</p>
                            <small class="es-39c3a8b3">{{ $review->getCreatedAt() }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="es-35042dad">{{ __('messages.no_reviews_yet') }}</p>
                @endif
            </div>

            
            <div class="es-5029516c">
                @auth
                    <div class="es-b83ac13f">
                        <h3 class="es-4986ecf7">{{ __('messages.leave_review') }}</h3>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="from_product" value="1">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->getId() }}">
                            <input type="hidden" name="product_id" value="{{ $viewData['product']->getId() }}">
                            
                            <div class="es-4986ecf7">
                                <label class="es-c1739c50">{{ __('messages.rating_1_5') }}:</label>
                                <input type="number" name="rating" min="1" max="5" value="5" required class="es-14281b58">
                            </div>
                            
                            <div class="es-4986ecf7">
                                <label class="es-c1739c50">{{ __('messages.comment') }}:</label>
                                <textarea name="comment" rows="3" required class="es-14281b58"></textarea>
                            </div>
                            
                            <button type="submit" class="btn-buy es-32aa8c52">{{ __('messages.publish_review') }}</button>
                        </form>
                    </div>
                @else
                    <div class="es-28a70790">
                        <p class="es-7ac6f7b5">{{ __('messages.must_login_review') }}</p>
                        <a href="{{ route('login.index') }}" class="btn-buy es-d3b1f590">{{ __('messages.login_btn') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection