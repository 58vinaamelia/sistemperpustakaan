<aside class="w-64 bg-white shadow-sm min-h-screen flex flex-col">

    <!-- ATAS -->
    <div class="mt-6">

        <!-- HEADER -->
        <div class="pt-6 pb-2 text-center">
            <h1 class="text-xl font-bold text-gray-800 leading-tight">
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

            @if(Auth::user()->role == 'petugas')

            {{-- DASHBOARD --}}
            <li>
                <a href="/petugas/dashboard"
                class="menu-item {{ request()->is('petugas/dashboard') ? 'active' : '' }}">
                    <i class="ti ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- DATA BUKU --}}
            <li>
                <a href="/petugas/buku"
                   class="menu-item {{ request()->is('petugas/buku*') ? 'active' : '' }}">
                    <i class="ti ti-book-filled"></i>
                    <span>Data Buku</span>
                </a>
            </li>

            {{-- DATA PEMINJAMAN --}}
            <li>
                <a href="/petugas/peminjaman"
                   class="menu-item {{ request()->is('petugas/peminjaman*') ? 'active' : '' }}">
                    <i class="ti ti-clipboard-text"></i>
                    <span>Data Peminjaman</span>
                </a>
            </li>

            {{-- DATA PENGEMBALIAN --}}
            <li>
                <a href="/petugas/pengembalian"
                   class="menu-item {{ request()->is('petugas/pengembalian*') ? 'active' : '' }}">
                    <i class="ti ti-refresh-dot"></i>
                    <span>Data Pengembalian</span>
                </a>
            </li>

            {{-- DATA ANGGOTA --}}
            <li>
                <a href="/petugas/anggota"
                   class="menu-item {{ request()->is('petugas/anggota*') ? 'active' : '' }}">
                    <i class="ti ti-users"></i>
                    <span>Data Anggota</span>
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
    <div class="px-4 py-6 border-t mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-red-500 hover:bg-red-50 transition">
                <i class="ti ti-logout text-lg"></i>
                Logout
            </button>
        </form>
    </div>

</aside>
