@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="form-card">
        <h2>Registrar pago</h2>
        <p style="text-align: center; color: var(--text-secondary); margin-bottom: 1.5rem;">
            Pedido {{ $viewData['order']->getOrderNumber() }} &mdash;
            ${{ number_format($viewData['order']->getTotalAmount(), 2) }}
        </p>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('payments.store', ['id' => $viewData['order']->getId()]) }}">
            @csrf
            <div class="form-field">
                <label for="amount">Monto</label>
                <input id="amount" type="number" name="amount" min="0" step="0.01"
                       value="{{ old('amount', $viewData['order']->getTotalAmount()) }}" required>
            </div>
            <div class="form-field">
                <label for="method">Método de pago</label>
                <select id="method" name="method" required>
                    <option value="">Seleccione un método</option>
                    <option value="Tarjeta de crédito" {{ old('method') == 'Tarjeta de crédito' ? 'selected' : '' }}>Tarjeta de crédito</option>
                    <option value="PSE" {{ old('method') == 'PSE' ? 'selected' : '' }}>PSE</option>
                    <option value="Efectivo" {{ old('method') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                </select>
            </div>
            <div class="form-field">
                <label for="reference">Referencia de transacción</label>
                <input id="reference" type="text" name="reference"
                       value="{{ old('reference') }}" required>
            </div>
            <button type="submit" class="btn btn-block">Registrar pago</button>
        </form>
    </div>
</div>
@endsection