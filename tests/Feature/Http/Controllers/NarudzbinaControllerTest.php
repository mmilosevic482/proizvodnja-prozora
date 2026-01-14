<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Klijent;
use App\Models\Narudzbina;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class NarudzbinaControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ulogovani_korisnik_moze_kreirati_narudzbinu()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'korisnik',
        ]);

        $this->actingAs($user);

        $narudzbinaData = [
            'klijent_naziv' => 'Test Firma DOO',
            'klijent_adresa' => 'Test adresa 123',
            'klijent_telefon' => '+381 11 123456',
            'klijent_pib' => '123456789',
            'broj_narudzbine' => 'NAR-TEST-001',
            'datum_narudzbine' => now()->format('Y-m-d'),
            'rok_isporuke' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'nova',
            'ukupna_cena' => 2500,
            'napomena' => 'Test narudžbina',

            'prozori' => [
                [
                    'tip' => 'Dvokrilni',
                    'materijal' => 'PVC',
                    'boja' => 'Bela',
                    'sirina' => 120,
                    'visina' => 150,
                    'kolicina' => 2,
                    'cena_po_komadu' => 1250,
                ]
            ]
        ];

        $response = $this->post(route('narudzbine.store'), $narudzbinaData);

        $response->assertRedirect();

        $this->assertDatabaseHas('narudzbinas', [
            'broj_narudzbine' => 'NAR-TEST-001',
            'ukupna_cena' => 2500,
        ]);

        $this->assertDatabaseHas('klijents', [
            'naziv_firme' => 'Test Firma DOO',
        ]);
    }

    /** @test */
    public function neulogovani_korisnik_ne_moze_kreirati_narudzbinu()
    {
        $narudzbinaData = [
            'klijent_naziv' => 'Test Firma',
            'broj_narudzbine' => 'NAR-TEST-002',
            'datum_narudzbine' => now()->format('Y-m-d'),
            'rok_isporuke' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'nova',
            'ukupna_cena' => 1000,
            'prozori' => [
                [
                    'tip' => 'Jednokrilni',
                    'materijal' => 'Aluminijum',
                    'boja' => 'Siva',
                    'sirina' => 100,
                    'visina' => 120,
                    'kolicina' => 1,
                    'cena_po_komadu' => 1000,
                ]
            ]
        ];

        $response = $this->post(route('narudzbine.store'), $narudzbinaData);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function moze_se_videti_lista_narudzbina()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'list@example.com',
            'password' => Hash::make('password'),
            'role' => 'korisnik',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('narudzbine.index'));

        $response->assertOk();
    }

    /** @test */
    public function admin_moze_kreirati_narudzbinu_sa_jos_podataka()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $narudzbinaData = [
            'klijent_naziv' => 'Admin Firma DOO',
            'klijent_adresa' => 'Admin adresa 456',
            'klijent_telefon' => '+381 11 654321',
            'klijent_pib' => '987654321',
            'broj_narudzbine' => 'NAR-ADMIN-001',
            'datum_narudzbine' => now()->format('Y-m-d'),
            'rok_isporuke' => now()->addDays(15)->format('Y-m-d'),
            'status' => 'u_obradi',
            'ukupna_cena' => 5000,
            'napomena' => 'Hitna narudžbina',

            'prozori' => [
                [
                    'tip' => 'Trojkrilni',
                    'materijal' => 'Drvo',
                    'boja' => 'Braon',
                    'sirina' => 180,
                    'visina' => 200,
                    'kolicina' => 1,
                    'cena_po_komadu' => 5000,
                ]
            ]
        ];

        $response = $this->post(route('narudzbine.store'), $narudzbinaData);

        $response->assertRedirect();

        $this->assertDatabaseHas('narudzbinas', [
            'broj_narudzbine' => 'NAR-ADMIN-001',
            'status' => 'u_obradi',
            'ukupna_cena' => 5000,
        ]);

        $this->assertDatabaseHas('klijents', [
            'naziv_firme' => 'Admin Firma DOO',
            'pib' => '987654321',
        ]);
    }
}
