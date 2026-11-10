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

    <div class="Drawer" id="drawer" popover="manual">
        <div class="Drawer-scroller">
            <nav class="Drawer-sheet" tabindex="-1" aria-label="{{ __('messages.admin_panel') }}">
                <div class="drawer-header">
                    <span class="drawer-brand">Urbanvibe Wear</span>
                    <button class="drawer-close-btn" id="drawer-close" aria-label="{{ __('messages.aria_close_menu') }}">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
                <ul class="drawer-nav-list">
                    <li><a href="{{ route('admin.product.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-shirt" aria-hidden="true"></i> {{ __('messages.products') }}
                    </a></li>
                    <li><a href="{{ route('admin.category.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tags" aria-hidden="true"></i> {{ __('messages.categories') }}
                    </a></li>
                    <li><a href="{{ route('admin.user.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                        <i class="fa-regular fa-user" aria-hidden="true"></i> {{ __('messages.users') }}
                    </a></li>
                    <li><a href="{{ route('home.index') }}" class="drawer-nav-link">
                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> {{ __('messages.back_to_store') }}
                    </a></li>
                </ul>
            </nav>
        </div>
    </div>

    <header>
        <div class="header-left">
            <button id="drawer-open"
                    class="menu-toggle-btn"
                    aria-label="{{ __('messages.aria_open_menu') }}"
                    aria-expanded="false"
                    aria-controls="drawer">
                <svg aria-hidden="true" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="header-center">
            <a href="{{ route('home.index') }}" class="logo">Urbanvibe Wear</a>
        </div>

        <div class="header-icons">
            <div class="lang-switch-box">
                <a href="{{ route('lang.switch', ['locale' => 'es']) }}" class="lang-pill {{ app()->getLocale() === 'es' ? 'lang-pill--active' : '' }}">ES</a>
                <span class="lang-sep">|</span>
                <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="lang-pill {{ app()->getLocale() === 'en' ? 'lang-pill--active' : '' }}">EN</a>
            </div>

            <a href="{{ route('cart.index') }}" class="header-icon cart-icon-wrap">
                <i class="fa-solid fa-cart-shopping"></i>
                @php($cartCount = app(\App\Services\Cart::class)->getCount())
                @if ($cartCount > 0)
                    <span class="badge-count">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                @if(Auth::user()->getRole() === 'admin')
                    <a href="{{ route('admin.user.index') }}" class="header-icon" title="{{ __('messages.user_management') }}"><i class="fa-regular fa-user"></i></a>
                @else
                    <a href="{{ route('user.profile') }}" class="header-icon" title="{{ __('messages.my_profile') }}"><i class="fa-regular fa-user"></i></a>
                @endif
                <form action="{{ route('logout.store') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="header-icon icon-button" title="{{ __('messages.nav_logout') }}">
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

    <script>
        (function () {
            const drawer = document.getElementById('drawer');
            const openBtn = document.getElementById('drawer-open');
            const closeBtn = document.getElementById('drawer-close');
            if (!drawer || !openBtn) { return; }
            const scroller = drawer.querySelector('.Drawer-scroller');
            const sheet = drawer.querySelector('.Drawer-sheet');
            const mainEl = document.querySelector('main');

            async function openDrawer() {
                drawer.showPopover();
                if (!CSS.supports('scroll-initial-target', 'nearest')) {
                    scroller.scrollTo({ left: scroller.offsetWidth, behavior: 'instant' });
                    await new Promise(function (r) {
                        requestAnimationFrame(function () { requestAnimationFrame(r); });
                    });
                }
                scroller.scrollTo({ left: 0, behavior: 'auto' });
            }

            function closeDrawer() {
                scroller.scrollTo({ left: scroller.offsetWidth, behavior: 'auto' });
            }

            var visibleThreshold = 1 / window.innerWidth;
            var observer = new IntersectionObserver(function (entries) {
                var entry = entries[entries.length - 1];
                if (entry.intersectionRatio < visibleThreshold) {
                    drawer.hidePopover();
                    if (mainEl) { mainEl.inert = false; }
                    openBtn.setAttribute('aria-expanded', 'false');
                }
                if (entry.intersectionRatio === 1) {
                    if (mainEl) { mainEl.inert = true; }
                    openBtn.setAttribute('aria-expanded', 'true');
                    sheet.focus();
                }
            }, { root: drawer, threshold: [visibleThreshold, 1] });
            observer.observe(sheet);

            if (!CSS.supports('animation-timeline: scroll()')) {
                scroller.addEventListener('scroll', function () {
                    var ratio = 1 - scroller.scrollLeft / sheet.offsetWidth;
                    drawer.style.setProperty('--drawer-backdrop', ratio);
                });
            }

            openBtn.addEventListener('click', openDrawer);
            if (closeBtn) { closeBtn.addEventListener('click', closeDrawer); }
            drawer.addEventListener('click', function (event) {
                if (!sheet.contains(event.target)) { closeDrawer(); }
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') { closeDrawer(); }
            });
        }());
    </script>

</body>
</html>
