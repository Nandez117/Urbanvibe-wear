<?php

// Esteban Alvarez Garcia

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    use RefreshDatabase;

    public function test_weather_page_is_accessible(): void
    {
        $response = $this->get('/weather');

        $response->assertStatus(200);
    }
}
