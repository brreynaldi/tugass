<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">

    <style>
                /* Responsif untuk layar kecil (HP) */
        @media (max-width: 576px) {
            .dropdown-menu {
                width: 95% !important;   /* full hampir layar */
                left: 2.5% !important;   /* center */
                right: auto !important;
                max-height: 70vh;        /* tinggi maksimal, pakai vh */
                overflow-y: auto;        /* scroll kalau kepanjangan */
                font-size: 14px;         /* teks lebih kecil */
            }
            .dropdown-item {
                white-space: normal;     /* supaya teks panjang turun ke bawah */
                word-break: break-word;  /* pecah kata panjang */
            }
            .notif-badge {
                top: -2px; 
                right: -2px; 
                font-size: 11px;
            }
        }
        .notification-item {
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .notification-item:hover {
            background-color: #e6f3ff;
        }
        .dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }
                /* Dropdown agar tidak ketutup container */
        .dropdown-menu {
            max-height: 400px; /* atur sesuai kebutuhan */
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1055; /* pastikan lebih tinggi dari elemen lain */
        }
        .dropdown-menu::-webkit-scrollbar-thumb {
            background-color: #bbb;
            border-radius: 10px;
        }
        .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background-color: #888;
        }
        .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
        }
        body {
            background-color: #f8f9fa;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa !important;
        }
        .dropdown-item strong {
            font-weight: 600;
        }
        .notification-text {
            font-size: 14px;
            color: #333;
        }
        .notification-message {
            font-size: 14px;
            color: #333;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }
        /* Efek shake untuk ikon notifikasi */
        .bi-bell-fill {
            transition: transform 0.2s ease;
        }
        .bi-bell-fill.shake {
            animation: shake 0.4s;
        }
        @keyframes shake {
            0% { transform: rotate(0); }
            25% { transform: rotate(-15deg); }
            50% { transform: rotate(15deg); }
            75% { transform: rotate(-10deg); }
            100% { transform: rotate(0); }
        }
        .notif-badge {
            font-size: 10px;
            padding: 2px 5px;
            position: absolute;
            top: 2px;
            right: 2px;
        }
    </style>
</head>
@stack('scripts')
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                
                <!-- Tombol Sidebar Mobile -->
                <button class="btn btn-outline-primary d-md-none me-2" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Brand -->
                <a class="navbar-brand fw-bold mx-auto d-md-block" href="{{ url('/') }}">
                    
                </a>

                <!-- Bagian kanan (notif & user) -->
                <div class="d-flex align-items-center">
                    @auth
                        <!-- Notifikasi -->
                        <div class="nav-item dropdown me-2">
                            <a id="notifDropdown" class="nav-link position-relative" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell-fill fs-5"></i>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span class="badge rounded-pill bg-danger notif-badge">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-2 shadow"
                                 style="width: 350px; max-height: 400px; overflow-y: auto;">
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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

        <!-- Content with Sidebar -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Desktop -->
                <div class="col-md-3 col-lg-2 d-none d-md-block bg-light p-0">
                    @include('layouts.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-md-9 col-lg-10 py-4">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Offcanvas Sidebar untuk Mobile -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
