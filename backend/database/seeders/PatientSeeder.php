<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Patient::factory()->count(10)->create();
    }

    public function default(array $addresses = [])
    {
        $defaultPatients = [
            [
                'name' => 'Maria da Silva',
                'cpf' => '12345678901',
                'cns' => '123456789012345',
                'birth_date' => '1985-03-15',
                'gender' => 'F',
                'phone' => null,
            ],
            [
                'name' => 'João Carlos Oliveira',
                'cpf' => '98765432100',
                'cns' => '987654321098765',
                'birth_date' => '1972-07-22',
                'gender' => 'M',
                'phone' => null,
            ],
            [
                'name' => 'Ana Paula Rodrigues',
                'cpf' => '45678912300',
                'cns' => '456789123004567',
                'birth_date' => '1990-11-08',
                'gender' => 'F',
                'phone' => null,
            ],
            [
                'name' => 'Carlos E. Mendes',
                'cpf' => '32165498700',
                'cns' => '321654987003216',
                'birth_date' => '1968-01-30',
                'gender' => 'M',
                'phone' => null,
            ],
        ];
        foreach ($defaultPatients as $index => $patient) {
            $addressId = isset($addresses[$index]) ? $addresses[$index]->id : (\App\Models\Address::first()->id ?? null);
            $patient['address_id'] = $addressId;
            \App\Models\Patient::firstOrCreate(
                ['cpf' => $patient['cpf']],
                $patient
            );
        }
    }
}
