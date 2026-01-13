@extends('layouts.app')

@section('title', 'Proizvodi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Proizvodi</h2>
        @if(auth()->user()->canEdit())
            <a href="{{ route('proizvods.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Dodaj proizvod
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($proizvodi as $proizvod)
            <div class="col-md-3 mb-4">
                <div class="card h-100">

                    {{-- Uniformni okvir za sliku --}}
                    <div style="width: 100%; height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset($proizvod->slika ?? 'proizvodi/default.jpg') }}"
                             style="max-width: 100%; max-height: 100%; object-fit: contain;"
                             alt="{{ $proizvod->naziv }}">
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $proizvod->naziv }}</h5>
                        <p class="card-text mb-1">{{ ucfirst($proizvod->tip) }}</p>
                        <p class="card-text mb-1">Cena: {{ number_format($proizvod->cena_po_m2, 2) }} RSD</p>

                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('proizvods.show', $proizvod) }}" class="btn btn-sm btn-outline-primary">Prikaži</a>

                            @if(auth()->user()->canEdit())
                                <div>
                                    <a href="{{ route('proizvods.edit', $proizvod) }}" class="btn btn-sm btn-warning">Izmeni</a>

                                    <form action="{{ route('proizvods.destroy', $proizvod) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Da li ste sigurni?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Izbriši</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
