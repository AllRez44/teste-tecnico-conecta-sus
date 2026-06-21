<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Address::factory()->count(10)->create();
    }

    public function default()
    {
        $defaultAddresses = [
            [
                'street' => 'Av. Paulista, 1000',
                'zip_code' => '01310100',
                'neighborhood' => 'Bela Vista',
                'city' => 'São Paulo',
                'state' => 'SP',
            ],
            [
                'street' => 'Rua das Flores, 250',
                'zip_code' => '30130010',
                'neighborhood' => 'Centro',
                'city' => 'Belo Horizonte',
                'state' => 'MG',
            ],
            [
                'street' => 'Rua XV de Novembro, 80',
                'zip_code' => '80020310',
                'neighborhood' => 'Centro Cívico',
                'city' => 'Curitiba',
                'state' => 'PR',
            ],
            [
                'street' => 'Av. Rio Branco, 45',
                'zip_code' => '20040004',
                'neighborhood' => 'Centro',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
            ],
            [
                'street' => 'Av. Paulista, 1578',
                'zip_code' => '01310200',
                'neighborhood' => 'Bela Vista',
                'city' => 'São Paulo',
                'state' => 'SP',
            ]
        ];

        $created = [];
        foreach ($defaultAddresses as $address) {
            $created[] = \App\Models\Address::firstOrCreate(
                ['zip_code' => $address['zip_code'], 'street' => $address['street']],
                $address
            );
        }

        return $created;
    }
}

