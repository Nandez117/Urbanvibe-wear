<?php

// Juan Manuel Hernandez Martelo

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function profile(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.title_my_profile');
        $viewData['user'] = User::findOrFail(Auth::id());

        return view('user.profile')->with('viewData', $viewData);
    }

    public function edit(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.title_my_profile');
        $viewData['user'] = Auth::user();

        return view('user.edit')->with('viewData', $viewData);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->setName($request->input('name'));
        $user->setPhone($request->input('phone'));
        $user->setAddress($request->input('address'));
        $user->save();

        return redirect()->route('profile.index')->with('success', __('messages.user_update_success'));
    }
}
