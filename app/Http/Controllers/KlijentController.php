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
        if (!$user) abort(403, 'Niste ulogovani!');
        if (!in_array($user->role, ['admin', 'menadzer'])) {
            abort(403, 'Samo administrator i menadžer mogu da pristupe klijentima!');
        }
    }

    public function index()
    {
        $klijents = Klijent::all();
        return view('clients.index', compact('klijents'));
    }

    public function create()
    {
        $this->checkAdmin();
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'naziv_firme' => 'required|string|max:255',
            'adresa' => 'required|string|max:255',
            'telefon' => 'required|string|max:50',
            'pib' => 'nullable|string|max:20',
            'napomena' => 'nullable|string',
        ]);

        Klijent::create($validated);
        return redirect()->route('clients.index')->with('success', 'Klijent je uspešno dodat.');
    }

    public function show(Klijent $klijent)
    {
        return view('clients.show', compact('klijent'));
    }

    public function edit(Klijent $klijent)
    {
        $this->checkAdmin();
        return view('clients.edit', compact('klijent'));
    }

    public function update(Request $request, Klijent $klijent)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'naziv_firme' => 'required|string|max:255',
            'adresa' => 'required|string|max:255',
            'telefon' => 'required|string|max:50',
            'pib' => 'nullable|string|max:20',
            'napomena' => 'nullable|string',
        ]);

        $klijent->update($validated);
        return redirect()->route('clients.index')->with('success', 'Klijent je uspešno ažuriran.');
    }

    public function destroy(Klijent $klijent)
    {
        $this->checkAdmin();
        $klijent->delete();
        return redirect()->route('clients.index')->with('success', 'Klijent je uspešno obrisan.');
    }

    public function canEdit()
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['admin', 'menadzer']);
    }
}
