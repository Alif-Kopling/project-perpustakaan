@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku Baru')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                <input 
                    type="text" 
                    id="judul" 
                    name="judul" 
                    value="{{ old('judul') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('judul') border-red-500 @enderror"
                    required
                >
                @error('judul')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="penulis" class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                <input 
                    type="text" 
                    id="penulis" 
                    name="penulis" 
                    value="{{ old('penulis') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('penulis') border-red-500 @enderror"
                    required
                >
                @error('penulis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                <input
                    type="text"
                    id="penerbit"
                    name="penerbit"
                    value="{{ old('penerbit') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('penerbit') border-red-500 @enderror"
                    required
                >
                @error('penerbit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select
                    id="kategori"
                    name="kategori"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('kategori') border-red-500 @enderror"
                    required
                >
                    <option value="">Pilih Kategori</option>
                    <option value="novel" {{ old('kategori') == 'novel' ? 'selected' : '' }}>Novel</option>
                    <option value="kimia" {{ old('kategori') == 'kimia' ? 'selected' : '' }}>Kimia</option>
                    <option value="fisika" {{ old('kategori') == 'fisika' ? 'selected' : '' }}>Fisika</option>
                    <option value="biologi" {{ old('kategori') == 'biologi' ? 'selected' : '' }}>Biologi</option>
                    <option value="matematika" {{ old('kategori') == 'matematika' ? 'selected' : '' }}>Matematika</option>
                    <option value="sejarah" {{ old('kategori') == 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                    <option value="geografi" {{ old('kategori') == 'geografi' ? 'selected' : '' }}>Geografi</option>
                    <option value="bahasa" {{ old('kategori') == 'bahasa' ? 'selected' : '' }}>Bahasa</option>
                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <input
                    type="number"
                    id="stok"
                    name="stok"
                    value="{{ old('stok', 0) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('stok') border-red-500 @enderror"
                    min="0"
                    required
                >
                @error('stok')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.books.index') }}" class="btn-secondary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                Batal
            </a>
            <button type="submit" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection