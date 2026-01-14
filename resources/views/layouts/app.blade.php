<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProzoRPlus - @yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
            --text-light: #f8fafc;
            --text-dark: #1e293b;
            --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f8fafc;
            color: #334155;
            overflow-x: hidden;
        }

        /* ========== NAVBAR ========== */
        .navbar-main {
            background: var(--primary-gradient);
            color: white;
            height: 70px;
            padding: 0 30px;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            font-size: 28px;
            color: #fbbf24;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: white;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 3px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            background: var(--sidebar-bg);
            width: 260px;
            min-height: calc(100vh - 70px);
            position: fixed;
            top: 70px;
            left: 0;
            padding: 30px 0;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .sidebar-header {
            padding: 0 25px 25px;
            border-bottom: 1px solid #334155;
            margin-bottom: 25px;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .sidebar-subtitle {
            font-size: 14px;
            color: #cbd5e1;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 0 15px;
        }

        .nav-section-title {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            padding: 15px 25px 10px;
            margin-top: 15px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 15px;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--sidebar-active);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 18px;
            opacity: 0.9;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s ease;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .navbar-main {
                padding: 0 20px;
            }

            .main-content {
                padding: 20px;
            }

            .user-details {
                display: none;
            }
        }

        /* ========== UTILITY ========== */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .mobile-overlay.active {
            display: block;
        }

        /* ========== AUTH PAGES (when not logged in) ========== */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
        }
    </style>

    @yield('styles')
</head>
<body>
    @if(Auth::check())
        <!-- NAVBAR -->
        <nav class="navbar-main">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-window-maximize"></i>
                    ProzoRPlus
                </a>
            </div>

            <div class="user-info">
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name ?? 'Корисник' }}</div>
                    <div class="user-role">{{ Auth::user()->role ?? 'Администратор' }}</div>
                </div>

                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Одјава
                    </button>
                </form>
            </div>
        </nav>

        <!-- SIDEBAR -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">Командна табла</div>
                <div class="sidebar-subtitle">Управљајте производњом</div>
            </div>

            <div class="sidebar-nav">
                <!-- Main Navigation -->
                <div class="nav-section-title">Главни Мени</div>

                <div class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Командна табла
                    </a>
                </div>

                <div class="nav-item">
                    <a href="/narudzbine/create" class="nav-link {{ request()->is('narudzbine/create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i>
                        Креирај наруџбину
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('narudzbine.index') }}" class="nav-link {{ request()->is('narudzbine*') && !request()->is('narudzbine/create') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        Наруџбине
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('proizvods.index') }}" class="nav-link {{ request()->is('proizvods*') ? 'active' : '' }}">
                        <i class="fas fa-window-maximize"></i>
                        Производи
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('materijali.index') }}" class="nav-link {{ request()->is('materijali*') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        Материјали
                    </a>
                </div>

                {{-- <div class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-clipboard-check"></i>
                        Контрола квалитета
                    </a>
                </div> --}}

                <!-- Management Section -->
                <div class="nav-section-title">Управљање</div>

                <div class="nav-item">
                    <a href="{{ route('clients.index') }}" class="nav-link {{ request()->is('clients*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        Клијенти
                    </a>
                </div>

                {{-- @if(auth()->user()->canEdit())
                <div class="nav-item">
                    <a href="{{ route('proizvodni-zadaci.index') }}" class="nav-link {{ request()->is('proizvodni-zadaci*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        Задачи
                    </a>
                </div>
                @endif --}}

                <!-- User Section -->
                {{-- <div class="nav-section-title">Корисник</div> --}}

                <div class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        Профил
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- MAIN CONTENT -->
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>
    @else
        <!-- AUTH PAGES (when not logged in) -->
        <div class="auth-container">
            @yield('content')
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mainContent = document.getElementById('mainContent');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
            });

            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                mobileOverlay.classList.remove('active');
            });

            // Auto-dismiss alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);

            // Add active class based on current URL
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath && currentPath.startsWith(linkPath) && linkPath !== '/') {
                    link.classList.add('active');
                }
            });

            // Make placeholder links show message
            document.querySelectorAll('.nav-link[href="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('🔧 Ова функција је у припреми');
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
