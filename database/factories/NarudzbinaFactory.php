<?php

namespace Database\Factories;

use App\Models\Klijenti;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NarudzbinaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'klijent_id' => Klijenti::factory(),
            'user_id' => User::factory(),
            'broj_narudzbine' => fake()->word(),
            'datum_narudzbine' => fake()->date(),
            'rok_isporuke' => fake()->date(),
            'status' => fake()->word(),
            'ukupna_cena' => fake()->randomFloat(2, 0, 99999999.99),
            'napomena' => fake()->text(),
        ];
    }
}
