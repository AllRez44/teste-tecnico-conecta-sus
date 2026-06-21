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
            [
                'name' => 'Fernanda Silva',
                'cpf' => '05758452874',
                'cns' => '142784825630001',
                'birth_date' => '1995-05-12',
                'gender' => 'F',
                'phone' => '11988887777',
            ],
            [
                'name' => 'Rafael Costa',
                'cpf' => '26526644333',
                'cns' => '188875422270005',
                'birth_date' => '1982-10-25',
                'gender' => 'M',
                'phone' => '21977776666',
            ],
            [
                'name' => 'Beatriz Santos',
                'cpf' => '50745595537',
                'cns' => '190489771790003',
                'birth_date' => '2001-02-14',
                'gender' => 'F',
                'phone' => '31966665555',
            ],
            [
                'name' => 'Lucas Almeida',
                'cpf' => '91623159350',
                'cns' => '184925614440002',
                'birth_date' => '1979-08-05',
                'gender' => 'M',
                'phone' => '41955554444',
            ],
            [
                'name' => 'Juliana Ferreira',
                'cpf' => '53883126233',
                'cns' => '277921612390008',
                'birth_date' => '1988-12-01',
                'gender' => 'F',
                'phone' => '51944443333',
            ],
            [
                'name' => 'Bruno Rocha',
                'cpf' => '86156664238',
                'cns' => '105187529340006',
                'birth_date' => '1992-04-18',
                'gender' => 'M',
                'phone' => '61933332222',
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
