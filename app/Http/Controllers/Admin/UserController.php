<?php

// Autor: Juan Manuel Hernandez Martelo

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        abort_unless(User::findOrFail(Auth::id())->getRole() === 'admin', 403);

        $viewData = [];
        $viewData['title'] = 'Usuarios - Urbanvibe Wear';
        $viewData['users'] = User::all();

        return view('admin.user.index')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        abort_unless(User::findOrFail(Auth::id())->getRole() === 'admin', 403);

        $viewData = [];
        $viewData['title'] = 'Editar Usuario';
        $viewData['user'] = User::findOrFail($id);

        return view('admin.user.edit')->with('viewData', $viewData);
    }

    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        abort_unless(User::findOrFail(Auth::id())->getRole() === 'admin', 403);

        $user = User::findOrFail($id);

        $user->setName($request->input('name'));
        $user->setEmail($request->input('email'));

        if ($request->filled('address')) {
            $user->setAddress($request->input('address'));
        }

        if ($request->filled('phone')) {
            $user->setPhone($request->input('phone'));
        }

        if ($request->filled('role')) {
            $user->setRole($request->input('role'));
        }

        $user->save();

        return redirect()->route('users.index')->with('success', __('messages.user_update_success'));
    }

    public function destroy(string $id): RedirectResponse
    {
        abort_unless(User::findOrFail(Auth::id())->getRole() === 'admin', 403);

        $user = User::findOrFail($id);

        $hasOrders = Order::where('user_id', $user->getId())->exists();

        if ($hasOrders) {
            return redirect()->route('users.index')->with('error', __('messages.user_has_orders_error'));
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', __('messages.user_delete_success'));
    }
}
