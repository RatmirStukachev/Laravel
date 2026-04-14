<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Setting;
use App\Models\Page;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        Setting::create(['data_key' => 'contacts', 'data_val' => []]);
        Setting::create(['data_key' => 'content', 'data_val' => []]);
        Setting::create(['data_key' => 'metrics', 'data_val' => []]);
        Setting::create(['data_key' => 'general', 'data_val' => []]);
        Page::create(['title' => 'Home', 'slug' => '/', 'is_active' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
