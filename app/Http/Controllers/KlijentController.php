<?php

namespace App\Http\Controllers;

use App\Models\Klijent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KlijentController extends Controller
{
    private function checkAdmin()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Niste ulogovani!');
        }

        // SAMO admin i menadžer mogu
        if (!in_array($user->role, ['admin', 'menadzer'])) {
            abort(403, 'Samo administrator i menadžer mogu da pristupe klijentima!');
        }
    }

    private function canEdit()
    {
        $user = Auth::user();
        if (!$user) return false;

        return in_array($user->role, ['admin', 'menadzer']);
    }

    public function index()
    {
        // UKLONI $this->checkAdmin(); // SVI mogu da vide listu!
        $klijents = Klijent::all();
        return view('clients.index', compact('klijents'));
    }

    public function create()
    {
        $this->checkAdmin(); // Samo admin/menadzer
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin(); // Samo admin/menadzer

        $validated = $request->validate([
            'naziv_firme' => 'required|string|max:255',
            'adresa' => 'required|string|max:255',
            'telefon' => 'required|string|max:50',
            'pib' => 'nullable|string|max:20',
            'napomena' => 'nullable|string',
        ]);

        Klijent::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Klijent je uspešno dodat.');
    }

    public function show(Klijent $client)
    {
        // UKLONI $this->checkAdmin(); // SVI mogu da vide detalje!
        return view('clients.show', ['klijent' => $client]);
    }

    public function edit(Klijent $client)
    {
        $this->checkAdmin(); // Samo admin/menadzer
        return view('clients.edit', ['klijent' => $client]);
    }

    public function update(Request $request, Klijent $client)
    {
        $this->checkAdmin(); // Samo admin/menadzer

        $validated = $request->validate([
            'naziv_firme' => 'required|string|max:255',
            'adresa' => 'required|string|max:255',
            'telefon' => 'required|string|max:50',
            'pib' => 'nullable|string|max:20',
            'napomena' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Klijent je uspešno ažuriran.');
    }

    public function destroy(Klijent $client)
    {
        $this->checkAdmin(); // Samo admin/menadzer
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Klijent je uspešno obrisan.');
    }
}
