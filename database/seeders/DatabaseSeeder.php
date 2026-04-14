<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Setting::create(['data_key' => 'contacts', 'data_val' => []]);
        \App\Models\Setting::create(['data_key' => 'content', 'data_val' => []]);
        \App\Models\Setting::create(['data_key' => 'metrics', 'data_val' => []]);
        \App\Models\Setting::create(['data_key' => 'general', 'data_val' => []]);
        \App\Models\Page::create(['title' => 'Home', 'slug' => '/', 'is_active' => true]);
    }
}
