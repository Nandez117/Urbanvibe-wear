{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.manage_categories') }}</h2>
</div>

<div class="es-47118b4a">
    
    <div class="es-9f13cd59">
        <h3 class="es-4986ecf7">{{ __('messages.new_category') }}</h3>
        
        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="es-552f38ac">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.store') }}" class="es-f48bc238">
            @csrf
            <div>
                <label class="es-4e832e11">{{ __('messages.category_name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.ex_hoodie') }}" required class="es-9ef793ad">
            </div>
            <button type="submit" class="btn">{{ __('messages.btn_create_category') }}</button>
        </form>
    </div>

    <div class="table-container es-4a68d232">
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
                    <td>{{ $category->getName() }}</td>
                    <td>
                        <div class="actions-row">
                            <a href="{{ route('categories.edit', ['id' => $category->getId()]) }}" class="btn btn-sm">{{ __('messages.btn_edit') }}</a>
                            <form action="{{ route('categories.destroy', ['id' => $category->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
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
            <div class="es-80f9a287">
                {{ __('messages.no_categories') }}
            </div>
        @endif
    </div>
</div>
@endsection