<?php

// Yan Frank Ríos López

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_products_page_is_accessible(): void
    {
        $response = $this->get('/partner-products');

        $response->assertStatus(200);
    }
}
