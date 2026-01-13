@extends('layouts.app')

@section('title', 'Izmeni materijal')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Izmeni materijal: {{ $materijal->naziv }}</h2>
        <a href="{{ route('materijali.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Prikaz trenutne slike --}}
            @if($materijal->slika)
                <div class="mb-3 text-center">
                    <img src="{{ asset($materijal->slika) }}" style="max-height: 200px; object-fit: cover;" alt="{{ $materijal->naziv }}">
                </div>
            @endif

            <form action="{{ route('materijali.update', $materijal) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Naziv --}}
                <div class="mb-3">
                    <label for="naziv" class="form-label">Naziv *</label>
                    <input type="text" name="naziv" id="naziv" class="form-control @error('naziv') is-invalid @enderror"
                           value="{{ old('naziv', $materijal->naziv) }}" required>
                    @error('naziv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Opis --}}
                <div class="mb-3">
                    <label for="opis" class="form-label">Opis</label>
                    <textarea name="opis" id="opis" class="form-control @error('opis') is-invalid @enderror">{{ old('opis', $materijal->opis) }}</textarea>
                    @error('opis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload nove slike --}}
                <div class="mb-3">
                    <label for="slika" class="form-label">Nova slika (jpg, png)</label>
                    <input type="file" name="slika" id="slika" class="form-control @error('slika') is-invalid @enderror" accept="image/*">
                    @error('slika')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Ako ne želite da menjate sliku, ostavite prazno.</small>
                </div>

                {{-- Tip --}}
                <div class="mb-3">
                    <label for="tip" class="form-label">Tip *</label>
                    <input type="text" name="tip" id="tip" class="form-control @error('tip') is-invalid @enderror"
                           value="{{ old('tip', $materijal->tip) }}" required>
                    @error('tip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jedinica mere --}}
                <div class="mb-3">
                    <label for="jedinica_mere" class="form-label">Jedinica mere *</label>
                    <input type="text" name="jedinica_mere" id="jedinica_mere" class="form-control @error('jedinica_mere') is-invalid @enderror"
                           value="{{ old('jedinica_mere', $materijal->jedinica_mere) }}" required>
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
                               value="{{ old('trenutna_kolicina', $materijal->trenutna_kolicina) }}" required>
                        @error('trenutna_kolicina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="minimalna_kolicina" class="form-label">Minimalna količina *</label>
                        <input type="number" step="0.01" min="0" name="minimalna_kolicina" id="minimalna_kolicina"
                               class="form-control @error('minimalna_kolicina') is-invalid @enderror"
                               value="{{ old('minimalna_kolicina', $materijal->minimalna_kolicina) }}" required>
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
                           value="{{ old('cena_po_jedinici', $materijal->cena_po_jedinici) }}" required>
                    @error('cena_po_jedinici')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dugmad --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('materijali.index') }}" class="btn btn-secondary">Otkaži</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Sačuvaj izmene
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
