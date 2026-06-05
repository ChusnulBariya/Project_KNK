<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Seed categories so / can render without errors
        \App\Models\KategoriKeperluan::create(['nama_kategori' => 'General']);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
