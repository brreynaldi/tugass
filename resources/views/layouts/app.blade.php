<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aplikasi Tugas') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">

    <style>
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
    </style>
</head>
@stack('scripts')
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
               
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        @auth
                            <li class="nav-item dropdown">
                                <a id="notifDropdown" class="nav-link dropdown-toggle position-relative" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    🔔
                                    @if (Auth::user()->unreadNotifications->count() > 0)
                                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                            {{ Auth::user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end p-2 shadow" aria-labelledby="notifDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
                                    <h6 class="dropdown-header">📢 Notifikasi</h6>
                                    <div class="dropdown-divider"></div>

                                    @forelse (Auth::user()->unreadNotifications as $notification)
                                 
                                        <div class="dropdown-item d-flex flex-column mb-2 rounded bg-light p-2 small">
                                            <strong class="text-dark mb-1">🔔 Notifikasi</strong>
                                            <span class="text-muted">{{ $notification->data['pesan'] ?? 'Pesan tidak tersedia' }}</span>
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
                            </li>
                            @endauth



                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content with Sidebar -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 p-0">
                    @include('layouts.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-md-9 py-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
