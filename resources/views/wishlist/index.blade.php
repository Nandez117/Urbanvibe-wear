{{-- Autor: Juan Manuel Hernandez Martelo --}}
@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<div class="container py-5" style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="text-white m-0">{{ $viewData['title'] }}</h2>
        @if(count($viewData['wishlists']) > 0)
            <form action="{{ route('wishlist.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="background: #3ddc84; color: #1a1a1a; font-weight: bold; padding: 0.75rem 1.5rem; font-size: 1.1rem; border-radius: 8px;">
                    <i class="fa-solid fa-credit-card"></i> Proceder al Pago
                </button>
            </form>
        @endif
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error" style="background: var(--danger); color: white; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">{{ session('error') }}</div>
    @endif

    @if(count($viewData['wishlists']) > 0)
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($viewData['wishlists'] as $wishlist)
            <div style="display: flex; background: var(--surface); border: 1px solid var(--border-subtle); border-radius: 12px; overflow: hidden; height: 180px;">
                <div style="width: 180px; background: var(--surface-elevated); display: flex; align-items: center; justify-content: center;">
                    @if($wishlist->getProduct()->getImage())
                        <img src="{{ asset('storage/' . $wishlist->getProduct()->getImage()) }}" alt="{{ $wishlist->getProduct()->getName() }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-shirt" style="font-size: 3rem; color: var(--border-subtle);"></i>
                    @endif
                </div>
                
                <div style="flex: 1; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--accent); text-transform: uppercase; font-weight: bold; margin-bottom: 0.25rem;">
                            {{ $wishlist->getProduct()->getCategory()->getName() }}
                        </div>
                        <h4 style="font-size: 1.2rem; margin: 0 0 0.5rem 0; color: var(--text-primary);">
                            {{ $wishlist->getProduct()->getName() }}
                        </h4>
                        <div style="font-size: 1.25rem; font-weight: bold; color: var(--text-primary);">
                            ${{ number_format($wishlist->getProduct()->getPrice(), 2) }}
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ route('products.show', ['id' => $wishlist->getProduct()->getId()]) }}" class="btn" style="flex: 1; text-align: center;">{{ __('messages.btn_details') }}</a>
                        <form action="{{ route('wishlist.destroy', ['id' => $wishlist->getId()]) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="width: 100%; background: transparent; border: 1px solid var(--danger); color: var(--danger);">{{ __('messages.btn_delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div style="padding: 3rem; text-align: center; color: var(--text-secondary); border: 1px dashed var(--border-subtle); border-radius: 12px;">
            <i class="fa-regular fa-heart" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <p>{{ __('messages.wishlist_empty') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light" style="margin-top: 1rem;">{{ __('messages.nav_catalog') }}</a>
        </div>
    @endif
</div>
@endsection