<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@if(session('success'))
<div class="bg-green-200 p-2 mb-3">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="bg-red-200 p-2 mb-3">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<body class="bg-gradient-to-b from-gray-900 to-black min-h-screen flex items-center justify-center">

<div class="bg-white w-96 p-8 rounded-lg shadow-lg">

    <h2 class="text-center text-lg font-semibold mb-6">
        Create account
    </h2>

    <form method="POST" action="/register">
        @csrf

        <!-- NAMA -->
        <label class="text-sm">Nama</label>
        <input type="text" name="name"
             placeholder="nama lengkap"
             class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

        <!-- EMAIL -->
        <label class="text-sm">Email</label>
        <input type="email" name="email"
            placeholder="email"
            class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

        <!-- PASSWORD -->
        <label class="text-sm">Password</label>
        <input type="password" name="password"
            placeholder="password"
            class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

        <!-- CONFIRM PASSWORD -->
        <label class="text-sm">Confirm password</label>
        <input type="password" name="password_confirmation"
            placeholder="confirm password"
            class="w-full border rounded p-2 mt-1 mb-4 focus:ring-2 focus:ring-purple-500">

        <!-- BUTTON -->
        <button
            class="w-full bg-gradient-to-r from-purple-500 to-purple-700 text-white py-2 rounded">
            Create account
        </button>

    </form>

    <hr class="my-4">

    <p class="text-center text-sm">
        <a href="/" class="text-purple-600 hover:underline">
            Already have an account? Login
        </a>
    </p>

</div>

</body>
</html>
