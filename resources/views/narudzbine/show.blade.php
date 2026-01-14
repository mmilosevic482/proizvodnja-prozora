@extends('layouts.app')

@section('title', 'Detalji narudžbine')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Narudžbina: {{ $narudzbina->broj_narudzbine ?? 'N/A' }}</h2>
        <div class="d-flex gap-2">
            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'menadzer'))
                <a href="{{ route('narudzbine.edit', $narudzbina) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Izmeni
                </a>
            @endif
            <a href="{{ route('narudzbine.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Nazad na listu
            </a>
        </div>
    </div>

    <!-- Tabovi -->
    <ul class="nav nav-tabs mb-4" id="narudzbinaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="osnovno-tab" data-bs-toggle="tab"
                    data-bs-target="#osnovno" type="button" role="tab">
                <i class="fas fa-info-circle"></i> Osnovno
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="stavke-tab" data-bs-toggle="tab"
                    data-bs-target="#stavke" type="button" role="tab">
                <i class="fas fa-window-maximize"></i> Stavke ({{ $stavke->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="proizvodnja-tab" data-bs-toggle="tab"
                    data-bs-target="#proizvodnja" type="button" role="tab">
                <i class="fas fa-industry"></i> Proizvodnja
            </button>
        </li>
    </ul>

    <div class="tab-content" id="narudzbinaTabsContent">
        <!-- TAB 1: OSNOVNO -->
        <div class="tab-pane fade show active" id="osnovno" role="tabpanel">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Osnovni podaci</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Broj narudžbine:</th>
                                    <td>{{ $narudzbina->broj_narudzbine ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Klijent:</th>
                                    <td>
                                        @if($narudzbina->klijent)
                                            {{ $narudzbina->klijent->naziv_firme }}
                                            @if($narudzbina->klijent->telefon)
                                                <br><small class="text-muted">Tel: {{ $narudzbina->klijent->telefon }}</small>
                                            @endif
                                            @if($narudzbina->klijent->adresa)
                                                <br><small class="text-muted">{{ $narudzbina->klijent->adresa }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Nepoznato</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Datum narudžbine:</th>
                                    <td>
                                        @if($narudzbina->datum_narudzbine)
                                            {{ \Carbon\Carbon::parse($narudzbina->datum_narudzbine)->format('d.m.Y.') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Rok isporuke:</th>
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
                                                    <br><small class="text-danger">(Kasni!)</small>
                                                @endif
                                            </span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'nova' => 'warning',
                                                'u_obradi' => 'primary',
                                                'zavrsena' => 'success',
                                                'otkazana' => 'danger'
                                            ];
                                            $color = $statusColors[$narudzbina->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }} fs-6">
                                            {{ ucfirst(str_replace('_', ' ', $narudzbina->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ukupna cena:</th>
                                    <td class="fs-5 fw-bold">
                                        {{ number_format($narudzbina->ukupna_cena, 2) }} RSD
                                    </td>
                                </tr>
                                @if($narudzbina->napomena)
                                <tr>
                                    <th>Napomena:</th>
                                    <td>{{ $narudzbina->napomena }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Kreirana:</th>
                                    <td>{{ $narudzbina->created_at->format('d.m.Y. H:i') }}</td>
                                </tr>
                                @if($narudzbina->user)
                                <tr>
                                    <th>Kreirao:</th>
                                    <td>{{ $narudzbina->user->name }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Brze akcije</h5>
                        </div>
                        <div class="card-body">
                            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'menadzer'))
                                <!-- Promena statusa -->
                                <div class="mb-3">
                                    <label class="form-label">Promeni status:</label>
                                    <div class="d-grid gap-2">
                                        @if($narudzbina->status == 'nova')
                                            <form action="{{ route('narudzbine.update', $narudzbina) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="u_obradi">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="fas fa-play"></i> Počni obradu
                                                </button>
                                            </form>
                                        @endif

                                        @if($narudzbina->status == 'u_obradi')
                                            <form action="{{ route('narudzbine.update', $narudzbina) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="zavrsena">
                                                <button type="submit" class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-check"></i> Označi kao završeno
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($narudzbina->status, ['nova', 'u_obradi']))
                                            <form action="{{ route('narudzbine.update', $narudzbina) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="otkazana">
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    <i class="fas fa-times"></i> Otkaži narudžbinu
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <!-- Edit -->
                                <a href="{{ route('narudzbine.edit', $narudzbina) }}" class="btn btn-warning w-100 mb-2">
                                    <i class="fas fa-edit"></i> Izmeni narudžbinu
                                </a>

                                <!-- Brisanje -->
                                <form action="{{ route('narudzbine.destroy', $narudzbina) }}"
                                      method="POST" onsubmit="return confirm('Da li ste sigurni?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-trash"></i> Obriši narudžbinu
                                    </button>
                                </form>
                            @endif

                            <!-- Print -->
                            <a href="#" class="btn btn-outline-secondary w-100 mt-2" onclick="window.print()">
                                <i class="fas fa-print"></i> Štampaj
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: STAVKE -->
        <div class="tab-pane fade" id="stavke" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Stavke narudžbine ({{ $stavke->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($stavke->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Dimenzije</th>
                                        <th>Količina</th>
                                        <th>Boja</th>
                                        <th>Napomena</th>
                                        <th>Cena po komadu</th>
                                        <th>Ukupno</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stavke as $index => $stavka)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $stavka->sirina }} × {{ $stavka->visina }} cm</td>
                                        <td>{{ $stavka->kolicina }}</td>
                                        <td>
                                            <span class="badge" style="background-color: #f0f0f0; color: #333;">
                                                {{ $stavka->boja }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $stavka->napomena }}</small>
                                        </td>
                                        <td>{{ number_format($stavka->cena / $stavka->kolicina, 2) }} RSD</td>
                                        <td class="fw-bold">{{ number_format($stavka->cena, 2) }} RSD</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-light">
                                        <td colspan="6" class="text-end fw-bold">UKUPNO:</td>
                                        <td class="fw-bold fs-5">
                                            {{ number_format($stavke->sum('cena'), 2) }} RSD
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Ova narudžbina nema stavki.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- TAB 3: PROIZVODNJA -->
        <div class="tab-pane fade" id="proizvodnja" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informacije o proizvodnji</h5>
                </div>
                <div class="card-body">
                    @if($narudzbina->status == 'zavrsena')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            Proizvodnja je završena {{ $narudzbina->updated_at->format('d.m.Y.') }}
                        </div>
                    @elseif($narudzbina->status == 'u_obradi')
                        <div class="alert alert-info">
                            <i class="fas fa-industry"></i>
                            Narudžbina je u toku proizvodnje
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-clock"></i>
                            Čeka se početak proizvodnje
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nav-tabs .nav-link {
    font-weight: 500;
    color: #495057;
    border: none;
    padding: 0.75rem 1.5rem;
}
.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 3px solid #0d6efd;
    background-color: transparent;
}
.nav-tabs .nav-link:hover {
    border-color: transparent;
    color: #0d6efd;
}
</style>
@endsection
