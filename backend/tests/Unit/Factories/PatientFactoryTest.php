<?php

namespace Tests\Unit\Factories;

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_patient_using_factory()
    {
        $patient = Patient::factory()->create();

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'name' => $patient->name,
            'cpf' => $patient->cpf,
            'cns' => $patient->cns,
            'birth_date' => $patient->birth_date,
            'gender' => $patient->gender,
            'address_id' => $patient->address_id,
        ]);
    }

    public function test_can_make_patient_using_factory()
    {
        $patient = Patient::factory()->make();

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertNotNull($patient->name);
        $this->assertNotNull($patient->cpf);
        $this->assertNotNull($patient->cns);
    }
}
