{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="content-card content-card--sm">
    <h2 class="mb-15">{{ __('messages.category_edit_title') }}: {{ $viewData['category']->getTranslatedName() }}</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="ml-15">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.category.update', ['id' => $viewData['category']->getId()]) }}" class="form-stacked">
        @csrf
        @method('PUT')
        
        <div>
            <label class="form-label-block" for="category-name">{{ __('messages.category_name') }}</label>
            <input id="category-name" type="text" name="name" value="{{ old('name', $viewData['category']->getName()) }}" required class="input-full">
            @error('name')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="category-actions">
            <button type="submit" class="btn">{{ __('messages.btn_update') }}</button>
            <a href="{{ route('admin.category.index') }}" class="btn btn-gray">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
