@extends('layouts.app')
@section('title', 'Bienvenido - Urbanvibe Wear')

@section('content')
<div style="text-align: center; padding: 4rem 1rem;">
    <h1 style="font-size: 3rem; font-weight: 700; color: var(--primary-blue); margin-bottom: 1rem;">Urbanvibe Wear</h1>
    <p style="font-size: 1.25rem; color: var(--text-gray); max-width: 600px; margin: 0 auto 2rem auto;">
        Tu tienda exclusiva de ropa urbana. Explora nuestro catálogo y encuentra el estilo que te define.
    </p>
    
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('products.index') }}" class="btn" style="font-size: 1.125rem; padding: 0.75rem 2rem;">Ver Catálogo</a>
        <a href="{{ route('users.index') }}" class="btn" style="font-size: 1.125rem; padding: 0.75rem 2rem; background-color: var(--white); color: var(--primary-blue); border: 2px solid var(--primary-blue);">Gestión de Usuarios</a>
    </div>
</div>

<div style="display: flex; justify-content: space-around; margin-top: 4rem; text-align: center; color: var(--text-gray);">
    <div>
        <i class="fa-solid fa-shield-halved" style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.125rem; color: var(--text-dark); margin-bottom: 0.5rem;">Pagos Seguros</h3>
        <p>Tu información está protegida.</p>
    </div>
    <div>
        <i class="fa-solid fa-rotate-left" style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.125rem; color: var(--text-dark); margin-bottom: 0.5rem;">Devoluciones</h3>
        <p>Satisfacción 100% garantizada.</p>
    </div>
</div>
@endsection