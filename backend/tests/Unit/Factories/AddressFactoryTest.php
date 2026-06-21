<?php

namespace Tests\Unit\Factories;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_address_using_factory()
    {
        $address = Address::factory()->create();

        $this->assertInstanceOf(Address::class, $address);
        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'street' => $address->street,
            'zip_code' => $address->zip_code,
            'neighborhood' => $address->neighborhood,
            'city' => $address->city,
            'state' => $address->state,
        ]);
    }

    public function test_can_make_address_using_factory()
    {
        $address = Address::factory()->make();

        $this->assertInstanceOf(Address::class, $address);
        $this->assertNotNull($address->street);
        $this->assertNotNull($address->zip_code);
        $this->assertNotNull($address->neighborhood);
        $this->assertNotNull($address->city);
        $this->assertNotNull($address->state);
    }
}
