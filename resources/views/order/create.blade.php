{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-9b7d0058">
    <h2>{{ __('messages.create_order') }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p class="es-550a9f75">{{ __('messages.order_associated_auto') }}</p>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <button type="submit" class="btn">{{ __('messages.create_order_btn') }}</button>
        <a href="{{ route('orders.index') }}" class="btn">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection