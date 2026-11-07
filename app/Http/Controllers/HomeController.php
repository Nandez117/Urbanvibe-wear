<?php

// Esteban Alvarez Garcia, Juan Manuel Hernandez Martelo, Yan Frank Ríos López

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('messages.brand_name');

        return view('welcome')->with('viewData', $viewData);
    }
}
