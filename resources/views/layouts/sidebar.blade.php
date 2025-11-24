<ul class="nav nav-pills flex-column mb-auto px-2">
    <li class="brand text-white fw-bold mb-4 d-flex align-items-center">
        <i class="bi bi-grid-fill me-2"></i>
        <span class="link-text">Aplikasi PR</span>
    </li>

    @if(Auth::user()->role === 'admin')
        <li>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : 'text-white' }}">
                <i class="bi bi-people-fill"></i>
                <span class="link-text">Pengguna</span>
            </a>
        </li>
         <li>
            <a href="{{ route('tugas.index') }}" class="nav-link {{ request()->is('tugas*') ? 'active' : 'text-white' }}">
                <i class="bi bi-list-check"></i>
                <span class="link-text">Tugas</span>
            </a>
        </li>
        <li>
            <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : 'text-white' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span class="link-text">Kelas</span>
            </a>
        </li>
    @endif

    @if(Auth::user()->role === 'guru')
        <li>
            <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : 'text-white' }}">
                <i class="bi bi-easel-fill"></i>
                <span class="link-text">Kelas Saya</span>
            </a>
        </li>
        <li>
            <a href="{{ route('tugas.index') }}" class="nav-link {{ request()->is('tugas*') ? 'active' : 'text-white' }}">
                <i class="bi bi-list-check"></i>
                <span class="link-text">Tugas</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bimbingan.index') }}" class="nav-link {{ request()->is('bimbingan*') ? 'active' : 'text-white' }}">
                <i class="bi bi-chat-dots-fill"></i>
                <span class="link-text">Bimbingan</span>
            </a>
        </li>
    @endif

    @if(Auth::user()->role === 'siswa')
        <li>
            <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : 'text-white' }}">
                <i class="bi bi-easel-fill"></i>
                <span class="link-text">Kelas Saya</span>
            </a>
        </li>
        <li>
            <a href="{{ route('tugas.index') }}" class="nav-link {{ request()->is('tugas*') ? 'active' : 'text-white' }}">
                <i class="bi bi-list-task"></i>
                <span class="link-text">Tugas</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bimbingan.index') }}" class="nav-link {{ request()->is('bimbingan*') ? 'active' : 'text-white' }}">
                <i class="bi bi-chat-left-text-fill"></i>
                <span class="link-text">Bimbingan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bimbingan.create') }}" class="nav-link {{ request()->is('bimbingan/create') ? 'active' : 'text-white' }}">
                <i class="bi bi-pencil-square"></i>
                <span class="link-text">Ajukan</span>
            </a>
        </li>
    @endif

    @if(Auth::user()->role === 'wali')
        <li>
            <a href="{{ route('dashboard.wali') }}" class="nav-link {{ request()->is('wali/dashboard') ? 'active' : 'text-white' }}">
                <i class="bi bi-speedometer2"></i>
                <span class="link-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bimbingan.index') }}" class="nav-link {{ request()->is('bimbingan*') ? 'active' : 'text-white' }}">
                <i class="bi bi-chat-dots-fill"></i>
                <span class="link-text">Bimbingan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('bimbingan.create') }}" class="nav-link {{ request()->is('bimbingan/create') ? 'active' : 'text-white' }}">
                <i class="bi bi-plus-circle-fill"></i>
                <span class="link-text">Ajukan</span>
            </a>
        </li>
    @endif

    <li class="mt-3">
        <a href="{{ route('logout') }}" class="nav-link text-danger fw-bold"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span class="link-text">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>
