@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="es-e4fe4b34">
    <div class="es-92837179">
        <div>
            <p class="es-fad8088b">{{ __('messages.personal_account') }}</p>
            <h2>{{ __('messages.my_profile') }}</h2>
        </div>
        <i class="fa-regular fa-circle-user es-88d42768"></i>
    </div>

    <div class="es-7ad8514a">
        <div>
            <strong>{{ __('messages.lbl_name') }}</strong>
            <p>{{ $viewData['user']->getName() }}</p>
        </div>
        <div>
            <strong>{{ __('messages.email_long') }}</strong>
            <p>{{ $viewData['user']->getEmail() }}</p>
        </div>
        <div>
            <strong>{{ __('messages.phone') }}</strong>
            <p>{{ $viewData['user']->getPhone() ?: 'No registrado' }}</p>
        </div>
        <div>
            <strong>{{ __('messages.address') }}</strong>
            <p>{{ $viewData['user']->getAddress() ?: 'No registrada' }}</p>
        </div>
    </div>

    <div class="es-938c88b9">
        <a href="{{ route('orders.index') }}" class="btn">{{ __('messages.view_my_orders') }}</a>
        <a href="{{ route('home.index') }}" class="btn btn-secondary">{{ __('messages.back_to_store') }}</a>
    </div>
</div>
@endsection
