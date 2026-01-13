@extends('layouts.app')

@section('title', 'Detalji klijenta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Klijent: {{ $klijent->naziv_firme }}</h2>
        <div class="d-flex gap-2">
            {{-- Dugme za edit samo ako korisnik može i ruta postoji --}}
            @if(auth()->user()->canEdit() && Route::has('clients.edit'))
                <a href="{{ route('clients.edit', ['klijent' => $klijent->id]) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Izmeni
                </a>
            @endif
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Nazad
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Osnovni podaci</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Naziv firme:</th>
                            <td>{{ $klijent->naziv_firme }}</td>
                        </tr>
                        <tr>
                            <th>Adresa:</th>
                            <td>{{ $klijent->adresa }}</td>
                        </tr>
                        <tr>
                            <th>Telefon:</th>
                            <td>{{ $klijent->telefon }}</td>
                        </tr>
                        <tr>
                            <th>PIB:</th>
                            <td>{{ $klijent->pib ?? 'Nije unet' }}</td>
                        </tr>
                        <tr>
                            <th>Napomena:</th>
                            <td>{{ $klijent->napomena ?? 'Nema napomene' }}</td>
                        </tr>
                        <tr>
                            <th>Datum kreiranja:</th>
                            <td>{{ $klijent->created_at->format('d.m.Y. H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Brze akcije</h5>
                </div>
                <div class="card-body">
                    {{-- Dugme za novu narudžbinu --}}
                    @if(auth()->user()->canEdit() || auth()->user()->role === 'klijent')
                        <a href="{{ route('narudzbine.create') }}?klijent_id={{ $klijent->id }}"
                           class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-plus"></i> Nova narudžbina
                        </a>
                    @endif

                    {{-- Dugme za brisanje samo za admin/menadžer --}}
                    @if(auth()->user()->canEdit() && Route::has('clients.destroy'))
                        <form action="{{ route('clients.destroy', ['klijent' => $klijent->id]) }}" method="POST"
                              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog klijenta?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Obriši klijenta
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
