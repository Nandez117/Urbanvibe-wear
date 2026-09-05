<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        $viewData = [];
        $viewData['title'] = 'Crear cuenta';

        return view('auth.register')->with('viewData', $viewData);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = new User;
        $user->setName($request->input('name'));
        $user->setEmail($request->input('email'));
        $user->setPassword($request->input('password'));
        $user->setPhone($request->input('phone'));
        $user->setAddress($request->input('address'));
        $user->setRole('client');
        $user->save();

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Cuenta creada correctamente.');
    }

    public function showLogin(): View
    {
        $viewData = [];
        $viewData['title'] = 'Iniciar sesión';

        return view('auth.login')->with('viewData', $viewData);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Credenciales inválidas.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Sesión iniciada correctamente.');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente.');
    }
}
