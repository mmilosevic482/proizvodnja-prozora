<?php

namespace App\Http\Controllers;

use App\Models\Narudzbina;
use App\Models\Klijent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NarudzbinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // NarudzbinaController.php
public function index(Request $request)
{
    $query = \App\Models\Narudzbina::with('klijent');

    // Filter po statusu
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Pretraga po broju narudžbine ili klijentu
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('broj_narudzbine', 'like', "%{$search}%")
              ->orWhereHas('klijent', function($q2) use ($search) {
                  $q2->where('naziv_firme', 'like', "%{$search}%");
              });
        });
    }

    // Paginacija
    $narudzbine = $query->orderBy('datum_narudzbine', 'desc')->paginate(10)->withQueryString();

    return view('narudzbine.index', compact('narudzbine'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // SAMO OVO - BEZ PROVERE!
    $klijenti = \App\Models\Klijent::all();
    return view('narudzbine.create', compact('klijenti'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Prvo proveri da li je ulogovan
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Provera prava - koristi direktnu proveru role
        if (!($user->role === 'admin' || $user->role === 'menadzer') && $user->role !== 'klijent') {
            abort(403, 'Nemate pravo da kreirate narudžbine!');
        }

        // Validacija
        $validated = $request->validate([
            'klijent_id' => 'required|exists:klijents,id',
            'broj_narudzbine' => 'required|string|max:50|unique:narudzbinas',
            'datum_narudzbine' => 'required|date',
            'rok_isporuke' => 'required|date|after_or_equal:datum_narudzbine',
            'status' => 'required|in:nova,u_obradi,zavrsena,otkazana',
            'ukupna_cena' => 'required|numeric|min:0',
            'napomena' => 'nullable|string',
        ]);

        // Automatski dodeli trenutnog korisnika ako je admin/menadzer
        if ($user->role === 'admin' || $user->role === 'menadzer') {
            $validated['user_id'] = $user->id;
        }

        Narudzbina::create($validated);

        return redirect()->route('narudzbine.index')
            ->with('success', 'Narudžbina je uspešno kreirana.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Narudzbina $narudzbina)
    {
        return view('narudzbine.show', compact('narudzbina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Narudzbina $narudzbina)
    {
        // Prvo proveri da li je ulogovan
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Samo admin/menadzer mogu da uređuju
        if (!($user->role === 'admin' || $user->role === 'menadzer')) {
            abort(403, 'Samo administrator i menadžer mogu da uređuju narudžbine!');
        }

        $klijenti = Klijent::all();
        return view('narudzbine.edit', compact('narudzbina', 'klijenti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Narudzbina $narudzbina)
    {
        // Prvo proveri da li je ulogovan
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Samo admin/menadzer mogu da ažuriraju
        if (!($user->role === 'admin' || $user->role === 'menadzer')) {
            abort(403, 'Samo administrator i menadžer mogu da ažuriraju narudžbine!');
        }

        $validated = $request->validate([
            'klijent_id' => 'required|exists:klijents,id',
            'broj_narudzbine' => 'required|string|max:50|unique:narudzbinas,broj_narudzbine,' . $narudzbina->id,
            'datum_narudzbine' => 'required|date',
            'rok_isporuke' => 'required|date|after_or_equal:datum_narudzbine',
            'status' => 'required|in:nova,u_obradi,zavrsena,otkazana',
            'ukupna_cena' => 'required|numeric|min:0',
            'napomena' => 'nullable|string',
        ]);

        $narudzbina->update($validated);

        return redirect()->route('narudzbine.index')
            ->with('success', 'Narudžbina je uspešno ažurirana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Narudzbina $narudzbina)
    {
        // Prvo proveri da li je ulogovan
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Samo admin/menadzer mogu da brišu
        if (!($user->role === 'admin' || $user->role === 'menadzer')) {
            abort(403, 'Samo administrator i menadžer mogu da brišu narudžbine!');
        }

        $narudzbina->delete();

        return redirect()->route('narudzbine.index')
            ->with('success', 'Narudžbina je uspešno obrisana.');
    }
}
