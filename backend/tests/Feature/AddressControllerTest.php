<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;

class AddressControllerTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function test_can_list_addresses()
  {
    Address::factory()->count(3)->create();

    $response = $this->getJson('/api/addresses');

    $response->assertStatus(200)
      ->assertJsonCount(3, 'data');
  }

  public function test_can_paginate_addresses_per_page()
  {
    Address::factory()->count(5)->create();

    $response = $this->getJson('/api/addresses?per_page=2');

    $response->assertStatus(200)
      ->assertJsonCount(2, 'data');
  }

  public function test_uses_default_pagination_per_page()
  {
    Address::factory()->count(15)->create();

    $response = $this->getJson('/api/addresses');

    $response->assertStatus(200)
      ->assertJsonPath('per_page', 10)
      ->assertJsonCount(10, 'data');
  }

  public function test_can_paginate_addresses_page()
  {
    Address::factory()->count(5)->create();

    $response = $this->getJson('/api/addresses?per_page=3&page=2');

    $response->assertStatus(200)
      ->assertJsonCount(2, 'data')
      ->assertJsonPath('current_page', 2);
  }

  public function test_can_search_addresses()
  {
    Address::factory()->create(['street' => 'Rua de Teste Silva']);
    Address::factory()->create(['street' => 'Avenida Principal']);
    Address::factory()->create(['street' => 'Rua de Teste Santos']);

    $response = $this->getJson('/api/addresses?search=Teste');

    $response->assertStatus(200)
      ->assertJsonCount(2, 'data');
  }

  public function test_can_create_address()
  {
    $payload = [
      'street' => 'Rua das Flores',
      'zip_code' => '12345678',
      'neighborhood' => 'Centro',
      'city' => 'São Paulo',
      'state' => 'SP',
    ];

    Log::shouldReceive('info')
      ->once()
      ->with('Address created successfully', \Mockery::type('array'));

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
      'street' => 'Rua Atualizada',
      'zip_code' => '87654321',
      'neighborhood' => 'Bairro Novo',
      'city' => 'Rio de Janeiro',
      'state' => 'RJ',
    ];

    Log::shouldReceive('info')
      ->once()
      ->with('Address updated successfully', \Mockery::type('array'));

    $response = $this->putJson("/api/addresses/{$address->id}", $payload);

    $response->assertStatus(200)
      ->assertJsonFragment(['street' => 'Rua Atualizada']);

    $this->assertDatabaseHas('addresses', ['zip_code' => '87654321']);
  }

  public function test_can_delete_address_without_patients()
  {
    $address = Address::factory()->create();

    Log::shouldReceive('info')
      ->once()
      ->with('Address deleted successfully', \Mockery::type('array'));

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

  public function test_can_order_addresses()
  {
    Address::factory()->create(['city' => 'Paranapiacaba']);
    Address::factory()->create(['city' => 'Ilhéus']);
    Address::factory()->create(['city' => 'Duque de Caxias']);

    $responseAsc = $this->getJson('/api/addresses?order_by=city&order_dir=asc');
    $responseAsc->assertStatus(200);
    $dataAsc = $responseAsc->json('data');
    $this->assertEquals('Duque de Caxias', $dataAsc[0]['city']);
    $this->assertEquals('Ilhéus', $dataAsc[1]['city']);
    $this->assertEquals('Paranapiacaba', $dataAsc[2]['city']);

    $responseDesc = $this->getJson('/api/addresses?order_by=city&order_dir=desc');
    $responseDesc->assertStatus(200);
    $dataDesc = $responseDesc->json('data');
    $this->assertEquals('Paranapiacaba', $dataDesc[0]['city']);
    $this->assertEquals('Ilhéus', $dataDesc[1]['city']);
    $this->assertEquals('Duque de Caxias', $dataDesc[2]['city']);
  }
}
