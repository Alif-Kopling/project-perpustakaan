@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <form action="{{ route('admin.books.update', $book) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                <input 
                    type="text" 
                    id="judul" 
                    name="judul" 
                    value="{{ old('judul', $book->judul) }}" 
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
                    value="{{ old('penulis', $book->penulis) }}" 
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
                    value="{{ old('penerbit', $book->penerbit) }}"
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
                    <option value="novel" {{ old('kategori', $book->kategori) == 'novel' ? 'selected' : '' }}>Novel</option>
                    <option value="kimia" {{ old('kategori', $book->kategori) == 'kimia' ? 'selected' : '' }}>Kimia</option>
                    <option value="fisika" {{ old('kategori', $book->kategori) == 'fisika' ? 'selected' : '' }}>Fisika</option>
                    <option value="biologi" {{ old('kategori', $book->kategori) == 'biologi' ? 'selected' : '' }}>Biologi</option>
                    <option value="matematika" {{ old('kategori', $book->kategori) == 'matematika' ? 'selected' : '' }}>Matematika</option>
                    <option value="sejarah" {{ old('kategori', $book->kategori) == 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                    <option value="geografi" {{ old('kategori', $book->kategori) == 'geografi' ? 'selected' : '' }}>Geografi</option>
                    <option value="bahasa" {{ old('kategori', $book->kategori) == 'bahasa' ? 'selected' : '' }}>Bahasa</option>
                    <option value="lainnya" {{ old('kategori', $book->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                    value="{{ old('stok', $book->stok) }}"
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
                Update
            </button>
        </div>
    </form>
</div>
@endsection