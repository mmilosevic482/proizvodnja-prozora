<?php

namespace App\Http\Controllers;

use App\Models\Narudzbina;
use App\Models\Klijent;
use App\Models\StavkaNarudzbine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NarudzbinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Narudzbina::with('klijent');

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
                      $q2->where('naziv_firme', 'like', "%{$search}%")
                         ->orWhere('adresa', 'like', "%{$search}%")
                         ->orWhere('telefon', 'like', "%{$search}%");
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
        return view('narudzbine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            // Klijent podaci
            'klijent_naziv' => 'required|string|max:255',
            'klijent_adresa' => 'nullable|string|max:500',
            'klijent_telefon' => 'nullable|string|max:50',
            'klijent_pib' => 'nullable|string|max:20',
            'klijent_napomena' => 'nullable|string',

            // Narudžbina podaci
            'broj_narudzbine' => 'required|string|max:50|unique:narudzbinas',
            'datum_narudzbine' => 'required|date',
            'rok_isporuke' => 'required|date|after_or_equal:datum_narudzbine',
            'status' => 'required|in:nova,u_obradi,zavrsena,otkazana',
            'ukupna_cena' => 'required|numeric|min:0',
            'napomena' => 'nullable|string',

            // Prozori validacija
            'prozori' => 'required|array|min:1',
            'prozori.*.tip' => 'required|string|max:50',
            'prozori.*.materijal' => 'required|string|max:50',
            'prozori.*.boja' => 'required|string|max:100',
            'prozori.*.sirina' => 'required|numeric|min:10|max:500',
            'prozori.*.visina' => 'required|numeric|min:10|max:500',
            'prozori.*.kolicina' => 'required|integer|min:1',
            'prozori.*.cena_po_komadu' => 'required|numeric|min:0',
        ]);

        try {
            // 1. Креирај клијента
            $klijent = Klijent::create([
                'naziv_firme' => $validated['klijent_naziv'],
                'adresa' => $validated['klijent_adresa'] ?? null,
                'telefon' => $validated['klijent_telefon'] ?? null,
                'pib' => $validated['klijent_pib'] ?? null,
                'napomena' => $validated['klijent_napomena'] ?? null,
                'user_id' => Auth::id(),
            ]);

            // 2. Креирај наруџбину
            $narudzbina = Narudzbina::create([
                'klijent_id' => $klijent->id,
                'user_id' => Auth::id(),
                'broj_narudzbine' => $validated['broj_narudzbine'],
                'datum_narudzbine' => $validated['datum_narudzbine'],
                'rok_isporuke' => $validated['rok_isporuke'],
                'status' => $validated['status'],
                'ukupna_cena' => $validated['ukupna_cena'],
                'napomena' => $validated['napomena'] ?? null,
            ]);

            // 3. Креирај ставке наруџбине (прозоре)
            foreach ($validated['prozori'] as $stavkaData) {
                StavkaNarudzbine::create([
                    'narudzbina_id' => $narudzbina->id,
                    'proizvod_id' => null,
                    'sirina' => $stavkaData['sirina'],
                    'visina' => $stavkaData['visina'],
                    'kolicina' => $stavkaData['kolicina'],
                    'boja' => $stavkaData['boja'],
                    'napomena' => 'Тип: ' . $stavkaData['tip'] . ', Материјал: ' . $stavkaData['materijal'],
                    'cena' => $stavkaData['cena_po_komadu'] * $stavkaData['kolicina'],
                ]);
            }

            return redirect()->route('narudzbine.index')
                ->with('success', 'Narudžbina je uspešno kreirana.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Došlo je do greшке: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Narudzbina $narudzbina)
    {
        // Учитај клијента
        $narudzbina->load('klijent');

        // Ручно преузимање ставки
        $stavke = StavkaNarudzbine::where('narudzbina_id', $narudzbina->id)->get();

        return view('narudzbine.show', compact('narudzbina', 'stavke'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Narudzbina $narudzbina)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!($user->role === 'admin' || $user->role === 'menadzer')) {
            abort(403, 'Samo administrator i menadžer mogu da uređuju narudžbine!');
        }

        // Ручно преузимање ставки
        $stavke = StavkaNarudzbine::where('narudzbina_id', $narudzbina->id)->get();

        return view('narudzbine.edit', compact('narudzbina', 'stavke'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Narudzbina $narudzbina)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!($user->role === 'admin' || $user->role === 'menadzer')) {
            abort(403, 'Samo administrator i menadžer mogu da ažuriraju narudžbine!');
        }

        $validated = $request->validate([
            // 'klijent_id' => 'required|exists:klijents,id', // ОВО ВИШЕ НЕ ТРЕБА јер се не мења клијент
            'broj_narudzbine' => 'required|string|max:50|unique:narudzbinas,broj_narudzbine,' . $narudzbina->id,
            'datum_narudzbine' => 'required|date',
            'rok_isporuke' => 'required|date|after_or_equal:datum_narudzbine',
            'status' => 'required|in:nova,u_obradi,zavrsena,otkazana',
            'ukupna_cena' => 'required|numeric|min:0',
            'napomena' => 'nullable|string',
        ]);

        // Додај klijent_id из постојеће наруџбине
        $validated['klijent_id'] = $narudzbina->klijent_id;

        $narudzbina->update($validated);

        return redirect()->route('narudzbine.index')
            ->with('success', 'Narudžbina je uspešno ažurirana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Narudzbina $narudzbina)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!($user->role === 'admin' || $user->role === 'menadzer')) {
            abort(403, 'Samo administrator i menadžer mogu da brišu narudžbine!');
        }

        // Обриши ставке ручно
        StavkaNarudzbine::where('narudzbina_id', $narudzbina->id)->delete();

        // Онда обриши наруџбину
        $narudzbina->delete();

        return redirect()->route('narudzbine.index')
            ->with('success', 'Narudžbina je uspešno obrisana.');
    }
}
