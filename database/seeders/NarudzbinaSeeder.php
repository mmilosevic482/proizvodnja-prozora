<?php

namespace Database\Seeders;

use App\Models\Narudzbina;
use App\Models\Klijent;
use App\Models\User;
use Illuminate\Database\Seeder;

class NarudzbinaSeeder extends Seeder
{
    public function run(): void
    {
        // Провери да ли већ постоје наруџбине
        if (Narudzbina::count() > 0) {
            $this->command->info('ℹ️  Narudzbine već postoje u bazi. Preskačem seeding.');
            return;
        }

        $klijenti = Klijent::all();
        if ($klijenti->isEmpty()) {
            $this->command->warn('⚠️  Nema klijenata! Prvo pokreni KlijentSeeder.');
            return;
        }

        // Користи постојеће кориснике или креирај подразумеваног
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Seeder User',
                'email' => 'seeder@example.com',
                'password' => bcrypt('password'),
                'role' => 'radnik'
            ]);
        }

        // Креирај наруџбине за сваког клијента
        foreach ($klijenti as $index => $klijent) {
            for ($i = 1; $i <= 3; $i++) {
                $brojNar = 'NAR-' . ($klijent->id) . '-' . $i . '-' . rand(100000, 999999);
                $statusi = ['nova', 'u_obradi', 'zavrsena'];

                Narudzbina::create([
                    'klijent_id' => $klijent->id,
                    'user_id' => $user->id,
                    'broj_narudzbine' => $brojNar,
                    'datum_narudzbine' => now()->subDays(rand(1, 30)),
                    'rok_isporuke' => now()->addDays(rand(10, 60)),
                    'status' => $statusi[array_rand($statusi)],
                    'ukupna_cena' => rand(15000, 100000),
                    'napomena' => "Test narudžbina $i za {$klijent->naziv_firme}",
                ]);
            }
        }

        $this->command->info('✅ NarudzbinaSeeder uspešno pokrenut! Kreirano ' . Narudzbina::count() . ' narudžbina.');
    }
}
