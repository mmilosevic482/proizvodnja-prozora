<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Klijent;
use App\Models\Proizvod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KREIRAJ KORISNIKE
        User::create([
            'name' => 'Admin',
            'email' => 'admin@prozori.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Menadžer',
            'email' => 'menadzer@prozori.com',
            'password' => Hash::make('menadzer123'),
            'role' => 'menadzer'
        ]);

        User::create([
            'name' => 'Običan Korisnik',
            'email' => 'korisnik@prozori.com',
            'password' => Hash::make('korisnik123'),
            'role' => 'radnik'
        ]);

        User::create([
            'name' => 'Klijent Firma',
            'email' => 'klijent@firma.com',
            'password' => Hash::make('klijent123'),
            'role' => 'klijent'
        ]);

        // 2. KREIRAJ KLIJENTE
        Klijent::create([
            'naziv_firme' => 'Gradevinska firma "Zidar"',
            'adresa' => 'Beograd, Kneza Miloša 15',
            'telefon' => '011 123 456',
            'pib' => '123456789'
        ]);

        Klijent::create([
            'naziv_firme' => 'Hotel "Panorama"',
            'adresa' => 'Novi Sad, Fruškogorska 25',
            'telefon' => '021 987 654',
            'pib' => '987654321'
        ]);

        // 3. KREIRAJ PROIZVODE
        Proizvod::create([
            'naziv' => 'PVC prozor - klasičan',
            'opis' => 'Standardni PVC prozor sa dvojnim staklom',
            'tip' => 'pvc',
            'standardna_sirina' => 120.0,
            'standardna_visina' => 150.0,
            'cena_po_m2' => 18500.00,
            'aktivna' => true
        ]);

        Proizvod::create([
            'naziv' => 'Aluminijumski prozor',
            'opis' => 'Moderan aluminijumski prozor sa termo prekidom',
            'tip' => 'aluminijum',
            'standardna_sirina' => 140.0,
            'standardna_visina' => 160.0,
            'cena_po_m2' => 28500.00,
            'aktivna' => true
        ]);

        Proizvod::create([
            'naziv' => 'Drveni prozor',
            'opis' => 'Kvalitetan drveni prozor sa zaštitnim premazom',
            'tip' => 'drvo',
            'standardna_sirina' => 100.0,
            'standardna_visina' => 120.0,
            'cena_po_m2' => 32500.00,
            'aktivna' => true
        ]);

        $this->command->info('✅ Seed podaci uspešno kreirani!');
        $this->command->info('👑 Admin: admin@prozori.com / admin123');
        $this->command->info('👨‍💼 Menadžer: menadzer@prozori.com / menadzer123');
        $this->command->info('👷 Radnik: korisnik@prozori.com / korisnik123');
        $this->command->info('👤 Klijent: klijent@firma.com / klijent123');
    }
}
