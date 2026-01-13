<?php

namespace App\Http\Controllers;

use App\Models\Materijal;
use Illuminate\Http\Request;

class MaterijalController extends Controller
{
    // Prikaz svih materijala
    public function index()
    {
        $materijali = Materijal::all(); // Prikaz svih materijala
        return view('materijali.index', compact('materijali'));
    }

    // Forma za kreiranje novog materijala
    public function create()
    {
        return view('materijali.create');
    }

    // Čuvanje novog materijala
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'tip' => 'required|string|max:50',
            'jedinica_mere' => 'nullable|string|max:10',
            'trenutna_kolicina' => 'nullable|numeric|min:0',
            'minimalna_kolicina' => 'nullable|numeric|min:0',
            'cena_po_jedinici' => 'required|numeric|min:0',
            'opis' => 'nullable|string',
            'slika' => 'nullable|string',
        ]);

        Materijal::create($validated);

        return redirect()->route('materijali.index')
            ->with('success', 'Materijal je uspešno dodat.');
    }

    // Prikaz jednog materijala
    public function show(Materijal $materijal)
    {
        return view('materijali.show', compact('materijal'));
    }

    // Forma za izmenu materijala
    public function edit(Materijal $materijal)
    {
        return view('materijali.edit', compact('materijal'));
    }

    // Ažuriranje materijala
    public function update(Request $request, Materijal $materijal)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'tip' => 'required|string|max:50',
            'jedinica_mere' => 'nullable|string|max:10',
            'trenutna_kolicina' => 'nullable|numeric|min:0',
            'minimalna_kolicina' => 'nullable|numeric|min:0',
            'cena_po_jedinici' => 'required|numeric|min:0',
            'opis' => 'nullable|string',
            'slika' => 'nullable|string',
        ]);

        $materijal->update($validated);

        return redirect()->route('materijali.index')
            ->with('success', 'Materijal je uspešno ažuriran.');
    }

    // Brisanje/deaktivacija materijala
    public function destroy(Materijal $materijal)
    {
        $materijal->delete(); // ili ->update(['aktivna' => false]) ako koristiš soft delete

        return redirect()->route('materijali.index')
            ->with('success', 'Materijal je uspešno obrisan.');
    }
}
