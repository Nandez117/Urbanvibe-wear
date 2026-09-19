{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<div class="container py-5 es-12a642d2">
    <div class="es-9fd65ce1">
        <h2 class="text-white m-0">{{ $viewData['title'] }}</h2>
        @if(count($viewData['wishlists']) > 0)
            <form action="{{ route('wishlist.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn es-1cf6a8d6">
                    <i class="fa-solid fa-credit-card"></i> {{ __('messages.btn_checkout') }}
                </button>
            </form>
        @endif
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error es-98f161c7">{{ session('error') }}</div>
    @endif

    @if(count($viewData['wishlists']) > 0)
        <div class="es-f48bc238">
            @foreach($viewData['wishlists'] as $wishlist)
            <div class="es-5dbd8ed5">
                <div class="es-a58ddb0b">
                    @if($wishlist->getProduct()->getImage())
                        <img src="{{ asset('storage/' . $wishlist->getProduct()->getImage()) }}" alt="{{ $wishlist->getProduct()->getName() }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-shirt es-079c0adc"></i>
                    @endif
                </div>
                
                <div class="es-d2391ef8">
                    <div>
                        <div class="es-b82d2c74">
                            {{ $wishlist->getProduct()->getCategory()->getName() }}
                        </div>
                        <h4 class="es-e69e65b6">
                            {{ $wishlist->getProduct()->getName() }}
                        </h4>
                        <div class="es-59442942">
                            ${{ number_format($wishlist->getProduct()->getPrice(), 2) }}
                        </div>
                    </div>
                    
                    <div class="es-0ba2053e">
                        <a href="{{ route('products.show', ['id' => $wishlist->getProduct()->getId()]) }}" class="btn" style="flex: 1; text-align: center;">{{ __('messages.btn_details') }}</a>
                        <form action="{{ route('wishlist.destroy', ['id' => $wishlist->getId()]) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn es-a03e6c58">{{ __('messages.btn_delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="es-c1d199b6">
            <i class="fa-regular fa-heart es-9aa1019a"></i>
            <p>{{ __('messages.wishlist_empty') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light es-988c5fa7">{{ __('messages.nav_catalog') }}</a>
        </div>
    @endif
</div>
@endsection