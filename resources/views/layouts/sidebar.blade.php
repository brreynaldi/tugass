@auth
<div class="d-flex flex-column p-3 bg-light" style="width: 250px; height: 100vh;">
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Aplikasi Tugas</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        @if(Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : 'text-dark' }}">
                    Manajemen Pengguna
                </a>
            </li>
            <li>
                <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : 'text-dark' }}">
                    Manajemen Kelas
                </a>
            </li>
        @endif

        @if(Auth::user()->role === 'guru')
            <li>
                <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : 'text-dark' }}">
                    Kelas Saya
                </a>
            </li>
            <li>
                <a href="{{ route('tugas.index') }}" class="nav-link {{ request()->is('tugas*') ? 'active' : 'text-dark' }}">
                    Kelola Tugas
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.index') }}" class="nav-link {{ request()->is('bimbingan*') ? 'active' : 'text-dark' }}">
                    Bimbingan
                </a>
            </li>
        @endif

        @if(Auth::user()->role === 'siswa')
            <li>
                <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : 'text-dark' }}">
                    Kelas Saya
                </a>
            </li>
            <li>
                <a href="{{ route('tugas.index') }}" class="nav-link {{ request()->is('tugas*') ? 'active' : 'text-dark' }}">
                    Tugas
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.index') }}" class="nav-link {{ request()->is('bimbingan*') ? 'active' : 'text-dark' }}">
                    Bimbingan
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.create') }}" class="nav-link {{ request()->is('bimbingan/create') ? 'active' : 'text-dark' }}">
                    Ajukan Bimbingan
                </a>
            </li>
        @endif

        @if(Auth::user()->role === 'wali')
            <li>
                <a href="{{ route('dashboard.wali') }}" class="nav-link {{ request()->is('wali/dashboard') ? 'active' : 'text-dark' }}">
                    Dashboard Wali
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.index') }}" class="nav-link {{ request()->is('bimbingan*') ? 'active' : 'text-dark' }}">
                    Bimbingan
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.create') }}" class="nav-link {{ request()->is('bimbingan/create') ? 'active' : 'text-dark' }}">
                    Ajukan Bimbingan
                </a>
            </li>
        @endif

        <li class="mt-3">
            <a href="{{ route('logout') }}" class="nav-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
@endauth
