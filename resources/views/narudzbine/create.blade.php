@extends('layouts.app')

@section('title', 'Nova narudžbina')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nova narudžbina</h2>
        <a href="{{ route('narudzbine.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('narudzbine.store') }}" method="POST">
                @csrf

                <!-- Подаци о клијенту -->
                <h4 class="mb-3">Подаци о клијенту</h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ime_prezime_firma" class="form-label">IME I PREZIME / FIRMA *</label>
                        <input type="text" class="form-control @error('ime_prezime_firma') is-invalid @enderror"
                               id="ime_prezime_firma" name="ime_prezime_firma"
                               value="{{ old('ime_prezime_firma') }}" required>
                        @error('ime_prezime_firma')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">EMAIL *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefon" class="form-label">TELEFON *</label>
                        <input type="text" class="form-control @error('telefon') is-invalid @enderror"
                               id="telefon" name="telefon"
                               value="{{ old('telefon') }}" required>
                        @error('telefon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="adresa" class="form-label">ADRESA *</label>
                        <input type="text" class="form-control @error('adresa') is-invalid @enderror"
                               id="adresa" name="adresa"
                               value="{{ old('adresa') }}" required>
                        @error('adresa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <!-- Прозори -->
                <h4 class="mb-3">Прозори</h4>

                <div id="prozori-container">
                    <!-- Први прозор -->
                    <div class="card mb-3 prozor-item">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Прозор #1</h5>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-prozor" style="display: none;">
                                <i class="fas fa-trash"></i> Уклони
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">TIP PROZORA</label>
                                    <select class="form-control" name="prozori[0][tip]" required>
                                        <option value="">Изabерите...</option>
                                        <option value="jednokrilni">Једнокрилни</option>
                                        <option value="dvokrilni">Двокрилни</option>
                                        <option value="trokomorni">Трокоморни</option>
                                        <option value="klizni">Клизни</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">MATERIJAL</label>
                                    <select class="form-control" name="prozori[0][materijal]" required>
                                        <option value="">Изabерите...</option>
                                        <option value="pvc">ПВЦ</option>
                                        <option value="drvo">Дрво</option>
                                        <option value="aluminijum">Алуминијум</option>
                                        <option value="kombinovani">Комбиновани</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">BOJA</label>
                                    <input type="text" class="form-control"
                                           name="prozori[0][boja]"
                                           placeholder="Нпр. Бела" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">ШИРИНА (cm)</label>
                                    <input type="number" class="form-control"
                                           name="prozori[0][sirina]"
                                           min="1" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">ВИСИНА (cm)</label>
                                    <input type="number" class="form-control"
                                           name="prozori[0][visina]"
                                           min="1" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Количина</label>
                                    <input type="number" class="form-control"
                                           name="prozori[0][kolicina]"
                                           value="1" min="1" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Цена (RSD)</label>
                                    <input type="number" step="0.01" class="form-control"
                                           name="prozori[0][cena]"
                                           min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Додај нови прозор -->
                <div class="mb-4">
                    <button type="button" id="dodaj-prozor" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Додај још један прозор
                    </button>
                </div>

                <!-- Напомена -->
                <div class="mb-4">
                    <label for="napomena" class="form-label">Напомена (опционо)</label>
                    <textarea class="form-control" id="napomena" name="napomena" rows="3">{{ old('napomena') }}</textarea>
                </div>

                <!-- Укупна цена -->
                <div class="mb-4">
                    <label for="ukupna_cena" class="form-label">Укупна цена (RSD) *</label>
                    <input type="number" step="0.01" class="form-control"
                           id="ukupna_cena" name="ukupna_cena"
                           value="{{ old('ukupna_cena', 0) }}" required min="0" readonly>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('narudzbine.index') }}" class="btn btn-secondary">Откажи</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Сачувај наруџбину
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let prozorCount = 1;
    const container = document.getElementById('prozori-container');
    const ukupnaCenaInput = document.getElementById('ukupna_cena');

    // Функција за ажурирање укупне цене
    function azurirajUkupnuCenu() {
        let ukupno = 0;
        document.querySelectorAll('input[name^="prozori["][name$="][cena]"]').forEach(input => {
            ukupno += parseFloat(input.value) || 0;
        });
        ukupnaCenaInput.value = ukupno.toFixed(2);
    }

    // Додавање новог прозора
    document.getElementById('dodaj-prozor').addEventListener('click', function() {
        const newIndex = prozorCount++;
        const newProzor = document.querySelector('.prozor-item').cloneNode(true);

        // Ажурирање наслова
        const header = newProzor.querySelector('.card-header h5');
        header.textContent = `Прозор #${newIndex + 1}`;

        // Прикажи дугме за уклањање
        newProzor.querySelector('.remove-prozor').style.display = 'block';

        // Ажурирање имена поља
        const inputs = newProzor.querySelectorAll('[name]');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace('[0]', `[${newIndex}]`));
            // Ресет вредности
            if (input.type !== 'button') {
                input.value = '';
            }
        });

        // Ресет избора за селекте
        newProzor.querySelectorAll('select').forEach(select => {
            select.value = '';
        });

        // Постави количину на 1
        newProzor.querySelector('input[name$="[kolicina]"]').value = 1;

        // Додај event listener за цену
        newProzor.querySelector('input[name$="[cena]"]').addEventListener('input', azurirajUkupnuCenu);

        // Додај у контејнер
        container.appendChild(newProzor);

        // Додај event listener за уклањање
        newProzor.querySelector('.remove-prozor').addEventListener('click', function() {
            newProzor.remove();
            azurirajUkupnuCenu();
        });
    });

    // Event listener за промену цене на постојећим пољима
    document.querySelectorAll('input[name^="prozori["][name$="][cena]"]').forEach(input => {
        input.addEventListener('input', azurirajUkupnuCenu);
    });

    // Event listener за уклањање првог прозора (ако постоји више)
    document.querySelectorAll('.remove-prozor').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.prozor-item').remove();
            azurirajUkupnuCenu();
        });
    });

    // Иницијално ажурирање цене
    azurirajUkupnuCenu();
});
</script>
@endsection
