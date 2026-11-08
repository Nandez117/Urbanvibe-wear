<?php

// Juan Manuel Hernandez Martelo

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeatherController extends Controller
{
    private WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index(Request $request): View
    {
        $selectedCity = (string) $request->input('city', 'Medellin');
        $weather = $this->weatherService->getCurrentWeather($selectedCity);
        $recommendedCategories = $weather['recommendation']['categories'] ?? [];

        $recommendedProducts = Product::with('category')
            ->whereHas('category', function ($query) use ($recommendedCategories) {
                $query->whereIn('name', $recommendedCategories);
            })
            ->where('stock', '>', 0)
            ->limit(6)
            ->get();

        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = Product::with('category')->where('stock', '>', 0)->limit(6)->get();
        }

        $viewData = [];
        $viewData['title'] = __('messages.weather_title');
        $viewData['weather'] = $weather;
        $viewData['cities'] = $this->weatherService->getAvailableCities();
        $viewData['selectedCity'] = $selectedCity;
        $viewData['products'] = $recommendedProducts;

        return view('weather.index')->with('viewData', $viewData);
    }
}
