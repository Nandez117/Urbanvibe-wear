<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Usuarios - Urbanvibe Wear';
        $viewData['users'] = User::all();

        return view('user.index')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['title'] = 'Editar Usuario';
        $viewData['user'] = User::findOrFail($id);

        return view('user.edit')->with('viewData', $viewData);
    }

    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Using setters according to the encapsulation rules
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

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Integrity check: prevent deletion if user has orders
        // Since we don't have the relationship set up yet in this snippet, we use the Order model directly.
        $hasOrders = Order::where('user_id', $user->getId())->exists();

        if ($hasOrders) {
            return redirect()->route('users.index')->with('error', 'No se puede eliminar el usuario porque tiene órdenes de compra asociadas (Regla de Integridad).');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
