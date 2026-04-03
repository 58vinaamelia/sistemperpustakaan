<aside class="w-64 bg-white shadow-sm min-h-screen flex flex-col">

    <div>
        <!-- HEADER -->
        <div class="py-8 text-center border-b">
            <h1 class="text-xl font-bold text-gray-800 leading-tight">
                Sistem <br> Perpustakaan
            </h1>
        </div>

        <!-- PROFILE -->
        <div class="flex flex-col items-center py-6 border-b">
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
        <nav class="px-6 mt-4">
            <ul class="space-y-1 text-sm">

                @php
                    $role = strtolower(trim(Auth::user()->role));
                @endphp

                {{-- ================= PETUGAS ================= --}}
                @if($role == 'petugas')

                <li>
                    <a href="/petugas/dashboard"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('petugas/dashboard') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-home text-lg"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="/petugas/laporan"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('petugas/laporan*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-file-report text-lg"></i>
                        Laporan
                    </a>
                </li>

                <li>
                    <a href="/petugas/petugas/create"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('petugas/petugas/create') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-user-plus text-lg"></i>
                        Tambah Petugas
                    </a>
                </li>

                <li>
                    <a href="/petugas/buku"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('petugas/buku*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-book text-lg"></i>
                        Data Buku
                    </a>
                </li>

                <li>
                    <a href="/petugas/anggota"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('petugas/anggota*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-users text-lg"></i>
                        Data Anggota
                    </a>
                </li>

                @endif


                {{-- ================= KEPALA ================= --}}
                @if($role == 'kepala')

                <li>
                    <a href="/kepala/dashboard"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('kepala/dashboard') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-home text-lg"></i>
                        Dashboard
                    </a>
                </li>

                <!-- ✅ LAPORAN (CUMA 1) -->
                <li>
                    <a href="/kepala/laporan"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('kepala/laporan*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-file-report text-lg"></i>
                        Laporan
                    </a>
                </li>

                <li>
                    <a href="/kepala/petugas/create"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('kepala/petugas/create') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-user-plus text-lg"></i>
                        Tambah Petugas
                    </a>
                </li>

                <li>
                    <a href="/kepala/buku"
                       class="flex items-center gap-3 px-2 py-2 rounded-lg transition
                       {{ request()->is('kepala/buku*') ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="ti ti-book text-lg"></i>
                        Katalog Buku
                    </a>
                </li>

                @endif

            </ul>
        </nav>
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
