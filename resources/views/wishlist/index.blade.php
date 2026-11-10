{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<div class="container py-5 content-card--xl">
    <div class="wishlist-head">
        <h2 class="text-white m-0">{{ $viewData['title'] }}</h2>
        @if(count($viewData['wishlists']) > 0)
            <form action="{{ route('wishlist.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn wishlist-badge">
                    <i class="fa-solid fa-credit-card"></i> {{ __('messages.btn_checkout') }}
                </button>
            </form>
        @endif
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error wishlist-alert">{{ session('error') }}</div>
    @endif

    @if(count($viewData['wishlists']) > 0)
        <div class="form-stack">
            @foreach($viewData['wishlists'] as $wishlist)
            <div class="wishlist-item">
                <div class="wishlist-item-image">
                    <x-product-image
                        :src="$wishlist->getProduct()->getImage() ? asset('storage/' . $wishlist->getProduct()->getImage()) : null"
                        :alt="$wishlist->getProduct()->getName()"
                        :category="$wishlist->getProduct()->getCategory()->getName()"
                        class="img-cover"
                    />
                </div>
                
                <div class="wishlist-item-body">
                    <div>
                        <div class="wishlist-item-category">
                            {{ $wishlist->getProduct()->getCategory()->getTranslatedName() }}
                        </div>
                        <h4 class="wishlist-item-title">
                            {{ $wishlist->getProduct()->getName() }}
                        </h4>
                        <div class="wishlist-item-price">
                            ${{ number_format($wishlist->getProduct()->getPrice(), 2) }} USD
                        </div>
                    </div>
                    
                    <div class="wishlist-item-actions">
                        <a href="{{ route('product.show', ['id' => $wishlist->getProduct()->getId()]) }}" class="btn actions-split">{{ __('messages.btn_details') }}</a>
                        <form action="{{ route('wishlist.destroy', ['id' => $wishlist->getId()]) }}" method="POST" class="actions-split">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">{{ __('messages.btn_delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state--dashed">
            <i class="fa-regular fa-heart empty-state-icon"></i>
            <p>{{ __('messages.wishlist_empty') }}</p>
            <a href="{{ route('product.index') }}" class="btn btn-outline-light mt-1">{{ __('messages.nav_catalog') }}</a>
        </div>
    @endif
</div>
@endsection
