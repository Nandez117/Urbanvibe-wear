{{--  Juan Manuel Hernandez Martelo  --}}
@extends('layouts.admin')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.user_management_title') }}</h2>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.lbl_id') }}</th>
                <th>{{ __('messages.lbl_name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.phone') }}</th>
                <th>{{ __('messages.address') }}</th>
                <th>{{ __('messages.role') }}</th>
                <th>{{ __('messages.lbl_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['users'] as $user)
            <tr>
                <td>{{ $user->getId() }}</td>
                <td>{{ $user->getName() }}</td>
                <td>{{ $user->getEmail() }}</td>
                <td>{{ $user->getPhone() ?? 'N/A' }}</td>
                <td>{{ $user->getAddress() ?? 'N/A' }}</td>
                <td>
                    <span class="{{ $user->getRole() === 'admin' ? 'role-badge-admin' : 'role-badge-client' }}">
                        {{ ucfirst($user->getRole()) }}
                    </span>
                </td>
                <td>
                    <div class="actions-row">
                        <a href="{{ route('users.edit', ['id' => $user->getId()]) }}" class="btn btn-sm">{{ __('messages.btn_edit') }}</a>
                        <form action="{{ route('users.destroy', ['id' => $user->getId()]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
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
    
    @if(count($viewData['users']) === 0)
        <div class="empty-state">{{ __('messages.no_users_registered') }}</div>
    @endif
</div>
@endsection
