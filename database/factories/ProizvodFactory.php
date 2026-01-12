<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProizvodFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->word(),
            'opis' => fake()->text(),
            'tip' => fake()->word(),
            'standardna_sirina' => fake()->randomFloat(2, 0, 999.99),
            'standardna_visina' => fake()->randomFloat(2, 0, 999.99),
            'cena_po_m2' => fake()->randomFloat(2, 0, 999999.99),
            'aktivna' => fake()->boolean(),
        ];
    }
}
