@extends('layouts.app')

@section('title', 'Dodaj materijal')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dodaj novi materijal</h2>
        <a href="{{ route('materijali.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('materijali.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Naziv --}}
                <div class="mb-3">
                    <label for="naziv" class="form-label">Naziv *</label>
                    <input type="text" name="naziv" id="naziv" class="form-control @error('naziv') is-invalid @enderror"
                           value="{{ old('naziv') }}" required>
                    @error('naziv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Opis --}}
                <div class="mb-3">
                    <label for="opis" class="form-label">Opis</label>
                    <textarea name="opis" id="opis" class="form-control @error('opis') is-invalid @enderror">{{ old('opis') }}</textarea>
                    @error('opis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload slike --}}
                <div class="mb-3">
                    <label for="slika" class="form-label">Slika materijala (jpg, png)</label>
                    <input type="file" name="slika" id="slika" class="form-control @error('slika') is-invalid @enderror" accept="image/*">
                    @error('slika')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Maksimalna veličina: 2MB</small>
                </div>

                {{-- Tip --}}
                <div class="mb-3">
                    <label for="tip" class="form-label">Tip *</label>
                    <input type="text" name="tip" id="tip" class="form-control @error('tip') is-invalid @enderror"
                           value="{{ old('tip') }}" required>
                    @error('tip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jedinica mere --}}
                <div class="mb-3">
                    <label for="jedinica_mere" class="form-label">Jedinica mere *</label>
                    <input type="text" name="jedinica_mere" id="jedinica_mere" class="form-control @error('jedinica_mere') is-invalid @enderror"
                           value="{{ old('jedinica_mere') }}" required>
                    @error('jedinica_mere')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Količina --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="trenutna_kolicina" class="form-label">Trenutna količina *</label>
                        <input type="number" step="0.01" min="0" name="trenutna_kolicina" id="trenutna_kolicina"
                               class="form-control @error('trenutna_kolicina') is-invalid @enderror"
                               value="{{ old('trenutna_kolicina') }}" required>
                        @error('trenutna_kolicina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="minimalna_kolicina" class="form-label">Minimalna količina *</label>
                        <input type="number" step="0.01" min="0" name="minimalna_kolicina" id="minimalna_kolicina"
                               class="form-control @error('minimalna_kolicina') is-invalid @enderror"
                               value="{{ old('minimalna_kolicina') }}" required>
                        @error('minimalna_kolicina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Cena po jedinici --}}
                <div class="mb-3">
                    <label for="cena_po_jedinici" class="form-label">Cena po jedinici *</label>
                    <input type="number" step="0.01" min="0" name="cena_po_jedinici" id="cena_po_jedinici"
                           class="form-control @error('cena_po_jedinici') is-invalid @enderror"
                           value="{{ old('cena_po_jedinici') }}" required>
                    @error('cena_po_jedinici')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dugmad --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('materijali.index') }}" class="btn btn-secondary">Otkaži</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Sačuvaj materijal
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
