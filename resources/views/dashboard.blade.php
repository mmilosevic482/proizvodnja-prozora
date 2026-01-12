@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Klijenti</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['klijenti'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Proizvodi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['proizvodi'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Narudžbine</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['narudzbine'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Zadaci</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['zadaci'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Poslednje aktivnosti</h6>
                </div>
                <div class="card-body">
                    @if(isset($poslednje_narudzbine) && $poslednje_narudzbine->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Broj</th>
                                        <th>Klijent</th>
                                        <th>Datum</th>
                                        <th>Status</th>
                                        <th>Vrednost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($poslednje_narudzbine as $narudzbina)
                                    <tr>
                                        <td>{{ $narudzbina->broj_narudzbine ?? 'N/A' }}</td>
                                        <td>{{ $narudzbina->klijent->naziv_firme ?? 'Nepoznato' }}</td>
                                        <td>{{ isset($narudzbina->datum_narudzbine) ? $narudzbina->datum_narudzbine->format('d.m.Y.') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                ($narudzbina->status ?? '') == 'nova' ? 'warning' :
                                                (($narudzbina->status ?? '') == 'u_obradi' ? 'primary' :
                                                (($narudzbina->status ?? '') == 'zavrsena' ? 'success' : 'secondary'))
                                            }}">
                                                {{ $narudzbina->status ?? 'nepoznato' }}
                                            </span>
                                        </td>
                                        <td>{{ isset($narudzbina->ukupna_cena) ? number_format($narudzbina->ukupna_cena, 2) : '0.00' }} RSD</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-muted">Trenutno nema aktivnosti.</p>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Dodaj klijenta
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
