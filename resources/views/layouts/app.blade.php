<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proizvodnja Prozora - @yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .sidebar {
            background: #2c3e50;
            min-height: calc(100vh - 56px);
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: #ecf0f1;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background: #34495e;
            padding-left: 25px;
        }

        .sidebar a.active {
            background: #3498db;
            border-left: 4px solid #2980b9;
        }

        .content-wrapper {
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }

        .btn {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
        }

        .table th {
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }
    </style>

    @yield('styles')
</head>
<body>
    @if(Auth::check())
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-industry"></i> Proizvodnja Prozora
                </a>

                <div class="navbar-nav ms-auto">
                    <span class="navbar-text text-white me-3">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        <small class="badge bg-light text-dark ms-1">
                            {{ Auth::user()->role }}
                        </small>
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Odjava
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- SIDEBAR -->
                <div class="col-md-2 p-0 sidebar">
                    <nav class="nav flex-column">
                        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>

                        <!-- Ove linkove vide svi -->
                        <a href="{{ route('clients.index') }}" class="{{ request()->is('clients*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Klijenti
                        </a>
                        <a href="{{ route('proizvods.index') }}" class="{{ request()->is('proizvods*') ? 'active' : '' }}">
                            <i class="fas fa-window-maximize me-2"></i> Proizvodi
                        </a>
                        <a href="{{ route('narudzbine.index') }}" class="{{ request()->is('narudzbine*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart me-2"></i> Narudžbine
                        </a>

                        <!-- Ove linkove vide samo admin/menadzer -->
                        @if(auth()->user()->canEdit())
                            <a href="{{ route('materijali.index') }}" class="{{ request()->is('materijali*') ? 'active' : '' }}">
                                <i class="fas fa-boxes me-2"></i> Materijali
                            </a>
                            <a href="{{ route('proizvodni-zadaci.index') }}" class="{{ request()->is('proizvodni-zadaci*') ? 'active' : '' }}">
                                <i class="fas fa-tasks me-2"></i> Zadaci
                            </a>
                        @endif

                        <!-- KATALOG - vidljiv svima -->
                        <a href="{{ route('katalog.index') }}" class="{{ request()->is('katalog*') ? 'active' : '' }}">
                            <i class="fas fa-store me-2"></i> Katalog
                        </a>
                    </nav>
                </div>

                <!-- MAIN CONTENT -->
                <div class="col-md-10 p-0">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Ako nije ulogovan, prikaži samo content bez sidebara -->
        <div class="container py-5">
            @yield('content')
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>
</html>
