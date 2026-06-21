<?php

namespace Tests\Unit\Services;

use App\Models\Patient;
use App\Repositories\PatientRepository;
use App\Services\PatientService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\TestCase;

class PatientServiceTest extends TestCase
{
    private PatientRepository $repositoryMock;
    private PatientService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = $this->createMock(PatientRepository::class);
        $this->service = new PatientService($this->repositoryMock);
    }

    public function test_can_get_all_patients()
    {
        $collection = new Collection([new Patient()]);
        $this->repositoryMock->expects($this->once())
            ->method('all')
            ->willReturn($collection);

        $result = $this->service->all();

        $this->assertEquals($collection, $result);
    }

    public function test_can_paginate_patients()
    {
        $paginator = $this->createMock(LengthAwarePaginator::class);
        $this->repositoryMock->expects($this->once())
            ->method('paginate')
            ->with(10, 'search-term')
            ->willReturn($paginator);

        $result = $this->service->paginate(10, 'search-term');

        $this->assertEquals($paginator, $result);
    }

    public function test_can_find_patient()
    {
        $patient = new Patient();
        $this->repositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($patient);

        $result = $this->service->find(1);

        $this->assertEquals($patient, $result);
    }

    public function test_can_store_patient()
    {
        $patient = new Patient();
        $data = ['name' => 'John Doe'];
        $this->repositoryMock->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($patient);

        $result = $this->service->store($data);

        $this->assertEquals($patient, $result);
    }

    public function test_can_update_patient()
    {
        $data = ['name' => 'John Doe'];
        $this->repositoryMock->expects($this->once())
            ->method('update')
            ->with($data, 1)
            ->willReturn(1);

        $result = $this->service->update(1, $data);

        $this->assertEquals(1, $result);
    }

    public function test_can_delete_patient()
    {
        $this->repositoryMock->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $result = $this->service->delete(1);

        $this->assertTrue($result);
    }
}
