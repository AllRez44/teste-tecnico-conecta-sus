<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'cns' => $this->faker->unique()->numerify('###############'),
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['M', 'F', 'O']),
            'phone' => $this->faker->optional()->numerify('###########'),
            'address_id' => \App\Models\Address::factory(),
        ];
    }
}
