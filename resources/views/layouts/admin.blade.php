{{-- Autor: Juan Manuel Hernandez Martelo --}}
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
    @stack('styles')
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="/" class="logo">Urbanvibe Wear</a>
        </div>
        
        <nav class="nav-links">
              <a href="/" class="nav-link">Volver a Tienda</a>
              <a href="/products" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">Gestionar Productos</a>
              <a href="/categories" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">Categorías</a>
              <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">Usuarios</a>
          </nav>
        
                <div class="header-icons">
                  <a href="{{ route('cart.index') }}" class="header-icon" style="position: relative;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if (session('cart') && array_sum(session('cart')) > 0)
                        <span style="position: absolute; top: -8px; right: -10px; background-color: var(--danger); color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 9999px;">{{ array_sum(session('cart')) }}</span>
                    @endif
                   </a>
            @auth
                @if(Auth::user()->getRole() === 'admin')
                    <a href="{{ route('users.index') }}" class="header-icon" title="Gestión de usuarios"><i class="fa-regular fa-user"></i></a>
                @else
                    <a href="{{ route('profile') }}" class="header-icon" title="Mi perfil"><i class="fa-regular fa-user"></i></a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="header-icon" style="background: none; border: none; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header-icon"><i class="fa-solid fa-right-to-bracket"></i></a>
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