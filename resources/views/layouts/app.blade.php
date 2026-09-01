<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Urbanvibe-wear')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e40af; /* Azul oscuro pero no tan oscuro */
            --primary-blue-hover: #1e3a8a;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #4b5563;
            --bg-gray: #f3f4f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--text-dark);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        header {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-decoration: none;
            color: var(--white);
            text-transform: uppercase;
        }

        .nav-links {
            flex: 2;
            display: flex;
            justify-content: center;
            gap: 2.5rem;
        }

        .nav-link {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: opacity 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--white);
        }

        .header-icons {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            gap: 1.5rem;
        }

        .header-icon {
            color: var(--white);
            text-decoration: none;
            font-size: 1.25rem;
            transition: opacity 0.2s ease;
        }

        .header-icon:hover {
            opacity: 0.8;
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
            background-color: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            text-align: center;
        }

        .btn:hover {
            background-color: var(--primary-blue-hover);
        }

        .btn:active {
            transform: translateY(1px);
        }

        /* Tables (For Users) */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background-color: var(--white);
        }

        th {
            background-color: var(--bg-gray);
            color: var(--text-gray);
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--bg-gray);
            color: var(--text-dark);
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
            background-color: #dcfce7;
            color: #166534;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <a href="/" class="logo">Urbanvibe Wear</a>
        </div>
        
        <nav class="nav-links">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Bienvenido</a>
            <a href="/products" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">Catálogo</a>
            <a href="/categories" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">Categorías (Admin)</a>
            <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">Usuarios (Admin)</a>
        </nav>
        
        <div class="header-icons">
            <a href="#" class="header-icon"><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="/users" class="header-icon"><i class="fa-regular fa-user"></i></a>
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