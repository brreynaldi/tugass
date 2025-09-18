<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
        }

        /* Navbar */
        .custom-navbar {
            background: #0d1b2a;
            border-bottom: 2px solid #f77f00;
        }
        .btn-toggle-sidebar {
            background: #f77f00;
            color: #fff;
            border-radius: 8px;
            padding: 6px 10px;
        }
        .btn-toggle-sidebar:hover {
            background: #ff9900;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background-color: #0d1b2a;
            color: #fff;
            padding-top: 56px; /* tinggi navbar */
            transition: all 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .link-text {
            display: none;
        }

        /* Main Content */
        #main-content {
            transition: margin-left 0.3s ease;
            margin-left: 260px;
            padding: 70px 20px 20px 20px;
        }
        .sidebar.collapsed ~ #main-content {
            margin-left: 80px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
                width: 260px;
            }
            .sidebar.show {
                left: 0;
            }
            #main-content {
                margin-left: 0 !important;
                padding: 70px 15px 20px 15px;
            }
        }

        /* Notifikasi */
        .notif-badge {
            font-size: 10px;
            padding: 2px 5px;
            position: absolute;
            top: 2px;
            right: 2px;
        }
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
            z-index: 1055;
        }
        .dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }
        .dropdown-menu::-webkit-scrollbar-thumb {
            background-color: #bbb;
            border-radius: 10px;
        }
        .notification-item:hover {
            background-color: #e6f3ff;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md shadow-sm custom-navbar fixed-top">
            <div class="container-fluid d-flex justify-content-between align-items-center">

                <!-- Toggle Sidebar -->
                @auth
                <button class="btn btn-toggle-sidebar me-2" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                @endauth

                <!-- Brand -->
                <a class="navbar-brand fw-bold text-white mx-auto d-md-block" href="{{ url('/') }}">
                    <i class="bi bi-grid-fill me-1 text-warning"></i> Aplikasi Pekerjaan Rumah
                </a>

                <!-- Right Section -->
                <div class="d-flex align-items-center">
                    @auth
                        <!-- Notifikasi -->
                        <div class="nav-item dropdown me-3">
                            <a id="notifDropdown" class="nav-link position-relative text-white" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell-fill fs-5"></i>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span class="badge rounded-pill bg-danger notif-badge">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-2 shadow-lg">
                                <h6 class="dropdown-header">📢 Notifikasi</h6>
                                <div class="dropdown-divider"></div>
                                @forelse (Auth::user()->unreadNotifications as $notification)
                                    <div class="dropdown-item d-flex flex-column mb-2 rounded bg-light p-2 small">
                                        <strong class="text-dark mb-1">🔔 Notifikasi</strong>
                                        <span class="notification-message">
                                            {{ $notification->data['pesan'] ?? 'Pesan tidak tersedia' }}
                                        </span>
                                        <small class="text-secondary mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                @empty
                                    <div class="dropdown-item text-center text-muted small">
                                        Tidak ada notifikasi baru.
                                    </div>
                                @endforelse

                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('notifikasi.baca') }}" method="POST" class="text-center">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-secondary">Tandai semua sudah dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- User -->
                        <div class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff&bold=true"
                                     alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg">
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person-circle me-2"></i> Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        @auth
        <div class="sidebar" id="sidebar">
            @include('layouts.sidebar')
        </div>
        @endauth

        <!-- Main Content -->
        <div id="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("toggleSidebar");

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener("click", function () {
                    if (window.innerWidth > 768) {
                        // Desktop → collapse
                        sidebar.classList.toggle("collapsed");
                    } else {
                        // Mobile → overlay
                        sidebar.classList.toggle("show");
                    }
                });
            }
        });
    </script>
</body>
</html>
