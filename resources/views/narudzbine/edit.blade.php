@extends('layouts.app')

@section('title', 'Izmeni narudžbinu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Izmeni narudžbinu: {{ $narudzbina->broj_narudzbine }}</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('narudzbine.show', $narudzbina) }}" class="btn btn-outline-info">
                <i class="fas fa-eye"></i> Pregled
            </a>
            <a href="{{ route('narudzbine.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Nazad
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('narudzbine.update', $narudzbina) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Prikaz klijenta kao tekst (ne može da se menja) -->
                <div class="mb-4">
                    <h5>Podaci o klijentu</h5>
                    <div class="card bg-light">
                        <div class="card-body">
                            @if($narudzbina->klijent)
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Firma:</strong> {{ $narudzbina->klijent->naziv_firme }}</p>
                                        <p><strong>Adresa:</strong> {{ $narudzbina->klijent->adresa ?? 'Nije uneta' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Telefon:</strong> {{ $narudzbina->klijent->telefon ?? 'Nije unet' }}</p>
                                        <p><strong>PIB:</strong> {{ $narudzbina->klijent->pib ?? 'Nije unet' }}</p>
                                    </div>
                                </div>
                                @if($narudzbina->klijent->napomena)
                                    <p><strong>Napomena:</strong> {{ $narudzbina->klijent->napomena }}</p>
                                @endif
                            @else
                                <p class="text-muted">Klijent nije pronađen</p>
                            @endif
                        </div>
                    </div>
                    <!-- Skriveno polje za klijent_id -->
                    <input type="hidden" name="klijent_id" value="{{ $narudzbina->klijent_id }}">
                </div>

                <!-- Podaci o narudžbini -->
                <h5 class="mb-3">Podaci o narudžbini</h5>

                <div class="row">
                    <!-- Broj narudžbine -->
                    <div class="col-md-6 mb-3">
                        <label for="broj_narudzbine" class="form-label">Broj narudžbine *</label>
                        <input type="text" class="form-control @error('broj_narudzbine') is-invalid @enderror"
                               id="broj_narudzbine" name="broj_narudzbine"
                               value="{{ old('broj_narudzbine', $narudzbina->broj_narudzbine) }}" required>
                        @error('broj_narudzbine')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Datum narudžbine -->
                    <div class="col-md-6 mb-3">
                        <label for="datum_narudzbine" class="form-label">Datum narudžbine *</label>
                        <input type="date" class="form-control @error('datum_narudzbine') is-invalid @enderror"
                               id="datum_narudzbine" name="datum_narudzbine"
                               value="{{ old('datum_narudzbine', $narudzbina->datum_narudzbine ? $narudzbina->datum_narudzbine->format('Y-m-d') : '') }}" required>
                        @error('datum_narudzbine')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Rok isporuke -->
                    <div class="col-md-6 mb-3">
                        <label for="rok_isporuke" class="form-label">Rok isporuke *</label>
                        <input type="date" class="form-control @error('rok_isporuke') is-invalid @enderror"
                               id="rok_isporuke" name="rok_isporuke"
                               value="{{ old('rok_isporuke', $narudzbina->rok_isporuke ? $narudzbina->rok_isporuke->format('Y-m-d') : '') }}" required>
                        @error('rok_isporuke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-control @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="nova" {{ old('status', $narudzbina->status) == 'nova' ? 'selected' : '' }}>Nova</option>
                            <option value="u_obradi" {{ old('status', $narudzbina->status) == 'u_obradi' ? 'selected' : '' }}>U obradi</option>
                            <option value="zavrsena" {{ old('status', $narudzbina->status) == 'zavrsena' ? 'selected' : '' }}>Završena</option>
                            <option value="otkazana" {{ old('status', $narudzbina->status) == 'otkazana' ? 'selected' : '' }}>Otkazana</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Ukupna cena -->
                <div class="mb-3">
                    <label for="ukupna_cena" class="form-label">Ukupna cena (RSD) *</label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control @error('ukupna_cena') is-invalid @enderror"
                               id="ukupna_cena" name="ukupna_cena"
                               value="{{ old('ukupna_cena', $narudzbina->ukupna_cena) }}" required min="0">
                        <span class="input-group-text">RSD</span>
                        @error('ukupna_cena')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">
                        Ukupna cena stavki: <strong>{{ number_format($stavke->sum('cena'), 2) }} RSD</strong>
                        @if($stavke->count() > 0)
                            <br>({{ $stavke->count() }} stavke,
                            {{ number_format($stavke->avg('cena'), 2) }} RSD prosečno)
                        @endif
                    </small>
                </div>

                <!-- Napomena -->
                <div class="mb-3">
                    <label for="napomena" class="form-label">Napomena (opciono)</label>
                    <textarea class="form-control @error('napomena') is-invalid @enderror"
                              id="napomena" name="napomena" rows="3">{{ old('napomena', $narudzbina->napomena) }}</textarea>
                    @error('napomena')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lista stavki (samo za pregled) -->
                @if($stavke->count() > 0)
                <div class="mb-4">
                    <h5>Stavke narudžbine</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Dimenzije</th>
                                    <th>Količina</th>
                                    <th>Boja</th>
                                    <th>Napomena</th>
                                    <th>Cena</th>
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
                                    <td><small>{{ $stavka->napomena }}</small></td>
                                    <td>{{ number_format($stavka->cena, 2) }} RSD</td>
                                </tr>
                                @endforeach
                                <tr class="table-light">
                                    <td colspan="5" class="text-end fw-bold">UKUPNO:</td>
                                    <td class="fw-bold">{{ number_format($stavke->sum('cena'), 2) }} RSD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <small class="text-muted">Napomena: Stavke se ne mogu menjati. Za promenu stavki kreirati novu narudžbinu.</small>
                </div>
                @endif

                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('narudzbine.show', $narudzbina) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Otkaži
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Sačuvaj izmene
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Automatsko računanje cene ako želiš da dodas ovu funkcionalnost
    const ukupnaCenaInput = document.getElementById('ukupna_cena');
    const ukupnoStavki = {{ $stavke->sum('cena') }};

    // Postavi podrazumevanu vrednost ako je prazno
    if (!ukupnaCenaInput.value && ukupnoStavki > 0) {
        ukupnaCenaInput.value = ukupnoStavki;
    }

    // Provera da rok isporuke nije pre datuma narudžbine
    const datumNarudzbine = document.getElementById('datum_narudzbine');
    const rokIsporuke = document.getElementById('rok_isporuke');

    if (datumNarudzbine && rokIsporuke) {
        datumNarudzbine.addEventListener('change', function() {
            if (rokIsporuke.value && new Date(rokIsporuke.value) < new Date(this.value)) {
                alert('Rok isporuke ne može biti pre datuma narudžbine!');
                rokIsporuke.value = this.value;
            }
        });

        rokIsporuke.addEventListener('change', function() {
            if (datumNarudzbine.value && new Date(this.value) < new Date(datumNarudzbine.value)) {
                alert('Rok isporuke ne može biti pre datuma narudžbine!');
                this.value = datumNarudzbine.value;
            }
        });
    }
});
</script>

<style>
.card.bg-light {
    border: 1px solid #dee2e6;
    border-left: 4px solid #0d6efd;
}
</style>
@endsection
