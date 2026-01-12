<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterijalFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->word(),
            'tip' => fake()->word(),
            'jedinica_mere' => fake()->word(),
            'trenutna_kolicina' => fake()->randomFloat(2, 0, 99999999.99),
            'minimalna_kolicina' => fake()->randomFloat(2, 0, 99999999.99),
            'cena_po_jedinici' => fake()->randomFloat(2, 0, 999999.99),
        ];
    }
}
