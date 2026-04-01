<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-gray-900 to-black min-h-screen flex items-center justify-center">

<div class="bg-white w-96 p-8 rounded-lg shadow-lg">

    <h2 class="text-center text-lg font-semibold mb-6">Login</h2>

    <form method="POST" action="/login" autocomplete="off">
        @csrf

        <!-- EMAIL -->
        <label class="text-sm">Email</label>
        <input type="email"
            name="email"
            placeholder="Email"
            autocomplete="username"
            class="w-full border rounded p-2 mt-1 mb-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

        <!-- PASSWORD -->
        <label class="text-sm">Password</label>
        <input type="password"
            name="password"
            placeholder="Password"
            autocomplete="new-password"
            class="w-full border rounded p-2 mt-1 mb-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

        <!-- BUTTON -->
        <button
            class="w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white py-2 rounded">
            Log in
        </button>

    </form>

    <hr class="my-4">

    <p class="text-center text-sm">
        <a href="/register" class="text-purple-600 hover:underline">
            Create account
        </a>
    </p>

</div>

</body>
</html>
