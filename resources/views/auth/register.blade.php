<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center"
      style="background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Card -->
    <div class="relative backdrop-blur-md bg-white/80 w-96 p-8 rounded-xl shadow-2xl">

        <h2 class="text-center text-xl font-bold mb-6 text-gray-800">
            Create account
        </h2>

        <!-- ALERT -->
        @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-3 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-3 rounded">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <!-- NAMA -->
            <label class="text-sm text-gray-700">Nama</label>
            <input type="text" name="name"
                placeholder="Nama lengkap"
                class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

            <!-- EMAIL -->
            <label class="text-sm text-gray-700">Email</label>
            <input type="email" name="email"
                placeholder="Email"
                class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

            <!-- PASSWORD -->
            <label class="text-sm text-gray-700">Password</label>
            <input type="password" name="password"
                placeholder="Password"
                class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

            <!-- CONFIRM PASSWORD -->
            <label class="text-sm text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation"
                placeholder="Confirm Password"
                class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

            <!-- BUTTON -->
            <button
                class="w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white py-2 rounded hover:opacity-90 transition">
                Create account
            </button>

        </form>

        <hr class="my-4">

        <p class="text-center text-sm text-gray-700">
            <a href="/login" class="text-purple-600 hover:underline">
                Already have an account? Login
            </a>
        </p>

    </div>

</body>
</html>
