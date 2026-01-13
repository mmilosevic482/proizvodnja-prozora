@extends('layouts.app')

@section('title', 'Izmeni narudžbinu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Izmeni narudžbinu: {{ $narudzbina->broj_narudzbine }}</h2>
        <a href="{{ route('narudzbine.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('narudzbine.update', $narudzbina) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Klijent -->
                    <div class="col-md-6 mb-3">
                        <label for="klijent_id" class="form-label">Klijent *</label>
                        <select class="form-control @error('klijent_id') is-invalid @enderror"
                                id="klijent_id" name="klijent_id" required>
                            <option value="">Izaberite klijenta</option>
                            @foreach($klijenti as $klijent)
                                <option value="{{ $klijent->id }}"
                                    {{ old('klijent_id', $narudzbina->klijent_id) == $klijent->id ? 'selected' : '' }}>
                                    {{ $klijent->naziv_firme }}
                                </option>
                            @endforeach
                        </select>
                        @error('klijent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                </div>

                <div class="row">
                    <!-- Datum narudžbine -->
                    <div class="col-md-6 mb-3">
                        <label for="datum_narudzbine" class="form-label">Datum narudžbine *</label>
                        <input type="date" class="form-control @error('datum_narudzbine') is-invalid @enderror"
                               id="datum_narudzbine" name="datum_narudzbine"
                               value="{{ old('datum_narudzbine', $narudzbina->datum_narudzbine->format('Y-m-d')) }}" required>
                        @error('datum_narudzbine')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rok isporuke -->
                    <div class="col-md-6 mb-3">
                        <label for="rok_isporuke" class="form-label">Rok isporuke *</label>
                        <input type="date" class="form-control @error('rok_isporuke') is-invalid @enderror"
                               id="rok_isporuke" name="rok_isporuke"
                               value="{{ old('rok_isporuke', $narudzbina->rok_isporuke->format('Y-m-d')) }}" required>
                        @error('rok_isporuke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
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

                <!-- Ukupna cena -->
                <div class="mb-3">
                    <label for="ukupna_cena" class="form-label">Ukupna cena (RSD) *</label>
                    <input type="number" step="0.01" class="form-control @error('ukupna_cena') is-invalid @enderror"
                           id="ukupna_cena" name="ukupna_cena"
                           value="{{ old('ukupna_cena', $narudzbina->ukupna_cena) }}" required min="0">
                    @error('ukupna_cena')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('narudzbine.index') }}" class="btn btn-secondary">Otkaži</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Sačuvaj izmene
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
