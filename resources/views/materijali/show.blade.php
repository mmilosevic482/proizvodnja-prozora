@extends('layouts.app')

@section('title', 'Detalji materijala')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $materijal->naziv }}</h2>
        <a href="{{ route('materijali.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card mb-4 shadow-sm">
        {{-- Slika materijala --}}
        <img src="{{ asset($materijal->slika ?? 'materijalii/default.jpg') }}"
             class="card-img-top"
             style="width: 100%; max-width: 500px; height: auto; object-fit: contain;"
             alt="{{ $materijal->naziv }}">

        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th>Naziv:</th>
                    <td>{{ $materijal->naziv }}</td>
                </tr>
                <tr>
                    <th>Opis:</th>
                    <td>{{ $materijal->opis ?? 'Nema opisa' }}</td>
                </tr>
                <tr>
                    <th>Tip:</th>
                    <td>{{ $materijal->tip }}</td>
                </tr>
                <tr>
                    <th>Jedinica mere:</th>
                    <td>{{ $materijal->jedinica_mere }}</td>
                </tr>
                <tr>
                    <th>Trenutna količina:</th>
                    <td>{{ $materijal->trenutna_kolicina }}</td>
                </tr>
                <tr>
                    <th>Minimalna količina:</th>
                    <td>{{ $materijal->minimalna_kolicina }}</td>
                </tr>
                <tr>
                    <th>Cena po jedinici:</th>
                    <td>{{ number_format($materijal->cena_po_jedinici, 2) }} RSD</td>
                </tr>
            </table>

            {{-- Dugmad za admin/menadžer --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'menadzer')
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('materijali.edit', $materijal) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Izmeni
                    </a>
                    <form action="{{ route('materijali.destroy', $materijal) }}" method="POST"
                          onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj materijal?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Obriši
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
