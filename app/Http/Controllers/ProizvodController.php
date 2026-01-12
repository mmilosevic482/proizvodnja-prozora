<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;

class ProizvodController extends Controller
{
    public function index()
    {
        $proizvodi = Proizvod::where('aktivna', true)->get();
        return view('proizvods.index', compact('proizvodi'));
    }

    public function create()
    {
        return view('proizvods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'tip' => 'required|string|in:pvc,aluminijum,drvo',
            'standardna_sirina' => 'nullable|numeric|min:0',
            'standardna_visina' => 'nullable|numeric|min:0',
            'cena_po_m2' => 'required|numeric|min:0',
        ]);

        $validated['aktivna'] = true;

        Proizvod::create($validated);

        return redirect()->route('proizvods.index')
            ->with('success', 'Proizvod je uspešno dodat.');
    }

    public function show(Proizvod $proizvod)
    {
        return view('proizvods.show', compact('proizvod'));
    }

    public function edit(Proizvod $proizvod)
    {
        return view('proizvods.edit', compact('proizvod'));
    }

    public function update(Request $request, Proizvod $proizvod)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'tip' => 'required|string|in:pvc,aluminijum,drvo',
            'standardna_sirina' => 'nullable|numeric|min:0',
            'standardna_visina' => 'nullable|numeric|min:0',
            'cena_po_m2' => 'required|numeric|min:0',
            'aktivna' => 'boolean',
        ]);

        $proizvod->update($validated);

        return redirect()->route('proizvods.index')
            ->with('success', 'Proizvod je uspešno ažuriran.');
    }

    public function destroy(Proizvod $proizvod)
    {
        $proizvod->update(['aktivna' => false]); // Soft delete

        return redirect()->route('proizvods.index')
            ->with('success', 'Proizvod je deaktiviran.');
    }
}
