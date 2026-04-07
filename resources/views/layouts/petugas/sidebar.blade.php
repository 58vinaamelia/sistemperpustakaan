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
                <div class="w-20 h-20 mb-3 rounded-full overflow-hidden">
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                         class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-20 h-20 mb-3 rounded-full bg-purple-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
            @endif

            <span class="bg-purple-600 text-white text-sm px-5 py-1 rounded-full">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>

        <!-- MENU -->
        <nav class="px-4 mt-4">
            <ul class="space-y-2 text-sm">

                @if(Auth::user()->role == 'petugas')

                {{-- DASHBOARD --}}
                <li>
                    <a href="/petugas/dashboard"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/dashboard') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-home text-lg"></i>
                        Dashboard
                    </a>
                </li>

                {{-- DATA BUKU --}}
                <li>
                    <a href="/petugas/buku"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/buku*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-book text-lg"></i>
                        Data Buku
                    </a>
                </li>

                {{-- DATA PEMINJAMAN --}}
                <li>
                    <a href="/petugas/peminjaman"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/peminjaman*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-briefcase text-lg"></i>
                        Data Peminjaman
                    </a>
                </li>

                {{-- DATA PENGEMBALIAN --}}
                <li>
                    <a href="/petugas/pengembalian"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/pengembalian*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-refresh text-lg"></i>
                        Data Pengembalian
                    </a>
                </li>

                {{-- DATA ANGGOTA --}}
                <li>
                    <a href="/petugas/anggota"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                       {{ request()->is('petugas/anggota*') ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-600 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                        <i class="ti ti-users text-lg"></i>
                        Data Anggota
                    </a>
                </li>

                @endif

            </ul>
        </nav>

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
