<?php

namespace App\Http\Controllers;

use App\Models\Klijent;
use App\Models\Narudzbina;
use App\Models\Proizvod;
use App\Models\ProizvodniZadatak;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'klijenti' => Klijent::count(),
            'proizvodi' => Proizvod::where('aktivna', true)->count(),
            'narudzbine' => Narudzbina::whereIn('status', ['nova', 'u_obradi'])->count(),
            'zadaci' => ProizvodniZadatak::where('status', 'na_cekanju')->count(),
            'ukupna_vrednost' => Narudzbina::where('status', '!=', 'otkazana')->sum('ukupna_cena'),
        ];

        $poslednje_narudzbine = Narudzbina::with('klijent')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'poslednje_narudzbine'));
    }
}
