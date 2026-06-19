<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\Patient;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function generateValidCpf() {
        static $index = 0;
        $cpfs = ['23003461257', '91702617092', '90937949302', '27898180453', '66673471069'];
        return $cpfs[$index++ % 5];
    }

    private function generateValidCns() {
        static $index = 0;
        $cnss = ['139601157440009', '253512978680007', '255869066380007', '258950146530000', '189917287680009'];
        return $cnss[$index++ % 5];
    }

    public function test_can_list_patients()
    {
        $address = Address::factory()->create();
        Patient::factory()->count(3)->create([
            'address_id' => $address->id,
            'cpf' => function() { return $this->generateValidCpf(); },
            'cns' => function() { return $this->generateValidCns(); },
        ]);

        $response = $this->getJson('/api/patients');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_patient()
    {
        $address = Address::factory()->create();

        $payload = [
            'name' => 'John Doe',
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
            'birth_date' => '1990-01-01',
            'gender' => 'M',
            'phone' => '11999999999',
            'address_id' => $address->id,
        ];

        $response = $this->postJson('/api/patients', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'John Doe']);
        
        $this->assertDatabaseHas('patients', ['name' => 'John Doe']);
    }

    public function test_cannot_create_patient_with_invalid_cpf()
    {
        $address = Address::factory()->create();

        $payload = [
            'name' => 'John Doe',
            'cpf' => '11111111111', // Invalid
            'cns' => $this->generateValidCns(),
            'birth_date' => '1990-01-01',
            'gender' => 'M',
            'phone' => '11999999999',
            'address_id' => $address->id,
        ];

        $response = $this->postJson('/api/patients', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('cpf');
    }

    public function test_cannot_create_patient_with_invalid_cns()
    {
        $address = Address::factory()->create();

        $payload = [
            'name' => 'John Doe',
            'cpf' => $this->generateValidCpf(),
            'cns' => '111111111111111', // Invalid
            'birth_date' => '1990-01-01',
            'gender' => 'M',
            'phone' => '11999999999',
            'address_id' => $address->id,
        ];

        $response = $this->postJson('/api/patients', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('cns');
    }

    public function test_cannot_create_patient_with_future_birth_date()
    {
        $address = Address::factory()->create();

        $payload = [
            'name' => 'John Doe',
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
            'birth_date' => now()->addDays(2)->format('Y-m-d'), // Invalid
            'gender' => 'M',
            'phone' => '11999999999',
            'address_id' => $address->id,
        ];

        $response = $this->postJson('/api/patients', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('birth_date');
    }

    public function test_can_update_patient()
    {
        $address = Address::factory()->create();
        $patient = Patient::factory()->create([
            'address_id' => $address->id,
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
        ]);

        $payload = [
            'name' => 'Jane Doe',
            'cpf' => $patient->cpf, // Keep same to test unique ignore
            'cns' => $patient->cns,
            'birth_date' => '1992-02-02',
            'gender' => 'F',
            'phone' => '21988888888',
            'address_id' => $address->id,
        ];

        $response = $this->putJson("/api/patients/{$patient->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Jane Doe']);
    }

    public function test_cannot_update_patient_with_invalid_cpf()
    {
        $address = Address::factory()->create();
        $patient = Patient::factory()->create([
            'address_id' => $address->id,
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
        ]);

        $payload = [
            'name' => 'Jane Doe',
            'cpf' => '11111111111', // Invalid
            'cns' => $patient->cns,
            'birth_date' => '1992-02-02',
            'gender' => 'F',
            'phone' => '21988888888',
            'address_id' => $address->id,
        ];

        $response = $this->putJson("/api/patients/{$patient->id}", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('cpf');
    }

    public function test_cannot_update_patient_with_invalid_cns()
    {
        $address = Address::factory()->create();
        $patient = Patient::factory()->create([
            'address_id' => $address->id,
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
        ]);

        $payload = [
            'name' => 'Jane Doe',
            'cpf' => $patient->cpf,
            'cns' => '111111111111111', // Invalid
            'birth_date' => '1992-02-02',
            'gender' => 'F',
            'phone' => '21988888888',
            'address_id' => $address->id,
        ];

        $response = $this->putJson("/api/patients/{$patient->id}", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('cns');
    }

    public function test_can_delete_patient()
    {
        $address = Address::factory()->create();
        $patient = Patient::factory()->create([
            'address_id' => $address->id,
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
        ]);

        $response = $this->deleteJson("/api/patients/{$patient->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }

    public function test_can_show_patient()
    {
        $address = Address::factory()->create();
        $patient = Patient::factory()->create([
            'address_id' => $address->id,
            'cpf' => $this->generateValidCpf(),
            'cns' => $this->generateValidCns(),
        ]);

        $response = $this->getJson("/api/patients/{$patient->id}");

        $response->assertStatus(200)
            ->assertJsonFragment($patient->toArray());
    }

    public function test_cannot_show_invalid_patient()
    {
        $response = $this->getJson('/api/patients/999999');

        $response->assertStatus(404);
    }
}
