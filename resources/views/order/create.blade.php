@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem;">
    <h2>Crear Pedido</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p style="color: var(--text-gray); margin-bottom: 1.5rem;">El pedido se asociará automáticamente a tu cuenta. Después podrás agregar los productos.</p>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <button type="submit" class="btn">Crear pedido</button>
        <a href="{{ route('orders.index') }}" class="btn">Cancelar</a>
    </form>
</div>
@endsection