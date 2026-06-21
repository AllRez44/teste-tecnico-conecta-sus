<?php

namespace Tests\Unit\Repositories;

use App\Models\Patient;
use App\Models\Address;
use App\Repositories\PatientRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PatientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PatientRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PatientRepository();
    }

    public function test_can_get_all_patients()
    {
        Patient::factory()->count(3)->create();

        $patients = $this->repository->all();

        $this->assertCount(3, $patients);
        $this->assertInstanceOf(Collection::class, $patients);
        $this->assertInstanceOf(Patient::class, $patients->first());
    }

    public function test_can_paginate_patients()
    {
        Patient::factory()->count(15)->create();

        $paginator = $this->repository->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertCount(10, $paginator->items());
        $this->assertEquals(15, $paginator->total());
    }

    public function test_can_paginate_patients_with_search()
    {
        Patient::factory()->create(['name' => 'John Doe']);
        Patient::factory()->create(['name' => 'Jane Smith']);
        Patient::factory()->create(['cpf' => '12345678901']);

        $paginatorName = $this->repository->paginate(10, 'John');
        $this->assertCount(1, $paginatorName->items());

        $paginatorCpf = $this->repository->paginate(10, '123456789');
        $this->assertCount(1, $paginatorCpf->items());
    }

    public function test_can_create_patient()
    {
        $address = Address::factory()->create();
        $data = Patient::factory()->make(['address_id' => $address->id])->toArray();

        $patient = $this->repository->create($data);

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'name' => $data['name'],
            'cpf' => $data['cpf']
        ]);
    }

    public function test_can_update_patient()
    {
        $patient = Patient::factory()->create();
        $data = ['name' => 'Updated Name'];

        $result = $this->repository->update($data, $patient->id);

        $this->assertTrue((bool)$result);
        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_can_delete_patient()
    {
        $patient = Patient::factory()->create();

        $result = $this->repository->delete($patient->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('patients', [
            'id' => $patient->id,
        ]);
    }

    public function test_can_find_patient()
    {
        $patient = Patient::factory()->create();

        $found = $this->repository->find($patient->id);

        $this->assertInstanceOf(Patient::class, $found);
        $this->assertEquals($patient->id, $found->id);
    }
}
