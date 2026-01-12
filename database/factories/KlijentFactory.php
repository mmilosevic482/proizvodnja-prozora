<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KlijentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'naziv_firme' => fake()->word(),
            'adresa' => fake()->word(),
            'telefon' => fake()->word(),
            'pib' => fake()->word(),
            'napomena' => fake()->text(),
        ];
    }
}
