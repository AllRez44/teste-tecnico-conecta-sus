<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\Patient;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_addresses()
    {
        Address::factory()->count(3)->create();

        $response = $this->getJson('/api/addresses');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_address()
    {
        $payload = [
            'name' => 'Casa',
            'street' => 'Rua das Flores',
            'zip_code' => '12345678',
            'neighborhood' => 'Centro',
            'city' => 'São Paulo',
            'state' => 'SP',
        ];

        $response = $this->postJson('/api/addresses', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['street' => 'Rua das Flores']);
        
        $this->assertDatabaseHas('addresses', ['zip_code' => '12345678']);
    }

    public function test_cannot_create_address_with_invalid_zipcode()
    {
        $payload = Address::factory()->make(['zip_code' => '1234567'])->toArray();

        $response = $this->postJson('/api/addresses', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('zip_code');
    }

    public function test_can_update_address()
    {
        $address = Address::factory()->create();

        $payload = [
            'name' => 'Casa Nova',
            'street' => 'Rua Atualizada',
            'zip_code' => '87654321',
            'neighborhood' => 'Bairro Novo',
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
        ];

        $response = $this->putJson("/api/addresses/{$address->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['street' => 'Rua Atualizada']);

        $this->assertDatabaseHas('addresses', ['zip_code' => '87654321']);
    }

    public function test_can_delete_address_without_patients()
    {
        $address = Address::factory()->create();

        $response = $this->deleteJson("/api/addresses/{$address->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function test_cannot_delete_address_with_patients()
    {
        $address = Address::factory()->create();
        // Create patient manually to bypass factory invalid CPF issues if any, or just use factory if it doesn't run validation
        Patient::factory()->create(['address_id' => $address->id]);

        $response = $this->deleteJson("/api/addresses/{$address->id}");

        $response->assertStatus(422);
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    public function test_can_show_address()
    {
        $address = Address::factory()->create();

        $response = $this->getJson("/api/addresses/{$address->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($address->toArray());
    }

    public function test_cannot_show_invalid_address()
    {
        $response = $this->getJson('/api/addresses/999999');

        $response->assertStatus(404);
    }
}
