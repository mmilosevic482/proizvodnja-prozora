@extends('layouts.app')

@section('title', 'Izmeni proizvod')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Izmeni proizvod: {{ $proizvod->naziv }}</h2>
        <a href="{{ route('proizvods.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Prikaz trenutne slike --}}
            @if($proizvod->slika)
                <div class="mb-3 text-center">
                    <img src="{{ asset($proizvod->slika) }}" style="max-height: 200px; object-fit: cover;" alt="{{ $proizvod->naziv }}">
                </div>
            @endif

            <form action="{{ route('proizvods.update', $proizvod) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="naziv" class="form-label">Naziv *</label>
                    <input type="text" class="form-control @error('naziv') is-invalid @enderror"
                           id="naziv" name="naziv" value="{{ old('naziv', $proizvod->naziv) }}" required>
                    @error('naziv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="opis" class="form-label">Opis (opciono)</label>
                    <textarea class="form-control @error('opis') is-invalid @enderror"
                              id="opis" name="opis">{{ old('opis', $proizvod->opis) }}</textarea>
                    @error('opis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload nove slike --}}
                <div class="mb-3">
                    <label for="slika" class="form-label">Nova slika (jpg, png)</label>
                    <input type="file" class="form-control @error('slika') is-invalid @enderror"
                           id="slika" name="slika" accept="image/*">
                    @error('slika')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Ako ne želite da menjate sliku, ostavite prazno.</small>
                </div>

                <div class="mb-3">
                    <label for="tip" class="form-label">Tip *</label>
                    <select class="form-control @error('tip') is-invalid @enderror" name="tip" id="tip" required>
                        <option value="">-- Izaberi tip --</option>
                        <option value="pvc" {{ old('tip', $proizvod->tip)=='pvc'?'selected':'' }}>PVC</option>
                        <option value="aluminijum" {{ old('tip', $proizvod->tip)=='aluminijum'?'selected':'' }}>Aluminijum</option>
                        <option value="drvo" {{ old('tip', $proizvod->tip)=='drvo'?'selected':'' }}>Drvo</option>
                    </select>
                    @error('tip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="standardna_sirina" class="form-label">Standardna širina (opciono)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('standardna_sirina') is-invalid @enderror"
                               id="standardna_sirina" name="standardna_sirina" value="{{ old('standardna_sirina', $proizvod->standardna_sirina) }}">
                        @error('standardna_sirina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="standardna_visina" class="form-label">Standardna visina (opciono)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('standardna_visina') is-invalid @enderror"
                               id="standardna_visina" name="standardna_visina" value="{{ old('standardna_visina', $proizvod->standardna_visina) }}">
                        @error('standardna_visina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cena_po_m2" class="form-label">Cena po m² *</label>
                    <input type="number" step="0.01" min="0" class="form-control @error('cena_po_m2') is-invalid @enderror"
                           id="cena_po_m2" name="cena_po_m2" value="{{ old('cena_po_m2', $proizvod->cena_po_m2) }}" required>
                    @error('cena_po_m2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('proizvods.index') }}" class="btn btn-secondary">Otkaži</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Sačuvaj izmene</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
