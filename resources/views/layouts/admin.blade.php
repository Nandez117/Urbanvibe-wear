<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Urbanvibe-wear')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
    --bg-primary: #0a0d12;
    --surface: #12151b;
    --surface-elevated: #191d24;
    --surface-input: #1b1f27;
    --border-subtle: #262b33;

    --accent: #2f8bff;
    --accent-dark: #1c6fe0;
    --accent-soft: rgba(47, 139, 255, 0.14);

    --text-primary: #f2f4f7;
    --text-secondary: #949ca6;
    --text-on-accent: #ffffff;

    --danger: #ff5470;
    --danger-bg: rgba(255, 84, 112, 0.12);
    --success: #3ddc84;
    --success-bg: rgba(61, 220, 132, 0.12);

    /* nombres antiguos, por compatibilidad con estilos inline existentes */
    --primary-blue: var(--accent);
    --primary-blue-hover: var(--accent-dark);
    --white: var(--surface);
    --text-dark: var(--text-primary);
    --text-gray: var(--text-secondary);
    --bg-gray: var(--surface-elevated);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

h1, h2, h3, .logo {
    font-family: 'Space Grotesk', sans-serif;
}

body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.5;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Header Styles */
header {
    background-color: var(--surface);
    color: var(--text-primary);
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-subtle);
}

.logo-container {
    flex: 1;
    display: flex;
    align-items: center;
}

.logo {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.02em;
    text-decoration: none;
    color: var(--accent);
}

.nav-links {
    flex: 2;
    display: flex;
    justify-content: center;
    gap: 2.5rem;
}

.nav-link {
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: color 0.2s ease;
    position: relative;
}

.nav-link:hover {
    color: var(--text-primary);
}

.nav-link.active {
    color: var(--text-primary);
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--accent);
}

.header-icons {
    flex: 1;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 1.25rem;
    transition: color 0.2s ease;
}

.header-icon:hover {
    color: var(--accent);
}

/* Main Content */
main {
    flex: 1;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background-color: var(--accent);
    color: var(--text-on-accent);
    text-decoration: none;
    font-weight: 700;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
    text-align: center;
}

.btn:hover {
    background-color: var(--accent-dark);
    box-shadow: 0 0 20px rgba(47, 139, 255, 0.3);
}

.btn:active {
    transform: translateY(1px);
}

.btn-block {
    display: block;
    width: 100%;
}

/* Tables */
.table-container {
    width: 100%;
    overflow-x: auto;
    margin-top: 1.5rem;
    border-radius: 0.5rem;
    border: 1px solid var(--border-subtle);
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    background-color: var(--surface);
}

th {
    background-color: var(--admin-header);
    color: var(--text-secondary);
    padding: 1rem;
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-subtle);
    color: var(--text-primary);
}

tr:last-child td {
    border-bottom: none;
}

.title-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
    font-weight: 500;
}
.alert-success {
    background-color: var(--success-bg);
    color: var(--success);
}
.alert-error {
    background-color: var(--danger-bg);
    color: var(--danger);
}

/* Auth card */
.auth-page {
    display: flex;
    justify-content: center;
    padding: 2rem 0;
}

.auth-card {
    width: 100%;
    max-width: 420px;
    background-color: var(--surface);
    border: 1px solid var(--border-subtle);
    border-radius: 12px;
    padding: 2.5rem;
        box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(47, 139, 255, 0.06);
}

.auth-card h2 {
    text-align: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 2rem;
}

.auth-field {
    margin-bottom: 1.25rem;
}

.auth-field label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 0.4rem;
}

.auth-field input,
.auth-field select {
    width: 100%;
    padding: 0.75rem 1rem;
    background-color: var(--surface-input);
    border: 1px solid var(--border-subtle);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 1rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.auth-field input:focus,
.auth-field select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
}

.auth-switch {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.auth-switch a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
}

.auth-switch a:hover {
    text-decoration: underline;
}

.actions-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-sm {
    padding: 0.4rem 0.9rem;
    font-size: 0.85rem;
}

.btn-danger {
    background-color: var(--danger);
    color: #fff;
}

.btn-danger:hover {
    background-color: #e13f5c;
    box-shadow: 0 0 20px rgba(255, 84, 112, 0.25);
}

.btn-secondary {
    background-color: transparent;
    color: var(--text-primary);
    border: 1px solid var(--border-subtle);
}

.btn-secondary:hover {
    background-color: transparent;
    color: var(--accent);
    border-color: var(--accent);
    box-shadow: none;
}

.btn-success {
    background-color: var(--success);
    color: #0a0d12;
}

.btn-success:hover {
    background-color: #34c476;
    box-shadow: 0 0 20px rgba(61, 220, 132, 0.3);
}

.qty-input {
    width: 60px;
    padding: 0.4rem;
    border-radius: 6px;
    border: 1px solid var(--border-subtle);
    background-color: var(--surface-input);
    color: var(--text-primary);
}

.form-card {
    width: 100%;
    max-width: 480px;
    background-color: var(--surface);
    border: 1px solid var(--border-subtle);
    border-radius: 12px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(47, 139, 255, 0.06);
}

.form-card h2 {
    text-align: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.form-field {
    margin-bottom: 1.25rem;
}

.form-field label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 0.4rem;
}

.form-field input,
.form-field select {
    width: 100%;
    padding: 0.75rem 1rem;
    background-color: var(--surface-input);
    border: 1px solid var(--border-subtle);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 1rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.form-field input:focus,
.form-field select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
}
        /* --- Catalog Redesign Styles --- */
    .catalog-layout {
        display: flex;
        gap: 2rem;
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
        align-items: flex-start;
    }

    .catalog-sidebar {
        width: 250px;
        flex-shrink: 0;
        background: var(--surface);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--border-subtle);
    }
    .catalog-sidebar h3 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    .sidebar-section {
        margin-bottom: 1.5rem;
    }
    .sidebar-section h4 {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .sidebar-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-size: 0.95rem;
    }
    
    .catalog-content {
        flex: 1;
    }

    .catalog-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-subtle);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .product-card {
        background: var(--surface);
        border: 1px solid var(--border-subtle);
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        border-color: var(--accent);
    }
    .product-image-container {
        width: 100%;
        aspect-ratio: 3 / 4; /* Tall image format */
        background-color: var(--admin-header);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border-subtle);
    }
    .product-image-placeholder {
        font-size: 3rem;
        color: var(--border-subtle);
    }
    .product-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: var(--accent);
        color: white;
        font-size: 0.7rem;
        font-weight: bold;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        text-transform: uppercase;
    }
    
    .product-details {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .product-category {
        font-size: 0.75rem;
        color: var(--accent);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .product-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: auto;
        margin-bottom: 1rem;
    }

    .btn-buy {
        background: #facc15; /* Yellow accent like reference */
        color: #1a1a1a;
        font-weight: 700;
        text-align: center;
        padding: 0.75rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s;
    }
    .btn-buy:hover {
        background: #eab308;
    }
    .admin-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-subtle);
    }
    .admin-actions form {
        flex: 1;
    }
    .btn-admin {
        width: 100%;
        text-align: center;
        padding: 0.5rem;
        font-size: 0.8rem;
    }
    
    @media (max-width: 768px) {
        .catalog-layout {
            flex-direction: column;
        }
        .catalog-sidebar {
            width: 100%;
        }
    }
</style>
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
                <a href="/users" class="header-icon"><i class="fa-regular fa-user"></i></a>
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