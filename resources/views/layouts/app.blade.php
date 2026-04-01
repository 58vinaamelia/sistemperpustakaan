<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perpus Digital</title>

    <!-- Tailwind CSS (punya kamu) -->
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Bootstrap CSS (tambahan biar tabel + card + btn muncul) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex flex-col flex-1 w-full">

        @include('layouts.header')

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto">
            <div class="container px-6 mx-auto py-6">
                @yield('content')
            </div>
        </main>

        <!-- FOOTER -->
        @include('layouts.footer')

    </div>
</div>

<!-- Bootstrap JS (buat tombol, dropdown, dll) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
