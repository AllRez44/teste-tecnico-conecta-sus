<?php

namespace Tests\Unit\Services;

use App\Models\Address;
use App\Models\Patient;
use App\Repositories\AddressRepository;
use App\Services\AddressService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AddressServiceTest extends TestCase
{
    private AddressRepository $repositoryMock;
    private AddressService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = $this->createMock(AddressRepository::class);
        $this->service = new AddressService($this->repositoryMock);
    }

    public function test_can_get_all_addresses()
    {
        $collection = new Collection([new Address()]);
        $this->repositoryMock->expects($this->once())
            ->method('all')
            ->willReturn($collection);

        $result = $this->service->all();

        $this->assertEquals($collection, $result);
    }

    public function test_can_paginate_addresses()
    {
        $paginator = $this->createMock(LengthAwarePaginator::class);
        $this->repositoryMock->expects($this->once())
            ->method('paginate')
            ->with(10, 'search-term')
            ->willReturn($paginator);

        $result = $this->service->paginate(10, 'search-term');

        $this->assertEquals($paginator, $result);
    }

    public function test_can_find_address()
    {
        $address = new Address();
        $this->repositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($address);

        $result = $this->service->find(1);

        $this->assertEquals($address, $result);
    }

    public function test_can_store_address()
    {
        $address = new Address();
        $data = ['street' => 'Main Street'];
        $this->repositoryMock->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($address);

        $result = $this->service->store($data);

        $this->assertEquals($address, $result);
    }

    public function test_can_update_address()
    {
        $data = ['street' => 'Main Street'];
        $this->repositoryMock->expects($this->once())
            ->method('update')
            ->with($data, 1)
            ->willReturn(1);

        $result = $this->service->update(1, $data);

        $this->assertEquals(1, $result);
    }

    public function test_can_delete_address()
    {
        $addressMock = $this->getMockBuilder(Address::class)
            ->onlyMethods(['patients'])
            ->getMock();

        $patientsRelationMock = $this->getMockBuilder(\Illuminate\Database\Eloquent\Relations\HasMany::class)
            ->disableOriginalConstructor()
            ->addMethods(['count'])
            ->getMock();

        $patientsRelationMock->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $addressMock->expects($this->once())
            ->method('patients')
            ->willReturn($patientsRelationMock);

        $this->repositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($addressMock);

        $this->repositoryMock->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $result = $this->service->delete(1);

        $this->assertTrue($result);
    }

    public function test_cannot_delete_address_with_patients()
    {
        $addressMock = $this->getMockBuilder(Address::class)
            ->onlyMethods(['patients'])
            ->getMock();

        $patientsRelationMock = $this->getMockBuilder(\Illuminate\Database\Eloquent\Relations\HasMany::class)
            ->disableOriginalConstructor()
            ->addMethods(['count'])
            ->getMock();

        $patientsRelationMock->expects($this->once())
            ->method('count')
            ->willReturn(1);

        $addressMock->expects($this->once())
            ->method('patients')
            ->willReturn($patientsRelationMock);

        $this->repositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($addressMock);

        $this->repositoryMock->expects($this->never())
            ->method('delete');

        $this->expectException(ValidationException::class);

        $this->service->delete(1);
    }
}
