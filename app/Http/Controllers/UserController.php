<?php

// Autor: Juan Manuel Hernandez Martelo

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function profile(): View
    {
        $viewData = [];
        $viewData['title'] = 'Mi perfil - Urbanvibe Wear';
        $viewData['user'] = User::findOrFail(Auth::id());

        return view('user.profile')->with('viewData', $viewData);
    }
}
