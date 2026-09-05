@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; background-color: var(--white); padding: 2rem; border-radius: 0.5rem;">
    <h2>Crear pedido</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div>
            <label for="user_id">Cliente</label>
            <select id="user_id" name="user_id" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($viewData['users'] as $user)
                    <option value="{{ $user->getId() }}" {{ old('user_id') == $user->getId() ? 'selected' : '' }}>{{ $user->getName() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="totalAmount">Monto total</label>
            <input id="totalAmount" type="number" name="totalAmount" min="0" step="0.01" value="{{ old('totalAmount') }}" required>
        </div>
        <button type="submit" class="btn">Crear pedido</button>
        <a href="{{ route('orders.index') }}" class="btn">Cancelar</a>
    </form>
</div>
@endsection