@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota Baru')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('nama') border-red-500 @enderror"
                    required
                >
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nit" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Teknis (NIT)</label>
                <input
                    type="text"
                    id="nit"
                    name="nit"
                    value="{{ old('nit') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('nit') border-red-500 @enderror"
                    required
                >
                @error('nit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <input
                    type="text"
                    id="kelas"
                    name="kelas"
                    value="{{ old('kelas') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('kelas') border-red-500 @enderror"
                    required
                >
                @error('kelas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <input
                    type="text"
                    id="jurusan"
                    name="jurusan"
                    value="{{ old('jurusan') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('jurusan') border-red-500 @enderror"
                    required
                >
                @error('jurusan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('username') border-red-500 @enderror"
                    required
                >
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.members.index') }}" class="btn-secondary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                Batal
            </a>
            <button type="submit" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection