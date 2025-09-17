@auth
<div class="d-flex flex-column p-2 bg-light h-100">
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-dark text-decoration-none">
        <span class="fs-6 fw-bold">Aplikasi</span>
    </a>
    <hr class="my-2">
    <ul class="nav nav-pills flex-column mb-auto small">
        @if(Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('users.index') }}" class="nav-link py-2 {{ request()->is('users*') ? 'active' : 'text-dark' }}">
                    Pengguna
                </a>
            </li>
            <li>
                <a href="{{ route('kelas.index') }}" class="nav-link py-2 {{ request()->is('kelas*') ? 'active' : 'text-dark' }}">
                    Kelas
                </a>
            </li>
        @endif

        @if(Auth::user()->role === 'guru')
            <li>
                <a href="{{ route('kelas.index') }}" class="nav-link py-2 {{ request()->is('kelas*') ? 'active' : 'text-dark' }}">
                    Kelas Saya
                </a>
            </li>
            <li>
                <a href="{{ route('tugas.index') }}" class="nav-link py-2 {{ request()->is('tugas*') ? 'active' : 'text-dark' }}">
                    Tugas
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.index') }}" class="nav-link py-2 {{ request()->is('bimbingan*') ? 'active' : 'text-dark' }}">
                    Bimbingan
                </a>
            </li>
        @endif

        @if(Auth::user()->role === 'siswa')
            <li>
                <a href="{{ route('kelas.index') }}" class="nav-link py-2 {{ request()->is('kelas*') ? 'active' : 'text-dark' }}">
                    Kelas Saya
                </a>
            </li>
            <li>
                <a href="{{ route('tugas.index') }}" class="nav-link py-2 {{ request()->is('tugas*') ? 'active' : 'text-dark' }}">
                    Tugas
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.index') }}" class="nav-link py-2 {{ request()->is('bimbingan*') ? 'active' : 'text-dark' }}">
                    Bimbingan
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.create') }}" class="nav-link py-2 {{ request()->is('bimbingan/create') ? 'active' : 'text-dark' }}">
                    Ajukan
                </a>
            </li>
        @endif

        @if(Auth::user()->role === 'wali')
            <li>
                <a href="{{ route('dashboard.wali') }}" class="nav-link py-2 {{ request()->is('wali/dashboard') ? 'active' : 'text-dark' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.index') }}" class="nav-link py-2 {{ request()->is('bimbingan*') ? 'active' : 'text-dark' }}">
                    Bimbingan
                </a>
            </li>
            <li>
                <a href="{{ route('bimbingan.create') }}" class="nav-link py-2 {{ request()->is('bimbingan/create') ? 'active' : 'text-dark' }}">
                    Ajukan
                </a>
            </li>
        @endif

        <li class="mt-2">
            <a href="{{ route('logout') }}" class="nav-link text-danger py-2"
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
