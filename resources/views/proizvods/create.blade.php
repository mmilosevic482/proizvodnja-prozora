@extends('layouts.app')

@section('title', 'Dodaj proizvod')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dodaj novi proizvod</h2>
        <a href="{{ route('proizvods.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- BITNO: enctype za upload slike --}}
            <form action="{{ route('proizvods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Naziv --}}
                <div class="mb-3">
                    <label for="naziv" class="form-label">Naziv *</label>
                    <input type="text" class="form-control @error('naziv') is-invalid @enderror"
                           id="naziv" name="naziv" value="{{ old('naziv') }}" required>
                    @error('naziv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Opis --}}
                <div class="mb-3">
                    <label for="opis" class="form-label">Opis (opciono)</label>
                    <textarea class="form-control @error('opis') is-invalid @enderror"
                              id="opis" name="opis">{{ old('opis') }}</textarea>
                    @error('opis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload slike --}}
                <div class="mb-3">
                    <label for="slika" class="form-label">Slika proizvoda (jpg, png)</label>
                    <input type="file" class="form-control @error('slika') is-invalid @enderror"
                           id="slika" name="slika" accept="image/*">
                    @error('slika')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Maksimalna veličina: 2MB</small>
                </div>

                {{-- Tip proizvoda --}}
                <div class="mb-3">
                    <label for="tip" class="form-label">Tip *</label>
                    <select class="form-control @error('tip') is-invalid @enderror" name="tip" id="tip" required>
                        <option value="">-- Izaberi tip --</option>
                        <option value="pvc" {{ old('tip')=='pvc'?'selected':'' }}>PVC</option>
                        <option value="aluminijum" {{ old('tip')=='aluminijum'?'selected':'' }}>Aluminijum</option>
                        <option value="drvo" {{ old('tip')=='drvo'?'selected':'' }}>Drvo</option>
                    </select>
                    @error('tip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Standardne dimenzije --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="standardna_sirina" class="form-label">Standardna širina (m)</label>
                        <input type="number" step="0.01" min="0"
                               class="form-control @error('standardna_sirina') is-invalid @enderror"
                               id="standardna_sirina" name="standardna_sirina"
                               value="{{ old('standardna_sirina') }}">
                        @error('standardna_sirina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="standardna_visina" class="form-label">Standardna visina (m)</label>
                        <input type="number" step="0.01" min="0"
                               class="form-control @error('standardna_visina') is-invalid @enderror"
                               id="standardna_visina" name="standardna_visina"
                               value="{{ old('standardna_visina') }}">
                        @error('standardna_visina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Cena --}}
                <div class="mb-3">
                    <label for="cena_po_m2" class="form-label">Cena po m² *</label>
                    <input type="number" step="0.01" min="0"
                           class="form-control @error('cena_po_m2') is-invalid @enderror"
                           id="cena_po_m2" name="cena_po_m2"
                           value="{{ old('cena_po_m2') }}" required>
                    @error('cena_po_m2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dugmad --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('proizvods.index') }}" class="btn btn-secondary">Otkaži</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Sačuvaj proizvod
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
