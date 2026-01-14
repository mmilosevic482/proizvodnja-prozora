@extends('layouts.app')

@section('title', 'Креирање нове наруџбине')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Креирање нове наруџбине</h2>
        <a href="{{ route('narudzbine.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Назад
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('narudzbine.store') }}" method="POST" id="narudzbinaForm">
                @csrf

                <!-- Подаци о клијенту -->
                <h4 class="mb-3">Подаци о клијенту</h4>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="klijent_naziv" class="form-label">Име и презиме / Фирма *</label>
                        <input type="text" class="form-control @error('klijent_naziv') is-invalid @enderror"
                               id="klijent_naziv" name="klijent_naziv"
                               value="{{ old('klijent_naziv') }}"
                               placeholder="Унесите име и презиме или назив фирме" required>
                        @error('klijent_naziv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="klijent_pib" class="form-label">ПИБ (опционо)</label>
                        <input type="text" class="form-control @error('klijent_pib') is-invalid @enderror"
                               id="klijent_pib" name="klijent_pib"
                               value="{{ old('klijent_pib') }}"
                               placeholder="Унесите ПИБ">
                        @error('klijent_pib')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="klijent_telefon" class="form-label">Телефон (опционо)</label>
                        <input type="text" class="form-control @error('klijent_telefon') is-invalid @enderror"
                               id="klijent_telefon" name="klijent_telefon"
                               value="{{ old('klijent_telefon') }}"
                               placeholder="Унесите број телефона">
                        @error('klijent_telefon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="klijent_adresa" class="form-label">Адреса (опционо)</label>
                        <input type="text" class="form-control @error('klijent_adresa') is-invalid @enderror"
                               id="klijent_adresa" name="klijent_adresa"
                               value="{{ old('klijent_adresa') }}"
                               placeholder="Унесите адресу">
                        @error('klijent_adresa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="klijent_napomena" class="form-label">Напомена за клијента (опционо)</label>
                        <textarea class="form-control @error('klijent_napomena') is-invalid @enderror"
                                  id="klijent_napomena" name="klijent_napomena" rows="2"
                                  placeholder="Унесите напомену за клијента">{{ old('klijent_napomena') }}</textarea>
                        @error('klijent_napomena')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Прозори -->
                <h4 class="mb-3 mt-4">Прозори</h4>

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
                                    <select class="form-control prozor-tip" name="prozori[0][tip]" required>
                                        <option value="">Изаберите...</option>
                                        <option value="jednokrilni">Једнокрилни</option>
                                        <option value="dvokrilni">Двокрилни</option>
                                        <option value="trokomorni">Трокоморни</option>
                                        <option value="klizni">Клизни</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">MATERIJAL</label>
                                    <select class="form-control prozor-materijal" name="prozori[0][materijal]" required>
                                        <option value="">Изаберите...</option>
                                        <option value="pvc">ПВЦ</option>
                                        <option value="drvo">Дрво</option>
                                        <option value="aluminijum">Алуминијум</option>
                                        <option value="kombinovani">Комбиновани</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">BOJA</label>
                                    <input type="text" class="form-control prozor-boja"
                                           name="prozori[0][boja]" placeholder="Нпр. Бела" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">ШИРИНА (cm) *</label>
                                    <input type="number" class="form-control prozor-sirina"
                                           name="prozori[0][sirina]" min="10" max="500" value="120" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">ВИСИНА (cm) *</label>
                                    <input type="number" class="form-control prozor-visina"
                                           name="prozori[0][visina]" min="10" max="500" value="150" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Количина *</label>
                                    <input type="number" class="form-control prozor-kolicina"
                                           name="prozori[0][kolicina]" min="1" value="1" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Цена по комаду (RSD) *</label>
                                    <input type="number" step="0.01" class="form-control prozor-cena"
                                           name="prozori[0][cena_po_komadu]" min="0" value="0" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info p-2 mb-0">
                                        <small>
                                            <i class="fas fa-info-circle"></i>
                                            Површина: <span class="povrsina">1.80</span> m² |
                                            Укупно за прозор: <span class="ukupno-za-prozor">0.00</span> RSD
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Додај још један прозор -->
                <div class="mb-4">
                    <button type="button" id="dodaj-prozor" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Додај још један прозор
                    </button>
                </div>

                <!-- Сумирање -->
                <div class="card border-primary mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Сумирање наруџбине</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="broj_narudzbine" class="form-label">Број наруџбине *</label>
                                    <input type="text" class="form-control @error('broj_narudzbine') is-invalid @enderror"
                                           id="broj_narudzbine" name="broj_narudzbine"
                                           value="{{ old('broj_narudzbine', 'NAR-' . date('Ymd-His')) }}" required readonly>
                                    @error('broj_narudzbine')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="datum_narudzbine" class="form-label">Датум наруџбине *</label>
                                    <input type="date" class="form-control @error('datum_narudzbine') is-invalid @enderror"
                                           id="datum_narudzbine" name="datum_narudzbine"
                                           value="{{ old('datum_narudzbine', date('Y-m-d')) }}" required>
                                    @error('datum_narudzbine')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rok_isporuke" class="form-label">Рок испоруке *</label>
                                    <input type="date" class="form-control @error('rok_isporuke') is-invalid @enderror"
                                           id="rok_isporuke" name="rok_isporuke"
                                           value="{{ old('rok_isporuke', date('Y-m-d', strtotime('+14 days'))) }}" required>
                                    @error('rok_isporuke')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Статус *</label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="nova" {{ old('status', 'nova') == 'nova' ? 'selected' : '' }}>Нова</option>
                                        <option value="u_obradi" {{ old('status') == 'u_obradi' ? 'selected' : '' }}>У обради</option>
                                        <option value="zavrsena" {{ old('status') == 'zavrsena' ? 'selected' : '' }}>Завршена</option>
                                        <option value="otkazana" {{ old('status') == 'otkazana' ? 'selected' : '' }}>Отказана</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Укупна површина</label>
                                <div class="form-control bg-light" id="ukupna-povrsina">0.00 m²</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Укупна цена наруџбине *</label>
                                <input type="number" step="0.01" class="form-control @error('ukupna_cena') is-invalid @enderror"
                                       id="ukupna_cena" name="ukupna_cena"
                                       value="{{ old('ukupna_cena', 0) }}" required min="0" readonly>
                                @error('ukupna_cena')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="napomena" class="form-label">Напомена (опционо)</label>
                            <textarea class="form-control @error('napomena') is-invalid @enderror"
                                      id="napomena" name="napomena" rows="3">{{ old('napomena') }}</textarea>
                            @error('napomena')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('narudzbine.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Откажи
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-check-circle"></i> Креирај наруџбину
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let prozorIndex = 1;
    const container = document.getElementById('prozori-container');

    // Почетне цене по квадратном метру за различите материјале
    const cenePoMaterijalu = {
        'pvc': 5000,        // 5000 RSD/m²
        'drvo': 8000,       // 8000 RSD/m²
        'aluminijum': 7000, // 7000 RSD/m²
        'kombinovani': 6000 // 6000 RSD/m²
    };

    // Аутоматско рачунање цене
    function izracunajCenuProzora(prozorElement) {
        const sirina = parseFloat(prozorElement.querySelector('.prozor-sirina').value) || 0;
        const visina = parseFloat(prozorElement.querySelector('.prozor-visina').value) || 0;
        const kolicina = parseInt(prozorElement.querySelector('.prozor-kolicina').value) || 1;
        const materijal = prozorElement.querySelector('.prozor-materijal').value;

        // Површина у m² (cm² / 10000)
        const povrsina = (sirina * visina) / 10000;

        // Цена по квадратном метру
        const cenaPoM2 = cenePoMaterijalu[materijal] || 5000;

        // Цена прозора = површина * цена по m² * коефицијент за тип прозора
        let koeficijentTipa = 1.0;
        const tip = prozorElement.querySelector('.prozor-tip').value;

        if (tip === 'dvokrilni') koeficijentTipa = 1.8;
        else if (tip === 'trokomorni') koeficijentTipa = 2.2;
        else if (tip === 'klizni') koeficijentTipa = 1.5;

        const cenaPoKomadu = povrsina * cenaPoM2 * koeficijentTipa;
        const ukupnoZaProzor = cenaPoKomadu * kolicina;

        // Ажурирај вредности
        const cenaInput = prozorElement.querySelector('.prozor-cena');
        cenaInput.value = cenaPoKomadu.toFixed(2);

        // Ажурирај приказ
        prozorElement.querySelector('.povrsina').textContent = povrsina.toFixed(2);
        prozorElement.querySelector('.ukupno-za-prozor').textContent = ukupnoZaProzor.toFixed(2);

        // Ажурирај укупну цену
        azurirajUkupnuCenu();
    }

    function azurirajUkupnuCenu() {
        let ukupnaCena = 0;
        let ukupnaPovrsina = 0;

        document.querySelectorAll('.prozor-item').forEach(prozor => {
            const sirina = parseFloat(prozor.querySelector('.prozor-sirina').value) || 0;
            const visina = parseFloat(prozor.querySelector('.prozor-visina').value) || 0;
            const kolicina = parseInt(prozor.querySelector('.prozor-kolicina').value) || 1;
            const cenaPoKomadu = parseFloat(prozor.querySelector('.prozor-cena').value) || 0;

            ukupnaPovrsina += (sirina * visina * kolicina) / 10000;
            ukupnaCena += cenaPoKomadu * kolicina;
        });

        document.getElementById('ukupna-povrsina').textContent = ukupnaPovrsina.toFixed(2) + ' m²';
        document.getElementById('ukupna_cena').value = ukupnaCena.toFixed(2);
    }

    // Додавање новог прозора
    document.getElementById('dodaj-prozor').addEventListener('click', function() {
        const noviProzor = document.querySelector('.prozor-item').cloneNode(true);
        const noviIndex = prozorIndex++;

        // Ажурирај наслов
        noviProzor.querySelector('.card-header h5').textContent = `Прозор #${noviIndex + 1}`;

        // Прикажи дугме за уклањање
        noviProzor.querySelector('.remove-prozor').style.display = 'block';

        // Ажурирај имена поља
        noviProzor.querySelectorAll('[name]').forEach(input => {
            const name = input.getAttribute('name');
            input.setAttribute('name', name.replace('[0]', `[${noviIndex}]`));
        });

        // Ресетуј вредности
        noviProzor.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
            if (input.classList.contains('prozor-boja')) {
                input.value = '';
            } else if (input.classList.contains('prozor-cena')) {
                input.value = '0';
            } else {
                input.value = input.type === 'number' ?
                    (input.name.includes('sirina') ? 120 :
                     input.name.includes('visina') ? 150 :
                     input.name.includes('kolicina') ? 1 : '') : '';
            }
        });

        noviProzor.querySelectorAll('select').forEach(select => {
            select.value = '';
        });

        // Додај event listener за промене
        noviProzor.querySelectorAll('.prozor-sirina, .prozor-visina, .prozor-kolicina, .prozor-materijal, .prozor-tip').forEach(input => {
            input.addEventListener('input', function() {
                izracunajCenuProzora(noviProzor);
            });
        });

        container.appendChild(noviProzor);
        izracunajCenuProzora(noviProzor);
    });

    // Уклањање прозора
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-prozor')) {
            const prozorZaUklanjanje = e.target.closest('.prozor-item');
            if (document.querySelectorAll('.prozor-item').length > 1) {
                prozorZaUklanjanje.remove();
                azurirajUkupnuCenu();

                // Ренумерација преосталих прозора
                document.querySelectorAll('.prozor-item').forEach((prozor, index) => {
                    prozor.querySelector('.card-header h5').textContent = `Прозор #${index + 1}`;
                });
            } else {
                alert('Морате имати бар један прозор у наруџбини!');
            }
        }
    });

    // Event listener за промене на постојећим прозорима
    document.querySelectorAll('.prozor-sirina, .prozor-visina, .prozor-kolicina, .prozor-materijal, .prozor-tip').forEach(input => {
        input.addEventListener('input', function() {
            const prozor = this.closest('.prozor-item');
            izracunajCenuProzora(prozor);
        });
    });

    // Подразумевани рок испоруке (14 дана)
    const rokField = document.getElementById('rok_isporuke');
    if (!rokField.value) {
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 14);
        rokField.value = nextWeek.toISOString().split('T')[0];
    }

    // Иницијално рачунање
    document.querySelector('.prozor-materijal').value = 'pvc';
    document.querySelector('.prozor-tip').value = 'jednokrilni';
    izracunajCenuProzora(document.querySelector('.prozor-item'));
});
</script>

<style>
.prozor-item {
    border: 1px solid #dee2e6;
    border-radius: 8px;
}
.prozor-item .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
.remove-prozor:hover {
    background-color: #dc3545;
    color: white;
}
</style>
@endsection
