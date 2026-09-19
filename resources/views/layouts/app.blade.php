{{--  Juan Manuel Hernandez Martelo  --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Urbanvibe-wear')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/extracted.css') }}">
    @stack('styles')
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="/" class="logo">Urbanvibe Wear</a>
        </div>
        
        <nav class="nav-links">
              <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('messages.nav_welcome') }}</a>
              <a href="/products" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">{{ __('messages.nav_catalog') }}</a>
              <a href="/orders" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">{{ __('messages.nav_orders') }}</a>
              @auth
              <a href="{{ route('wishlist.index') }}" class="nav-link {{ request()->is('wishlist*') ? 'active' : '' }}">{{ __('messages.nav_wishlist') }}</a>
              @endauth
              
          </nav>
        
                <div class="header-icons">
                  <a href="{{ route('cart.index') }}" class="header-icon es-d85c4e64">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @php($cartCount = app(\App\Services\Cart::class)->getCount())
                    @if ($cartCount > 0)
                        <span class="es-35c98830">{{ $cartCount }}</span>
                    @endif
                   </a>
            @auth
                @if(Auth::user()->getRole() === 'admin')
                      <a href="{{ route('admin.products.index') }}" class="header-icon" title="{{ __('messages.admin_panel') }}"><i class="fa-solid fa-screwdriver-wrench"></i></a>
                      <a href="{{ route('users.index') }}" class="header-icon" title="{{ __('messages.user_management') }}"><i class="fa-regular fa-user"></i></a>
                  @else
                      <a href="{{ route('profile.index') }}" class="header-icon" title="{{ __('messages.my_profile') }}"><i class="fa-regular fa-user"></i></a>
                  @endif
                <form action="{{ route('logout.store') }}" method="POST" class="es-3df0a395">
                    @csrf
                    <button type="submit" class="header-icon es-338eb478">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login.index') }}" class="header-icon"><i class="fa-solid fa-right-to-bracket"></i></a>
            @endauth
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
