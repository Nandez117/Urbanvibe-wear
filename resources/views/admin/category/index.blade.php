{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.manage_categories') }}</h2>
</div>

<div class="split-layout">
    
    <div class="card-panel">
        <h3 class="mb-1">{{ __('messages.new_category') }}</h3>
        
        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="ml-15">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.category.store') }}" class="form-stack">
            @csrf
            <div>
                <label class="form-label-block" for="category-name">{{ __('messages.category_name') }}</label>
                <input id="category-name" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.ex_hoodie') }}" required class="form-input-full">
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn">{{ __('messages.btn_create_category') }}</button>
        </form>
    </div>

    <div class="table-container table-grow">
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.lbl_id') }}</th>
                    <th>{{ __('messages.lbl_name') }}</th>
                    <th>{{ __('messages.lbl_actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['categories'] as $category)
                <tr>
                    <td>{{ $category->getId() }}</td>
                    <td>{{ $category->getTranslatedName() }}</td>
                    <td>
                        <div class="actions-row">
                            <a href="{{ route('admin.category.edit', ['id' => $category->getId()]) }}" class="btn btn-sm">{{ __('messages.btn_edit') }}</a>
                            <form action="{{ route('admin.category.destroy', ['id' => $category->getId()]) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_category') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.btn_delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if(count($viewData['categories']) === 0)
            <div class="empty-state">
                {{ __('messages.no_categories') }}
            </div>
        @endif
    </div>
</div>
@endsection
