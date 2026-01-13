@extends('layouts.app')

@section('title', 'Detalji narudžbine')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Narudžbina: {{ $narudzbina->broj_narudzbine ?? 'N/A' }}</h2>
        <div class="d-flex gap-2">
            @if(auth()->user()->canEdit())
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
            <button class="nav-link" id="proizvodnja-tab" data-bs-toggle="tab"
                    data-bs-target="#proizvodnja" type="button" role="tab">
                <i class="fas fa-industry"></i> Proizvodnja
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kvalitet-tab" data-bs-toggle="tab"
                    data-bs-target="#kvalitet" type="button" role="tab">
                <i class="fas fa-check-circle"></i> Kvalitet
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
                            @if(auth()->user()->canEdit())
                                <!-- Promena statusa -->
                                <div class="mb-3">
                                    <label class="form-label">Promeni status:</label>
                                    <div class="d-grid gap-2">
                                        @if($narudzbina->status == 'nova')
                                            <a href="{{ route('narudzbine.edit', $narudzbina) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-play"></i> Počni obradu
                                            </a>
                                        @endif

                                        @if($narudzbina->status == 'u_obradi')
                                            <a href="{{ route('narudzbine.edit', $narudzbina) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Označi kao završeno
                                            </a>
                                        @endif

                                        @if(in_array($narudzbina->status, ['nova', 'u_obradi']))
                                            <a href="{{ route('narudzbine.edit', $narudzbina) }}" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i> Otkaži narudžbinu
                                            </a>
                                        @endif
                                    </div>
                                </div>

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

        <!-- TAB 2: PROIZVODNJA -->
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

                    <!-- OVDE BIŠE DODAO LISTU STAVKI (StavkaNarudzbine) -->
                    <div class="mt-4">
                        <h6>Stavke narudžbine:</h6>
                        <p class="text-muted">Funkcionalnost za stavke će biti dodata u narednoj verziji.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: KVALITET -->
        <div class="tab-pane fade" id="kvalitet" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kontrola kvaliteta</h5>
                </div>
                <div class="card-body">
                    @if($narudzbina->status == 'zavrsena')
                        <div class="alert alert-success">
                            <i class="fas fa-check-double"></i>
                            Proizvod je prošao kontrolu kvaliteta
                        </div>
                    @else
                        <div class="alert alert-secondary">
                            <i class="fas fa-hourglass-half"></i>
                            Kontrola kvaliteta će biti izvršena po završetku proizvodnje
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
