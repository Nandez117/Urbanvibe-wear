{{-- Autor: Juan Manuel Hernandez Martelo --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem;">
    <a href="{{ route('products.index') }}" style="color: var(--text-secondary); text-decoration: none; margin-bottom: 2rem; display: inline-block;">
        <i class="fa-solid fa-arrow-left"></i> Volver al catálogo
    </a>

    <div style="display: flex; gap: 3rem; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px; aspect-ratio: 3/4; background: var(--surface-elevated); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 5rem; color: var(--border-subtle); border: 1px solid var(--border-subtle); overflow: hidden;">
            @if($viewData['product']->getImage())
                <img src="{{ asset('storage/' . $viewData['product']->getImage()) }}" alt="{{ $viewData['product']->getName() }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="fa-solid fa-shirt"></i>
            @endif
        </div>

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
    {{-- Reviews Section --}}
    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--border-subtle);">
        <h2 style="font-size: 1.8rem; margin-bottom: 1.5rem; color: var(--text-primary);">{{ __('messages.user_reviews') }}</h2>
        
        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            {{-- Review List --}}
            <div style="flex: 2; min-width: 300px;">
                @if(count($viewData['product']->getReviews()) > 0)
                    @foreach($viewData['product']->getReviews() as $review)
                        <div style="background: var(--surface-elevated); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid var(--border-subtle);">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <strong>{{ $review->getUser()->getName() }}</strong>
                                <span style="color: #fbbf24;"><i class="fa-solid fa-star"></i> {{ $review->getRating() }}/5</span>
                            </div>
                            <p style="color: var(--text-secondary); margin: 0;">{{ $review->getComment() }}</p>
                            <small style="color: var(--text-gray); display: block; margin-top: 0.5rem;">{{ $review->getCreatedAt() }}</small>
                        </div>
                    @endforeach
                @else
                    <p style="color: var(--text-secondary);">{{ __('messages.no_reviews_yet') }}</p>
                @endif
            </div>

            {{-- Review Form --}}
            <div style="flex: 1; min-width: 300px;">
                @auth
                    <div style="background: var(--surface-elevated); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-subtle);">
                        <h3 style="margin-bottom: 1rem;">{{ __('messages.leave_review') }}</h3>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="from_product" value="1">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->getId() }}">
                            <input type="hidden" name="product_id" value="{{ $viewData['product']->getId() }}">
                            
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem;">{{ __('messages.rating_1_5') }}:</label>
                                <input type="number" name="rating" min="1" max="5" value="5" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);">
                            </div>
                            
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem;">{{ __('messages.comment') }}:</label>
                                <textarea name="comment" rows="3" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-subtle); background: var(--surface-input); color: var(--text-primary);"></textarea>
                            </div>
                            
                            <button type="submit" class="btn-buy" style="width: 100%; padding: 0.8rem; font-size: 1rem;">{{ __('messages.publish_review') }}</button>
                        </form>
                    </div>
                @else
                    <div style="background: var(--surface-elevated); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-subtle); text-align: center;">
                        <p style="margin-bottom: 1rem; color: var(--text-secondary);">{{ __('messages.must_login_review') }}</p>
                        <a href="{{ route('login') }}" class="btn-buy" style="display: inline-block; padding: 0.5rem 1rem; text-decoration: none;">{{ __('messages.login_btn') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection