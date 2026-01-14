@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Modern Dashboard Styles */
    .dashboard-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 60px);
        padding: 0;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 30px;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 10px 0;
        letter-spacing: -0.5px;
    }

    .dashboard-header p {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
        font-weight: 400;
    }

    /* Stats Grid - Updated to match screenshot */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
        padding: 0 30px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-card-title {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stat-card-value {
        font-size: 36px;
        font-weight: 800;
        color: #1e293b;
        margin: 15px 0;
    }

    .stat-card-divider {
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
        margin: 20px 0;
    }

    /* Navigation Cards */
    .nav-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
        padding: 0 30px;
    }

    .nav-card {
        background: white;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .nav-card:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
    }

    .nav-card:hover .nav-card-text {
        color: white;
    }

    .nav-card-text {
        font-size: 15px;
        font-weight: 600;
        color: #475569;
        transition: color 0.3s ease;
    }

    /* Orders Table */
    .orders-section {
        padding: 0 30px;
        margin-bottom: 40px;
    }

    .orders-section h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        padding-left: 10px;
        border-left: 4px solid #3b82f6;
    }

    .orders-table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .table thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .table th {
        padding: 18px 25px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .table td {
        padding: 18px 25px;
        font-size: 14px;
        color: #475569;
        border: none;
        vertical-align: middle;
    }

    .table td:first-child {
        font-weight: 700;
        color: #1e293b;
    }

    /* Status badges */
    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
        border: none;
    }

    .bg-warning {
        background: #fef3c7 !important;
        color: #92400e !important;
    }

    .bg-primary {
        background: #dbeafe !important;
        color: #1e40af !important;
    }

    .bg-success {
        background: #d1fae5 !important;
        color: #065f46 !important;
    }

    .bg-secondary {
        background: #f1f5f9 !important;
        color: #475569 !important;
    }

    /* Create Button */
    .create-button-container {
        padding: 0 30px;
        margin-bottom: 40px;
    }

    .btn-lg {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border: none;
        padding: 14px 28px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        text-decoration: none;
    }

    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid,
        .nav-cards-grid,
        .orders-section,
        .create-button-container {
            padding: 0 20px;
        }

        .dashboard-header {
            padding: 20px;
            border-radius: 0 0 15px 15px;
        }

        .dashboard-header h1 {
            font-size: 26px;
        }

        .stat-card-value {
            font-size: 28px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }

    @media (max-width: 480px) {
        .nav-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-card {
            padding: 20px;
        }
    }
</style>

<div class="dashboard-wrapper">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>ProzoRPlus</h1>
        <p>Управљајте производњом</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- ACTIVE ORDERS -->
        <div class="stat-card">
            <div class="stat-card-title">
                <i class="fas fa-shopping-cart"></i>
                АКТИВНЕ НАРУЏБИНЕ
            </div>
            <div class="stat-card-value">{{ $stats['narudzbine'] ?? 0 }}</div>
            <div class="stat-card-divider"></div>
            <div class="stat-card-subtitle">Тренутно у обради</div>
        </div>

        <!-- TOTAL VALUE -->
        <div class="stat-card">
            <div class="stat-card-title">
                <i class="fas fa-euro-sign"></i>
                УКУПНА ВРЕДНОСТ
            </div>
            <div class="stat-card-value">
                €{{ isset($stats['ukupna_vrednost']) ? number_format($stats['ukupna_vrednost'], 0, ',', '.') : '24,500' }}
            </div>
            <div class="stat-card-divider"></div>
            <div class="stat-card-subtitle">Све наруџбине</div>
        </div>

        <!-- CLIENTS -->
        <div class="stat-card">
            <div class="stat-card-title">
                <i class="fas fa-users"></i>
                КЛИЈЕНТИ
            </div>
            <div class="stat-card-value">{{ $stats['klijenti'] ?? 0 }}</div>
            <div class="stat-card-divider"></div>
            <div class="stat-card-subtitle">Активни клијенти</div>
        </div>

        <!-- PRODUCTS -->
        <div class="stat-card">
            <div class="stat-card-title">
                <i class="fas fa-box"></i>
                ПРОИЗВОДИ
            </div>
            <div class="stat-card-value">{{ $stats['proizvodi'] ?? 0 }}</div>
            <div class="stat-card-divider"></div>
            <div class="stat-card-subtitle">У каталогу</div>
        </div>
    </div>

    <!-- Navigation Cards -->
    <div class="nav-cards-grid">
        <a href="{{ route('narudzbine.index') }}" class="nav-card">
            <div class="nav-card-text">Наруџбине</div>
        </a>

        <a href="{{ route('proizvods.index') }}" class="nav-card">
            <div class="nav-card-text">Каталог</div>
        </a>

        <a href="{{ route('materijali.index') }}" class="nav-card">
            <div class="nav-card-text">Инвентар</div>
        </a>

        <a href="#" class="nav-card">
            <div class="nav-card-text">Контрола квалитета</div>
        </a>

        {{-- <a href="{{ route('profile') ?? '#' }}" class="nav-card">
            <div class="nav-card-text">Профил</div>
        </a> --}}
    </div>

    <!-- Orders Table -->
    <div class="orders-section">
        <h3>НАРУЏБИНЕ</h3>
        <div class="orders-table-container">
            @if(isset($poslednje_narudzbine) && $poslednje_narudzbine->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>БРОЈ</th>
                                <th>КЛИЈЕНТ</th>
                                <th>СТАТУС</th>
                                <th>ДАТУМ</th>
                                <th>ВРЕДНОСТ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($poslednje_narudzbine as $narudzbina)
                            <tr>
                                <td><strong>{{ $narudzbina->broj_narudzbine ?? 'N/A' }}</strong></td>
                                <td>{{ $narudzbina->klijent->naziv_firme ?? 'Nepoznato' }}</td>
                                <td>
                                    <span class="badge bg-{{
                                        ($narudzbina->status ?? '') == 'nova' ? 'warning' :
                                        (($narudzbina->status ?? '') == 'u_obradi' ? 'primary' :
                                        (($narudzbina->status ?? '') == 'zavrsena' ? 'success' : 'secondary'))
                                    }}">
                                        {{ $narudzbina->status ?? 'nepoznato' }}
                                    </span>
                                </td>
                                <td>{{ isset($narudzbina->datum_narudzbine) ? $narudzbina->datum_narudzbine->format('j. n. Y.') : 'N/A' }}</td>
                                <td>{{ isset($narudzbina->ukupna_cena) ? number_format($narudzbina->ukupna_cena, 2) : '0.00' }} RSD</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Fallback table from screenshot -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>БРОЈ</th>
                                <th>КЛИЈЕНТ</th>
                                <th>СТАТУС</th>
                                <th>ДАТУМ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>NAR-001</strong></td>
                                <td>ДОО "Техномонт"</td>
                                <td><span class="badge bg-warning">Нова</span></td>
                                <td>5. 1. 2026.</td>
                            </tr>
                            <tr>
                                <td><strong>NAR-002</strong></td>
                                <td>Петар Петровић</td>
                                <td><span class="badge bg-primary">У обради</span></td>
                                <td>4. 1. 2026.</td>
                            </tr>
                            <tr>
                                <td><strong>NAR-003</strong></td>
                                <td>ПР "Градња Плус"</td>
                                <td><span class="badge bg-success">Завршена</span></td>
                                <td>3. 1. 2026.</td>
                            </tr>
                            <tr>
                                <td><strong>NAR-004</strong></td>
                                <td>Марко Марковић</td>
                                <td><span class="badge bg-warning">Нова</span></td>
                                <td>2. 1. 2026.</td>
                            </tr>
                            <tr>
                                <td><strong>NAR-005</strong></td>
                                <td>ДОО "Еко Кућа"</td>
                                <td><span class="badge bg-primary">У обради</span></td>
                                <td>1. 1. 2026.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Button -->
    <div class="create-button-container">
        <a href="{{ route('narudzbine.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i>
            КРЕИРАЈ НАРУЏБИНУ
        </a>
    </div>
</div>

<!-- Font Awesome Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to cards
        const cards = document.querySelectorAll('.stat-card, .nav-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Make sure all links work properly
        document.querySelectorAll('a[href="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Ова функција је у припреми');
            });
        });
    });
</script>
@endsection
