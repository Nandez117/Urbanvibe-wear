<?php

// Juan Manuel Hernandez Martelo

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    private array $cities = [
        'Medellin' => ['name' => 'Medellín, Colombia', 'lat' => 6.2518, 'lon' => -75.5636],
        'Bogota' => ['name' => 'Bogotá, Colombia', 'lat' => 4.7110, 'lon' => -74.0721],
        'Cali' => ['name' => 'Cali, Colombia', 'lat' => 3.4516, 'lon' => -76.5320],
        'NewYork' => ['name' => 'New York, USA', 'lat' => 40.7128, 'lon' => -74.0060],
        'Madrid' => ['name' => 'Madrid, España', 'lat' => 40.4168, 'lon' => -3.7038],
        'Tokyo' => ['name' => 'Tokyo, Japan', 'lat' => 35.6762, 'lon' => 139.6503],
    ];

    public function getAvailableCities(): array
    {
        return $this->cities;
    }

    public function getCurrentWeather(string $cityKey = 'Medellin'): array
    {
        $city = $this->cities[$cityKey] ?? $this->cities['Medellin'];

        try {
            $url = 'https://api.open-meteo.com/v1/forecast';
            $response = Http::timeout(4)->get($url, [
                'latitude' => $city['lat'],
                'longitude' => $city['lon'],
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m',
                'timezone' => 'auto',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $current = $data['current'] ?? [];

                $weatherCode = (int) ($current['weather_code'] ?? 0);
                $condition = $this->parseWeatherCode($weatherCode);

                return [
                    'city_key' => $cityKey,
                    'city_name' => $city['name'],
                    'temperature' => round((float) ($current['temperature_2m'] ?? 22), 1),
                    'apparent_temperature' => round((float) ($current['apparent_temperature'] ?? 22), 1),
                    'humidity' => (int) ($current['relative_humidity_2m'] ?? 60),
                    'wind_speed' => round((float) ($current['wind_speed_10m'] ?? 10), 1),
                    'condition' => $condition['text'],
                    'icon' => $condition['icon'],
                    'is_rain' => $condition['is_rain'],
                    'recommendation' => $this->getOutfitRecommendation((float) ($current['temperature_2m'] ?? 22), $condition['is_rain']),
                    'is_fallback' => false,
                ];
            }
        } catch (Exception $e) {
            Log::warning('Weather API request failed: '.$e->getMessage());
        }

        return [
            'city_key' => $cityKey,
            'city_name' => $city['name'],
            'temperature' => 22.0,
            'apparent_temperature' => 22.5,
            'humidity' => 65,
            'wind_speed' => 9.5,
            'condition' => 'Parcialmente Nublado',
            'icon' => 'fa-cloud-sun',
            'is_rain' => false,
            'recommendation' => $this->getOutfitRecommendation(22.0, false),
            'is_fallback' => true,
        ];
    }

    private function parseWeatherCode(int $code): array
    {
        return match (true) {
            $code === 0 => ['text' => 'Despejado / Soleado', 'icon' => 'fa-sun', 'is_rain' => false],
            $code >= 1 && $code <= 3 => ['text' => 'Parcialmente Nublado', 'icon' => 'fa-cloud-sun', 'is_rain' => false],
            $code >= 45 && $code <= 48 => ['text' => 'Niebla / Neblina', 'icon' => 'fa-smog', 'is_rain' => false],
            $code >= 51 && $code <= 67 => ['text' => 'Lluvia / Llovizna', 'icon' => 'fa-cloud-showers-heavy', 'is_rain' => true],
            $code >= 71 && $code <= 77 => ['text' => 'Nieve', 'icon' => 'fa-snowflake', 'is_rain' => false],
            $code >= 80 && $code <= 82 => ['text' => 'Aguacero', 'icon' => 'fa-cloud-rain', 'is_rain' => true],
            $code >= 95 => ['text' => 'Tormenta Eléctrica', 'icon' => 'fa-bolt', 'is_rain' => true],
            default => ['text' => 'Nublado', 'icon' => 'fa-cloud', 'is_rain' => false],
        };
    }

    private function getOutfitRecommendation(float $temp, bool $isRain): array
    {
        if ($isRain) {
            return [
                'tag' => 'Lluvia Urbana',
                'description' => 'messages.weather_outfit_rain',
                'categories' => ['Busos', 'Pantalones', 'Accesorios'],
            ];
        }

        if ($temp < 18) {
            return [
                'tag' => 'Clima Fresco / Frío',
                'description' => 'messages.weather_outfit_cold',
                'categories' => ['Busos', 'Pantalones'],
            ];
        }

        if ($temp > 25) {
            return [
                'tag' => 'Día Cálido / Soleado',
                'description' => 'messages.weather_outfit_hot',
                'categories' => ['Camisas', 'Accesorios'],
            ];
        }

        return [
            'tag' => 'Clima Templado Ideal',
            'description' => 'messages.weather_outfit_mild',
            'categories' => ['Camisas', 'Pantalones', 'Accesorios'],
        ];
    }
}
