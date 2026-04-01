<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center"
      style="background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f');">

    <!-- Overlay gelap -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Card Login -->
    <div class="relative backdrop-blur-md bg-white/80 w-96 p-8 rounded-xl shadow-2xl">

        <h2 class="text-center text-xl font-bold mb-6 text-gray-800">
            Login
        </h2>

        <form method="POST" action="/login" autocomplete="off">
            @csrf

            <!-- EMAIL -->
            <label class="text-sm text-gray-700">Email</label>
            <input type="email"
                name="email"
                placeholder="Email"
                autocomplete="username"
                class="w-full border rounded p-2 mt-1 mb-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

            <!-- PASSWORD -->
            <label class="text-sm text-gray-700">Password</label>
            <input type="password"
                name="password"
                placeholder="Password"
                autocomplete="new-password"
                class="w-full border rounded p-2 mt-1 mb-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

            <!-- BUTTON -->
            <button
                class="w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white py-2 rounded hover:opacity-90 transition">
                Log in
            </button>

        </form>

        <hr class="my-4">

        <p class="text-center text-sm text-gray-700">
            <a href="/register" class="text-purple-600 hover:underline">
                Create account
            </a>
        </p>

    </div>

</body>
</html>
