<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;

class KatalogController extends Controller
{
    // JAVNI KATALOG - za sve korisnike
    public function index()
    {
        $proizvodi = Proizvod::where('aktivna', true)->get();
        return view('katalog.index', compact('proizvodi'));
    }

    public function show(Proizvod $proizvod)
    {
        if (!$proizvod->aktivna) {
            abort(404);
        }

        return view('katalog.show', compact('proizvod'));
    }
}
