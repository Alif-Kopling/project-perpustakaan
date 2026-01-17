<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F5EFE6; /* Cream */
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background-color: #FFFFFF; /* White */
            border: 1px solid #D6D3CE; /* Border Soft */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .btn-primary {
            background-color: #C4A484; /* Soft Brown */
        }
        .btn-primary:hover {
            background-color: #8B6F47; /* Dark Tea Brown */
        }
        .input-field:focus {
            border-color: #C4A484; /* Soft Brown */
            outline: none;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md login-card rounded-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Aplikasi Perpustakaan</h1>
            <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full text-white py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 transform transition-transform duration-150 hover:scale-105">
                Login
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-gray-600 text-sm">
                Belum punya akun? <a href="{{ route('register') }}" class="text-soft-brown hover:underline">Daftar sekarang</a>
            </p>
        </div>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                © {{ date('Y') }} Aplikasi Perpustakaan. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>