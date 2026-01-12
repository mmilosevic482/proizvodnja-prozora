<?php

namespace Database\Factories;

use App\Models\StavkeNarudzbine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProizvodniZadatakFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'stavka_narudzbine_id' => StavkeNarudzbine::factory(),
            'user_id' => User::factory(),
            'operacija' => fake()->word(),
            'datum_pocetka' => fake()->dateTime(),
            'datum_zavrsetka' => fake()->dateTime(),
            'status' => fake()->word(),
            'napomena' => fake()->text(),
        ];
    }
}
