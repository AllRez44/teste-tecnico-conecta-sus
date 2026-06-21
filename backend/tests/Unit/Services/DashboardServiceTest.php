<?php

namespace Tests\Unit\Services;

use App\Repositories\AddressRepository;
use App\Repositories\PatientRepository;
use App\Services\DashboardService;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class DashboardServiceTest extends TestCase
{
    private AddressRepository $addressRepositoryMock;
    private PatientRepository $patientRepositoryMock;
    private DashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->addressRepositoryMock = $this->createMock(AddressRepository::class);
        $this->patientRepositoryMock = $this->createMock(PatientRepository::class);
        $this->service = new DashboardService($this->addressRepositoryMock, $this->patientRepositoryMock);
    }

    public function test_can_get_summary()
    {
        $addressCollectionMock = $this->createMock(Collection::class);
        $addressCollectionMock->expects($this->once())
            ->method('count')
            ->willReturn(10);

        $this->addressRepositoryMock->expects($this->once())
            ->method('all')
            ->willReturn($addressCollectionMock);

        $patientCollectionMock = $this->createMock(Collection::class);
        $patientCollectionMock->expects($this->once())
            ->method('count')
            ->willReturn(25);

        $this->patientRepositoryMock->expects($this->once())
            ->method('all')
            ->willReturn($patientCollectionMock);

        $summary = $this->service->getSummary();

        $this->assertIsArray($summary);
        $this->assertArrayHasKey('total_addresses', $summary);
        $this->assertArrayHasKey('total_patients', $summary);
        $this->assertEquals(10, $summary['total_addresses']);
        $this->assertEquals(25, $summary['total_patients']);
    }
}
