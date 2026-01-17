<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi Perpustakaan</title>
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
            <p class="text-gray-600 mt-2">Daftar akun baru</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

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

            <div class="mb-4">
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

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="nit" class="block text-gray-700 text-sm font-medium mb-2">NIT (Nomor Induk Siswa)</label>
                <input
                    type="text"
                    id="nit"
                    name="nit"
                    value="{{ old('nit') }}"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('nit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kelas" class="block text-gray-700 text-sm font-medium mb-2">Kelas</label>
                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    value="{{ old('kelas') }}"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('kelas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="jurusan" class="block text-gray-700 text-sm font-medium mb-2">Jurusan</label>
                <input
                    type="text"
                    id="jurusan"
                    name="jurusan"
                    value="{{ old('jurusan') }}"
                    class="input-field w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50"
                    required
                >
                @error('jurusan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full text-white py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 transform transition-transform duration-150 hover:scale-105">
                Daftar
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-gray-600 text-sm">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-soft-brown hover:underline">Login di sini</a>
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