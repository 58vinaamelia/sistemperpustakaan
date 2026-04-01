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
            <ul class="space-y-0 text-sm">

                {{-- PETUGAS --}}
                @if(Auth::user()->role == 'petugas')

                <li>
                    <a href="/petugas/dashboard"
                       class="flex items-center gap-3 px-2 py-1.5 text-gray-500 font-medium transition
                       {{ request()->is('petugas/dashboard') ? 'text-gray-800 font-semibold' : 'hover:text-gray-800' }}">
                        <i class="ti ti-home text-lg"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="/petugas/buku"
                       class="flex items-center gap-3 px-2 py-1.5 text-gray-500 font-medium transition
                       {{ request()->is('petugas/buku*') ? 'text-gray-800 font-semibold' : 'hover:text-gray-800' }}">
                        <i class="ti ti-book text-lg"></i>
                        Data Buku
                    </a>
                </li>

                <li>
                    <a href="/petugas/peminjaman"
                       class="flex items-center gap-3 px-2 py-1.5 text-gray-500 font-medium transition
                       {{ request()->is('petugas/peminjaman*') ? 'text-gray-800 font-semibold' : 'hover:text-gray-800' }}">
                        <i class="ti ti-briefcase text-lg"></i>
                        Data Peminjam
                    </a>
                </li>

                <li>
                    <a href="/petugas/pengembalian"
                       class="flex items-center gap-3 px-2 py-1.5 text-gray-500 font-medium transition
                       {{ request()->is('petugas/pengembalian*') ? 'text-gray-800 font-semibold' : 'hover:text-gray-800' }}">
                        <i class="ti ti-refresh text-lg"></i>
                        Data Pengembalian
                    </a>
                </li>

                <li>
                    <a href="/petugas/denda"
                       class="flex items-center gap-3 px-2 py-1.5 text-gray-500 font-medium transition
                       {{ request()->is('petugas/denda*') ? 'text-gray-800 font-semibold' : 'hover:text-gray-800' }}">
                        <i class="ti ti-file-text text-lg"></i>
                        Menerima Denda
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
