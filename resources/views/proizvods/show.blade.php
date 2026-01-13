@extends('layouts.app')

@section('title', 'Detalji proizvoda')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $proizvod->naziv }}</h2>
        <a href="{{ route('proizvods.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card mb-4">
        @if($proizvod->slika)
    <img src="{{ asset($proizvod->slika) }}"
         style="width: 100%; max-width: 500px; height: auto; object-fit: contain;"
         alt="{{ $proizvod->naziv }}">
@else
    <img src="{{ asset('proizvodi/default.jpg') }}"
         style="width: 100%; max-width: 500px; height: auto; object-fit: contain;"
         alt="Nema slike">
@endif



        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th>Naziv:</th>
                    <td>{{ $proizvod->naziv }}</td>
                </tr>
                <tr>
                    <th>Opis:</th>
                    <td>{{ $proizvod->opis ?? 'Nema opisa' }}</td>
                </tr>
                <tr>
                    <th>Tip:</th>
                    <td>{{ ucfirst($proizvod->tip) }}</td>
                </tr>
                <tr>
                    <th>Standardna širina:</th>
                    <td>{{ $proizvod->standardna_sirina ?? '-' }} m</td>
                </tr>
                <tr>
                    <th>Standardna visina:</th>
                    <td>{{ $proizvod->standardna_visina ?? '-' }} m</td>
                </tr>
                <tr>
                    <th>Cena po m²:</th>
                    <td>{{ number_format($proizvod->cena_po_m2, 2) }} RSD</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
