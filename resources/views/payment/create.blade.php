@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="form-card">
        <h2>{{ __('messages.register_payment') }}</h2>
        <p class="es-78c6aefe">
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
                <label for="amount">{{ __('messages.amount') }}</label>
                <input id="amount" type="number" name="amount" min="0" step="0.01"
                       value="{{ old('amount', $viewData['order']->getTotalAmount()) }}" required readonly style="background-color: var(--surface); color: var(--text-secondary); cursor: not-allowed;">
            </div>
            <div class="form-field">
                <label for="method">{{ __('messages.payment_method') }}</label>
                <select id="method" name="method" required>
                    <option value="">{{ __('messages.select_method') }}</option>
                    <option value="{{ __('messages.credit_card') }}" {{ old('method') == '{{ __('messages.credit_card') }}' ? 'selected' : '' }}>{{ __('messages.credit_card') }}</option>
                    <option value="{{ __('messages.pse') }}" {{ old('method') == '{{ __('messages.pse') }}' ? 'selected' : '' }}>{{ __('messages.pse') }}</option>
                    <option value="{{ __('messages.cash') }}" {{ old('method') == '{{ __('messages.cash') }}' ? 'selected' : '' }}>{{ __('messages.cash') }}</option>
                </select>
            </div>
            <div class="form-field">
                <label for="reference">{{ __('messages.transaction_reference') }}</label>
                <input id="reference" type="text" name="reference"
                       value="{{ old('reference') }}" required>
            </div>
            <button type="submit" class="btn btn-block">{{ __('messages.register_payment') }}</button>
        </form>
    </div>
</div>
@endsection