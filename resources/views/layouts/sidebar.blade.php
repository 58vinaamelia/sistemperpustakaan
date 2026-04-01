<aside class="w-64 bg-white shadow-sm min-h-screen flex flex-col">

    <!-- ATAS -->
    <div>
        <!-- HEADER (DITURUNKAN LEBIH JAUH) -->
        <div class="pt-28 pb-6 text-center">
            <h1 class="text-xl font-bold text-gray-800 tracking-wide">
                 Perpustakaan
            </h1>
        </div>

        <!-- PROFILE -->
        <div class="flex flex-col items-center py-6">
            @if(Auth::user()->photo)
                <div class="w-20 h-20 mb-3 rounded-full overflow-hidden flex-none">
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                         class="w-full h-full object-cover object-center">
                </div>
            @else
                <div class="w-20 h-20 mb-3 rounded-full bg-purple-600 flex items-center justify-center flex-none">
                    <span class="text-white text-2xl font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
            @endif

            <!-- LABEL ROLE DITURUNKAN SEDIKIT -->
            <span class="bg-purple-600 text-white text-sm px-5 py-1 rounded-full mt-2">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </div>

    <!-- MENU (DITENGAH) -->
    <nav class="px-4 mt-auto mb-auto">
        <ul class="space-y-2 text-sm">

            {{-- ANGGOTA --}}
            @if(Auth::user()->role == 'anggota')
                <li>
                    <a href="/anggota/dashboard"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('anggota/dashboard') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-home text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/anggota/buku"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('anggota/buku*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-book-2 text-xl"></i>
                        Buku
                    </a>
                </li>
                <li>
                    <a href="/anggota/peminjaman"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('anggota/peminjaman*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-stack-2 text-xl"></i>
                        Peminjaman
                    </a>
                </li>
                <li>
                    <a href="/anggota/pengembalian"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('anggota/pengembalian*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-refresh text-lg"></i>
                        Pengembalian
                    </a>
                </li>
            @endif

            {{-- PETUGAS --}}
            @if(Auth::user()->role == 'petugas')
                <li>
                    <a href="/petugas/dashboard"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/dashboard') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-home text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/petugas/buku"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/buku*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-book-2 text-xl"></i>
                        Buku
                    </a>
                </li>
                <li>
                    <a href="/petugas/peminjaman"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/peminjaman*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-stack-2 text-xl"></i>
                        Peminjaman
                    </a>
                </li>
                <li>
                    <a href="/petugas/pengembalian"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/pengembalian*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-refresh text-lg"></i>
                        Pengembalian
                    </a>
                </li>
            @endif

        </ul>
    </nav>

    <!-- LOGOUT -->
    <div class="px-4 py-6 border-t">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-red-500 hover:bg-red-50">
                <i class="ti ti-logout text-lg"></i>
                Logout
            </button>
        </form>
    </div>

</aside>
