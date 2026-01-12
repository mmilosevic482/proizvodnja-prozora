<?php

namespace Database\Factories;

use App\Models\Narudzbine;
use App\Models\Proizvodi;
use Illuminate\Database\Eloquent\Factories\Factory;

class StavkaNarudzbineFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'narudzbina_id' => Narudzbine::factory(),
            'proizvod_id' => Proizvodi::factory(),
            'sirina' => fake()->randomFloat(2, 0, 999.99),
            'visina' => fake()->randomFloat(2, 0, 999.99),
            'kolicina' => fake()->numberBetween(-10000, 10000),
            'boja' => fake()->word(),
            'napomena' => fake()->text(),
            'cena' => fake()->randomFloat(2, 0, 99999999.99),
        ];
    }
}
