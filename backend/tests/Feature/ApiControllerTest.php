<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    public function test_api()
    {
        $response = $this->getJson('/api/');

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'ok',
            ]);
    }
}
