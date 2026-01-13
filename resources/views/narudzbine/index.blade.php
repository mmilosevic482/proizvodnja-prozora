@extends('layouts.app')

@section('title', 'Narudžbine')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Narudžbine</h2>
        @if(auth()->user()->canEdit() || auth()->user()->role === 'klijent')
            <a href="{{ route('narudzbine.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nova narudžbina
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Filteri -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="btn-group" role="group">
                        <a href="{{ route('narudzbine.index') }}"
                           class="btn btn-outline-secondary {{ !request('status') ? 'active' : '' }}">
                            Sve narudžbine
                        </a>
                        <a href="{{ route('narudzbine.index', ['status' => 'nova']) }}"
                           class="btn btn-outline-secondary {{ request('status') == 'nova' ? 'active' : '' }}">
                            Nove
                        </a>
                        <a href="{{ route('narudzbine.index', ['status' => 'u_obradi']) }}"
                           class="btn btn-outline-secondary {{ request('status') == 'u_obradi' ? 'active' : '' }}">
                            U obradi
                        </a>
                        <a href="{{ route('narudzbine.index', ['status' => 'zavrsena']) }}"
                           class="btn btn-outline-secondary {{ request('status') == 'zavrsena' ? 'active' : '' }}">
                            Završene
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('narudzbine.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2"
                               placeholder="Pretraga po broju ili klijentu..."
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            @if($narudzbine->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Broj narudžbine</th>
                                <th>Klijent</th>
                                <th>Datum</th>
                                <th>Rok isporuke</th>
                                <th>Status</th>
                                <th>Vrednost</th>
                                <th>Akcije</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($narudzbine as $narudzbina)
                            <tr>
                                <td>{{ $narudzbina->id }}</td>
                                <td>
                                    <strong>{{ $narudzbina->broj_narudzbine ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    @if($narudzbina->klijent)
                                        {{ $narudzbina->klijent->naziv_firme }}
                                    @else
                                        <span class="text-muted">Nepoznato</span>
                                    @endif
                                </td>
                                <td>
                                    @if($narudzbina->datum_narudzbine)
                                        {{ \Carbon\Carbon::parse($narudzbina->datum_narudzbine)->format('d.m.Y.') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($narudzbina->rok_isporuke)
                                        @php
                                            $rok = \Carbon\Carbon::parse($narudzbina->rok_isporuke);
                                            $today = \Carbon\Carbon::today();
                                            $isLate = $rok->lt($today) && $narudzbina->status != 'zavrsena';
                                        @endphp
                                        <span class="{{ $isLate ? 'text-danger fw-bold' : '' }}">
                                            {{ $rok->format('d.m.Y.') }}
                                            @if($isLate)
                                                <br><small class="text-danger">(Kasni)</small>
                                            @endif
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'nova' => 'warning',
                                            'u_obradi' => 'primary',
                                            'zavrsena' => 'success',
                                            'otkazana' => 'danger'
                                        ];
                                        $color = $statusColors[$narudzbina->status] ?? 'secondary';
                                        $statusText = [
                                            'nova' => 'Nova',
                                            'u_obradi' => 'U obradi',
                                            'zavrsena' => 'Završena',
                                            'otkazana' => 'Otkazana'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $color }}">
                                        {{ $statusText[$narudzbina->status] ?? $narudzbina->status }}
                                    </span>
                                </td>
                                <td>
                                    {{ number_format($narudzbina->ukupna_cena, 2) }} RSD
                                </td>
                                <td>
                                    <a href="{{ route('narudzbine.show', $narudzbina) }}"
                                       class="btn btn-sm btn-info" title="Pregled">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if(auth()->user()->canEdit())
                                        <a href="{{ route('narudzbine.edit', $narudzbina) }}"
                                           class="btn btn-sm btn-warning" title="Izmeni">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('narudzbine.destroy', $narudzbina) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu narudžbinu?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Obriši">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginacija -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Prikazano {{ $narudzbine->firstItem() }} - {{ $narudzbine->lastItem() }}
                        od {{ $narudzbine->total() }} narudžbina
                    </div>
                    <div>
                        {{ $narudzbine->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>Nema narudžbina</h5>
                    <p class="text-muted">
                        @if(request('status') || request('search'))
                            Nema rezultata za vašu pretragu.
                            <a href="{{ route('narudzbine.index') }}">Prikaži sve narudžbine</a>
                        @else
                            Kreirajte prvu narudžbinu da biste počeli.
                        @endif
                    </p>
                    @if(auth()->user()->canEdit() || auth()->user()->role === 'klijent')
                        <a href="{{ route('narudzbine.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nova narudžbina
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .btn-group .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
@endsection
