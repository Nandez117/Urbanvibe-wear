@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 720px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
        <div>
            <p style="color: var(--text-gray); margin-bottom: 0.25rem;">Cuenta personal</p>
            <h2>Mi perfil</h2>
        </div>
        <i class="fa-regular fa-circle-user" style="font-size: 3rem; color: var(--accent);"></i>
    </div>

    <div style="display: grid; gap: 1rem;">
        <div>
            <strong>Nombre</strong>
            <p>{{ $viewData['user']->getName() }}</p>
        </div>
        <div>
            <strong>Correo electrónico</strong>
            <p>{{ $viewData['user']->getEmail() }}</p>
        </div>
        <div>
            <strong>Teléfono</strong>
            <p>{{ $viewData['user']->getPhone() ?: 'No registrado' }}</p>
        </div>
        <div>
            <strong>Dirección</strong>
            <p>{{ $viewData['user']->getAddress() ?: 'No registrada' }}</p>
        </div>
    </div>

    <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
        <a href="{{ route('orders.index') }}" class="btn">Ver mis pedidos</a>
        <a href="{{ route('home') }}" class="btn btn-secondary">Volver a la tienda</a>
    </div>
</div>
@endsection
