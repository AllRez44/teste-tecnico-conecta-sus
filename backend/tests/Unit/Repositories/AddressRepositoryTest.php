<?php

namespace Tests\Unit\Repositories;

use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AddressRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AddressRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AddressRepository();
    }

    public function test_can_get_all_addresses()
    {
        Address::factory()->count(3)->create();

        $addresses = $this->repository->all();

        $this->assertCount(3, $addresses);
        $this->assertInstanceOf(Collection::class, $addresses);
        $this->assertInstanceOf(Address::class, $addresses->first());
    }

    public function test_can_paginate_addresses()
    {
        Address::factory()->count(15)->create();

        $paginator = $this->repository->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertCount(10, $paginator->items());
        $this->assertEquals(15, $paginator->total());
    }

    public function test_can_paginate_addresses_with_search()
    {
        Address::factory()->create(['street' => 'Main Street']);
        Address::factory()->create(['city' => 'Springfield']);
        Address::factory()->create(['zip_code' => '12345678']);

        $paginatorStreet = $this->repository->paginate(10, 'Main');
        $this->assertCount(1, $paginatorStreet->items());

        $paginatorCity = $this->repository->paginate(10, 'Spring');
        $this->assertCount(1, $paginatorCity->items());
    }

    public function test_can_create_address()
    {
        $data = Address::factory()->make()->toArray();

        $address = $this->repository->create($data);

        $this->assertInstanceOf(Address::class, $address);
        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'street' => $data['street'],
            'zip_code' => $data['zip_code']
        ]);
    }

    public function test_can_update_address()
    {
        $address = Address::factory()->create();
        $data = ['street' => 'Updated Street'];

        $result = $this->repository->update($data, $address->id);

        $this->assertTrue((bool)$result);
        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'street' => 'Updated Street',
        ]);
    }

    public function test_can_delete_address()
    {
        $address = Address::factory()->create();

        $result = $this->repository->delete($address->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('addresses', [
            'id' => $address->id,
        ]);
    }

    public function test_can_find_address()
    {
        $address = Address::factory()->create();

        $found = $this->repository->find($address->id);

        $this->assertInstanceOf(Address::class, $found);
        $this->assertEquals($address->id, $found->id);
    }
}
