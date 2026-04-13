<aside class="w-64 bg-white shadow-sm min-h-screen flex flex-col">

    <div class="mt-6">
        <!-- HEADER -->
       <div class="pt-6 pb-2 text-center">
            <h1 class="text-xl font-bold text-gray-800 tracking-wide">
                Sistem Perpustakaan
            </h1>
        </div>
        <!-- PROFILE -->
        <div class="flex flex-col items-center pt-2 pb-4">
            @if(Auth::user()->photo)
                <div class="w-20 h-20 mb-3 rounded-full overflow-hidden flex-none">
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                        class="w-full h-full object-cover object-center">
                </div>
            @else
                <div class="w-20 h-20 mb-3 rounded-full bg-purple-600 flex items-center justify-center flex-none">
                    <img src="{{ asset('storage/tumpukanbuku.jpg') }}"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
            @endif

            <span class="bg-purple-600 text-white text-sm px-5 py-1 rounded-full">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>

        <!-- MENU -->
        <nav class="px-4 flex-1 flex justify-center items-center">

    <!-- BACKGROUND UNGU -->
    <div style="
        background:#6d28d9;
        border-radius:16px;
        padding:30px 20px;
        width:100%;
        max-width:230px;
    ">

        <ul style="
            display:flex;
            flex-direction:column;
            gap:20px;
        ">

            @php
                $role = strtolower(trim(Auth::user()->role));
            @endphp

            {{-- ================= PETUGAS ================= --}}
            @if($role == 'petugas')

            <li>
                <a href="/petugas/dashboard"
                   class="menu-item {{ request()->is('petugas/dashboard') ? 'active' : '' }}">
                    <i class="ti ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="/petugas/laporan"
                   class="menu-item {{ request()->is('petugas/laporan*') ? 'active' : '' }}">
                    <i class="ti ti-file-report"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <li>
                <a href="/petugas/petugas/create"
                   class="menu-item {{ request()->is('petugas/petugas/create') ? 'active' : '' }}">
                    <i class="ti ti-user-plus"></i>
                    <span>Tambah Petugas</span>
                </a>
            </li>

            <li>
                <a href="/petugas/buku"
                   class="menu-item {{ request()->is('petugas/buku*') ? 'active' : '' }}">
                    <i class="ti ti-book"></i>
                    <span>Data Buku</span>
                </a>
            </li>

            <li>
                <a href="/petugas/anggota"
                   class="menu-item {{ request()->is('petugas/anggota*') ? 'active' : '' }}">
                    <i class="ti ti-users"></i>
                    <span>Data Anggota</span>
                </a>
            </li>

            @endif


            {{-- ================= KEPALA ================= --}}
            @if($role == 'kepala')

            <li>
                <a href="/kepala/dashboard"
                   class="menu-item {{ request()->is('kepala/dashboard') ? 'active' : '' }}">
                    <i class="ti ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="/kepala/laporan"
                   class="menu-item {{ request()->is('kepala/laporan*') ? 'active' : '' }}">
                    <i class="ti ti-file-report"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('kepala.petugas.index') }}"
                   class="menu-item {{ request()->is('kepala/petugas') ? 'active' : '' }}">
                    <i class="ti ti-users"></i>
                    <span>Petugas</span>
                </a>
            </li>

            <li>
                <a href="/kepala/buku"
                   class="menu-item {{ request()->is('kepala/buku*') ? 'active' : '' }}">
                    <i class="ti ti-book"></i>
                    <span>Katalog Buku</span>
                </a>
            </li>

            @endif

        </ul>

    </div>

</nav>

<style>
.menu-item {
    display: flex;
    align-items: center;
    gap: 16px;
    color: white;
    font-size: 14px;
    text-decoration: none;
    padding: 10px 12px;
    border-radius: 10px;
    transition: 0.2s;
}

/* ICON STIKER */
.menu-item i {
    font-size: 20px;
    background: rgba(255,255,255,0.2);
    padding: 6px;
    border-radius: 8px;
    color: white;
}

/* HOVER */
.menu-item:hover {
    background: rgba(255,255,255,0.15);
}

/* ACTIVE */
.menu-item.active {
    background: white;
    color: #6d28d9;
    font-weight: 600;
}

.menu-item.active i {
    background: #6d28d9;
    color: white;
}
</style>
    </div>

    <!-- LOGOUT -->
    <div class="px-6 py-6 border-t mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-2 py-2 text-red-500 hover:bg-red-50 rounded-lg">
                <i class="ti ti-logout text-lg"></i>
                Logout
            </button>
        </form>
    </div>

</aside>
