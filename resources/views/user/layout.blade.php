<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Kullanıcı Paneli')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand h2 {
            margin-bottom: 0;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem;
        }

        .nav-item {
            position: relative;
            margin-bottom: 0.25rem;
        }

        .nav-item.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--light-color);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .content {
            flex: 1;
            transition: all 0.3s ease;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .navbar-brand {
            display: none;
        }

        .dropdown-menu {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }

        .dropdown-item:active {
            background-color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #224abe;
            border-color: #224abe;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .card-header h6 {
            font-weight: 700;
            font-size: 0.9rem;
            color: #4e73df;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .page-title {
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .page-title i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                bottom: 0;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .navbar-brand {
                display: block;
            }

            .content {
                margin-left: 0 !important;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Animations */
        .fadeIn {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h2><i class="fas fa-calendar-alt me-2"></i> Kullanıcı Paneli</h2>
            </div>

            <hr class="sidebar-divider">

            <div class="nav flex-column">
                <div class="nav-item {{ Route::is('user.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Gösterge Paneli</span>
                    </a>
                </div>

                <div class="nav-item {{ Route::is('user.appointments') || Route::is('user.appointment.details') ? 'active' : '' }}">
                    <a href="{{ route('user.appointments') }}" class="nav-link {{ Route::is('user.appointments') || Route::is('user.appointment.details') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-calendar-check"></i>
                        <span>Randevularım</span>
                    </a>
                </div>

                <div class="nav-item {{ Route::is('user.profile') ? 'active' : '' }}">
                    <a href="{{ route('user.profile') }}" class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Profil Bilgilerim</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('anasayfa') }}" class="nav-link">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Anasayfaya Dön</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content" id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle -->
                <button id="sidebarToggle" class="btn btn-link d-md-none">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Navbar Brand -->
                <a class="navbar-brand d-md-none" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-calendar-alt me-2"></i> Kullanıcı Paneli
                </a>

                <!-- Navbar Right Content -->
                <div class="navbar-nav ms-auto">
                    <!-- User Information Dropdown -->
                    <div class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-inline-block me-2 text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&size=40">
                        </a>

                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                Çıkış Yap
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid px-4 fadeIn">
                <!-- Page Title -->
                @if(View::hasSection('page-title'))
                <h1 class="page-title">
                    @section('page-icon')
                    <i class="fas fa-star"></i>
                    @show
                    @yield('page-title')
                </h1>
                @endif

                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white py-4 mt-auto">
                <div class="container">
                    <div class="text-center">
                        <span class="text-muted">Copyright &copy; Organizasyon Randevu Sistemi {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggle = sidebarToggle && sidebarToggle.contains(event.target);

                if (window.innerWidth < 768 && !isClickInsideSidebar && !isClickInsideToggle && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
