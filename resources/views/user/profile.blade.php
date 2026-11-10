{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="content-card content-card--md">
    <div class="profile-header">
        <div>
            <p class="profile-eyebrow">{{ __('messages.personal_account') }}</p>
            <h2>{{ __('messages.my_profile') }}</h2>
        </div>
        <i class="fa-regular fa-circle-user profile-avatar"></i>
    </div>

    <div class="profile-data-grid">
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
            <p>{{ $viewData['user']->getPhone() ?: __('messages.not_registered') }}</p>
        </div>
        <div>
            <strong>{{ __('messages.address') }}</strong>
            <p>{{ $viewData['user']->getAddress() ?: __('messages.not_registered') }}</p>
        </div>
    </div>

    <div class="profile-actions-row">
        <a href="{{ route('user.edit') }}" class="btn btn-outline-accent">{{ __('messages.btn_edit') }}</a>
        <a href="{{ route('order.index') }}" class="btn">{{ __('messages.view_my_orders') }}</a>
        <a href="{{ route('home.index') }}" class="btn btn-secondary">{{ __('messages.back_to_store') }}</a>
    </div>
</div>
@endsection
