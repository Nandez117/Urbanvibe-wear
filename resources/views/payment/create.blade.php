{{--  Yan Frank R�os L�pez  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="auth-page">
    <div class="form-card">
        <h2>{{ __('messages.register_payment') }}</h2>
        <p class="payment-subtitle">
            {{ __('messages.lbl_order_number') }}: {{ $viewData['order']->getOrderNumber() }} &mdash;
            ${{ number_format($viewData['order']->getTotalAmount(), 2) }} USD
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

        <form method="POST" action="{{ route('payment.store', ['id' => $viewData['order']->getId()]) }}">
            @csrf
            <div class="form-field">
                <label for="amount">{{ __('messages.amount') }}</label>
                <input id="amount" type="number" name="amount" min="0" step="0.01"
                       value="{{ old('amount', $viewData['order']->getTotalAmount()) }}" required readonly class="input-readonly">
            </div>
            <div class="form-field">
                <label for="method">{{ __('messages.payment_method') }}</label>
                <select id="method" name="method" required>
                    <option value="">{{ __('messages.select_method') }}</option>
                    <option value="credit_card" {{ old('method') === 'credit_card' ? 'selected' : '' }}>{{ __('messages.credit_card') }}</option>
                    <option value="paypal" {{ old('method') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="pse" {{ old('method') === 'pse' ? 'selected' : '' }}>{{ __('messages.pse') }}</option>
                    <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>{{ __('messages.cash') }}</option>
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
