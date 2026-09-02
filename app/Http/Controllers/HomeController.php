<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Urbanvibe Wear';

        return view('welcome')->with('viewData', $viewData);
    }
}
