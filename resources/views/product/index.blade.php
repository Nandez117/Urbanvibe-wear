{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="catalog-layout">
    
        <aside class="catalog-sidebar">
        <form action="{{ route('products.index') }}" method="GET">
            <h3>{{ __('messages.filters') }}</h3>
            
            <div class="sidebar-section">
                <h4>{{ __('messages.sort_by') }}</h4>
                <select name="sort" class="form-control es-a4156c53" onchange="this.form.submit()">
                    <option value="">{{ __('messages.relevance') }}</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('messages.latest_added') }}</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('messages.price_low_high') }}</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('messages.price_high_low') }}</option>
                </select>
            </div>
            <div class="sidebar-section">
                <h4>{{ __('messages.category') }}</h4>
                @foreach($viewData['categories'] as $category)
                    <label class="sidebar-checkbox">
                        <input type="checkbox" name="category_id[]" value="{{ $category->getId() }}" 
                        {{ is_array(request('category_id')) && in_array($category->getId(), request('category_id')) ? 'checked' : '' }}> 
                        {{ $category->getName() }}
                    </label>
                @endforeach
            </div>

            <div class="sidebar-section">
                <h4>{{ __('messages.price_usd') }}</h4>
                <div class="es-afcd7ed5">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('messages.min') }}" class="qty-input es-199b6f0e">
                    <span>-</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('messages.max') }}" class="qty-input es-199b6f0e">
                </div>
            </div>
            
            <div class="sidebar-section">
                <h4>{{ __('messages.sizes') }}</h4>
                @foreach(['S', 'M', 'L', 'XL'] as $size)
                    <label class="sidebar-checkbox">
                        <input type="checkbox" name="sizes[]" value="{{ $size }}"
                        {{ is_array(request('sizes')) && in_array($size, request('sizes')) ? 'checked' : '' }}> 
                        {{ $size }}
                    </label>
                @endforeach
            </div>

            <button type="submit" class="btn es-8ec3300d">{{ __('messages.apply') }}</button>
            <a href="{{ route('products.index') }}" class="btn es-e1463324">{{ __('messages.clear') }}</a>
        </form>
    </aside>

    <main class="catalog-content">
        <div class="catalog-topbar">
            <div>
                <strong>{{ __('messages.results_found') }}</strong> {{ count($viewData['products']) }}
            </div>
            @if(Auth::check() && Auth::user()->getRole() === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-sm">{{ __('messages.register_product') }}</a>

            @endif
        </div>

        <div class="product-grid">
            @foreach ($viewData['products'] as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', ['id' => $product->getId()]) }}" style="text-decoration: none; color: inherit; display: contents;">
                        <div class="product-badge es-ee238a7d">
                            <span>
                                {{ $product->getStock() > 0 ? 'EN STOCK' : 'AGOTADO' }}
                                @if(Auth::check() && Auth::user()->getRole() === 'admin')
                                    ({{ $product->getStock() }})
                                @endif
                            </span>
                            @if(Auth::check() && Auth::user()->getRole() === 'admin' && $product->getStock() < 10)
                                <span class="es-58e8f199">{{ __('messages.low_stock') }}</span>
                            @endif
                        </div>
                        
                        <div class="product-image-container">
                            @if($product->getImage())
                                <img src="{{ asset('storage/' . $product->getImage()) }}" alt="{{ $product->getName() }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fa-solid fa-shirt product-image-placeholder"></i>
                            @endif
                        </div>

                        <div class="product-details">
                            <div class="product-category">{{ $product->getCategory()->getName() }}</div>
                            <h3 class="product-title">{{ $product->getName() }}</h3>
                            <div class="product-price">${{ number_format($product->getPrice(), 2) }} USD</div>
                    </a>
                        
                        @if ($product->getStock() > 0)
                            <form action="{{ route('cart.add', ['id' => $product->getId()]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-buy">
                                    {{ __('messages.btn_add_cart') }}
                                </button>
                            </form>
                        @else
                            <button class="btn-buy es-41baa003" disabled>{{ __('messages.out_of_stock') }}</button>
                        @endif

                        @auth
                            <form action="{{ route('wishlist.store', ['id' => $product->getId()]) }}" method="POST" style="margin-top:0.5rem;">
                                @csrf
                                <button type="submit" class="btn es-9923df7b">
                                    <i class="fa-regular fa-heart"></i> {{ __('messages.btn_add_wishlist') }}
                                </button>
                            </form>
                        @endauth

                        @if(Auth::check() && Auth::user()->getRole() === 'admin')
                            <div class="admin-actions">
                                <a href="{{ route('products.edit', ['id' => $product->getId()]) }}" class="btn btn-sm btn-admin">{{ __('messages.btn_edit') }}</a>
                                <form action="{{ route('products.destroy', ['id' => $product->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-admin">{{ __('messages.btn_delete') }}</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        @if(count($viewData['products']) === 0)
            <div class="es-c1d199b6">
                <i class="fa-solid fa-box-open es-9aa1019a"></i>
                <p>{{ __('messages.no_products_catalog') }}</p>
            </div>
        @endif
    </main>
</div>
@endsection