@extends('layouts.app')

@section('title', 'Materijali')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Materijali</h2>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'menadzer')
            <a href="{{ route('materijali.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Dodaj materijal
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($materijali as $materijal)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    {{-- Slika --}}
                    <img src="{{ asset($materijal->slika ?? 'materijalii/default.jpg') }}"
                         class="card-img-top" style="width: 100%; height: 200px; object-fit: contain;"
                         alt="{{ $materijal->naziv }}">

                    <div class="card-body d-flex flex-column">
                        {{-- Naziv --}}
                        <h5 class="card-title">{{ $materijal->naziv }}</h5>

                        {{-- Opis i karakteristike --}}
                        <p class="card-text" style="flex: 1;">
                            {{ $materijal->opis ?? 'Nema opisa' }}<br>
                            <strong>Tip:</strong> {{ $materijal->tip }}<br>
                            <strong>Jedinica:</strong> {{ $materijal->jedinica_mere }}<br>
                            <strong>Količina:</strong> {{ $materijal->trenutna_kolicina }}<br>
                            <strong>Minimalno:</strong> {{ $materijal->minimalna_kolicina }}<br>
                            <strong>Cena:</strong> {{ number_format($materijal->cena_po_jedinici, 2) }} RSD
                        </p>

                        {{-- CRUD dugmad --}}
                        <div class="mt-auto d-flex gap-2 flex-wrap">
                            <a href="{{ route('materijali.show', $materijal) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Pregled
                            </a>

                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'menadzer')
                                <a href="{{ route('materijali.edit', $materijal) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Izmeni
                                </a>

                                <form action="{{ route('materijali.destroy', $materijal) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj materijal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Obriši
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Opcionalno dugme Dodaj u korpu (svi korisnici) --}}
                        <a href="#" class="btn btn-success btn-sm mt-2">Dodaj u korpu</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
