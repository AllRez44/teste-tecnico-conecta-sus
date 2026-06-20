<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\Patient;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_show_dashboard_summary()
    {
        Address::factory()->count(3)->create();
        Patient::factory()->count(4)->create();

        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_addresses',
                'total_patients',
            ])
            ->assertJsonFragment([
                'total_addresses' => 7, // 4 created with patient factory + 3 created with address factory
                'total_patients' => 4,
            ]);
    }
}
