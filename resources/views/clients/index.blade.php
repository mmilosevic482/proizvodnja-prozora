@extends('layouts.app')

@section('title', 'Klijenti')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Klijenti</h2>
        @if(auth()->user()->canEdit())
            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Dodaj klijenta
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
            @if($klijents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Naziv firme</th>
                                <th>Adresa</th>
                                <th>Telefon</th>
                                <th>PIB</th>
                                <th>Akcije</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($klijents as $klijent)
                            <tr>
                                <td>{{ $klijent->id }}</td>
                                <td>{{ $klijent->naziv_firme }}</td>
                                <td>{{ $klijent->adresa }}</td>
                                <td>{{ $klijent->telefon }}</td>
                                <td>{{ $klijent->pib ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('clients.show', $klijent) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Pregled
                                    </a>

                                    @if(auth()->user()->canEdit())
                                        <a href="{{ route('clients.edit', $klijent) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Izmeni
                                        </a>
                                        <form action="{{ route('clients.destroy', $klijent) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog klijenta?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Obriši
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>Nema klijenata</h5>
                    <p class="text-muted">Dodajte prvog klijenta da biste počeli.</p>
                    @if(auth()->user()->canEdit())
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Dodaj klijenta
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
