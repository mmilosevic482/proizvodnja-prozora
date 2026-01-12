@extends('layouts.app')

@section('title', 'Dodaj klijenta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dodaj novog klijenta</h2>
        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="naziv_firme" class="form-label">Naziv firme *</label>
                        <input type="text" class="form-control @error('naziv_firme') is-invalid @enderror"
                               id="naziv_firme" name="naziv_firme"
                               value="{{ old('naziv_firme') }}" required>
                        @error('naziv_firme')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefon" class="form-label">Telefon *</label>
                        <input type="text" class="form-control @error('telefon') is-invalid @enderror"
                               id="telefon" name="telefon"
                               value="{{ old('telefon') }}" required>
                        @error('telefon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adresa" class="form-label">Adresa *</label>
                    <input type="text" class="form-control @error('adresa') is-invalid @enderror"
                           id="adresa" name="adresa"
                           value="{{ old('adresa') }}" required>
                    @error('adresa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pib" class="form-label">PIB (opciono)</label>
                    <input type="text" class="form-control @error('pib') is-invalid @enderror"
                           id="pib" name="pib"
                           value="{{ old('pib') }}">
                    @error('pib')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="napomena" class="form-label">Napomena (opciono)</label>
                    <textarea class="form-control @error('napomena') is-invalid @enderror"
                              id="napomena" name="napomena" rows="3">{{ old('napomena') }}</textarea>
                    @error('napomena')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Otkaži</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Sačuvaj klijenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
