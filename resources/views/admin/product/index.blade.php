{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.products') }}</h2>
</div>

<div class="es-47118b4a">
    <div class="admin-flex admin-justify-between admin-items-center admin-mb-4">
        <a href="{{ route('admin.product.create') }}" class="btn">{{ __('messages.register_product') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success admin-mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error admin-mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-container es-4a68d232">
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.lbl_id') }}</th>
                    <th>{{ __('messages.lbl_name') }}</th>
                    <th>{{ __('messages.lbl_price') }}</th>
                    <th>{{ __('messages.lbl_stock') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($viewData['products'] as $product)
                    <tr>
                        <td>{{ $product->getId() }}</td>
                        <td>{{ $product->getName() }}</td>
                        <td>${{ number_format($product->getPrice(), 2) }}</td>
                        <td>{{ $product->getStock() }}</td>
                        <td>
                            <div class="actions-row">
                                <a href="{{ route('admin.product.edit', ['id' => $product->getId()]) }}" class="btn btn-sm btn-secondary">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.product.destroy', ['id' => $product->getId()]) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_product') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="es-80f9a287">{{ __('messages.no_products') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($viewData['products']->hasPages())
            <div class="pagination-wrapper">
                {{ $viewData['products']->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
