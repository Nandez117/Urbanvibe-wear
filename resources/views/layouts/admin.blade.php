{{--  Juan Manuel Hernandez Martelo  --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Urbanvibe-wear')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/extracted.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body>

    <header class="admin-header">
        <div class="header-left">
            <a href="{{ route('home.index') }}" class="logo">Urbanvibe Wear</a>
        </div>

        <nav class="nav-links">
            <a href="{{ route('home.index') }}" class="nav-link">{{ __('messages.back_to_store') }}</a>
            <a href="{{ route('admin.product.index') }}" class="nav-link {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">{{ __('messages.products') }}</a>
            <a href="{{ route('admin.category.index') }}" class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">{{ __('messages.categories') }}</a>
            <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">{{ __('messages.users') }}</a>
        </nav>

        <div class="header-icons">
            <div class="lang-switch-box">
                <a href="{{ route('lang.switch', ['locale' => 'es']) }}" class="lang-pill {{ app()->getLocale() === 'es' ? 'lang-pill--active' : '' }}">ES</a>
                <span class="lang-sep">|</span>
                <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="lang-pill {{ app()->getLocale() === 'en' ? 'lang-pill--active' : '' }}">EN</a>
            </div>

            <a href="{{ route('cart.index') }}" class="header-icon es-d85c4e64">
                <i class="fa-solid fa-cart-shopping"></i>
                @php($cartCount = app(\App\Services\Cart::class)->getCount())
                @if ($cartCount > 0)
                    <span class="es-35c98830">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                @if(Auth::user()->getRole() === 'admin')
                    <a href="{{ route('admin.user.index') }}" class="header-icon" title="{{ __('messages.user_management') }}"><i class="fa-regular fa-user"></i></a>
                @else
                    <a href="{{ route('user.profile') }}" class="header-icon" title="{{ __('messages.my_profile') }}"><i class="fa-regular fa-user"></i></a>
                @endif
                <form action="{{ route('logout.store') }}" method="POST" class="es-3df0a395">
                    @csrf
                    <button type="submit" class="header-icon es-338eb478" title="{{ __('messages.nav_logout') }}">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login.index') }}" class="header-icon" title="{{ __('messages.nav_login') }}"><i class="fa-solid fa-right-to-bracket"></i></a>
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

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <p class="footer-brand-name">Urbanvibe Wear</p>
                <p class="footer-tagline">{{ __('messages.footer_tagline') }}</p>
            </div>
            <div class="footer-col">
                <h2 class="footer-heading">{{ __('messages.footer_quick_links') }}</h2>
                <ul class="footer-links">
                    <li><a href="{{ route('product.index') }}" class="footer-link">{{ __('messages.footer_catalog') }}</a></li>
                    <li><a href="{{ route('order.index') }}" class="footer-link">{{ __('messages.footer_orders') }}</a></li>
                    <li><a href="{{ route('review.index') }}" class="footer-link">{{ __('messages.footer_reviews') }}</a></li>
                    <li><a href="{{ route('partner.index') }}" class="footer-link">{{ __('messages.footer_partner') }}</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h2 class="footer-heading">{{ __('messages.footer_follow_us') }}</h2>
                <div class="footer-social">
                    <a href="#" class="footer-social-link" aria-label="{{ __('messages.footer_aria_facebook') }}"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="#" class="footer-social-link" aria-label="{{ __('messages.footer_aria_instagram') }}"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                    <a href="#" class="footer-social-link" aria-label="{{ __('messages.footer_aria_twitter') }}"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Urbanvibe Wear. {{ __('messages.footer_copyright') }}
        </div>
    </footer>

</body>
</html>
