@extends('layouts.app')

@section('title', 'Peminjaman Baru')
@section('page-title', 'Form Peminjaman Buku')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <form action="{{ route('admin.transactions.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota</label>
                <select 
                    id="member_id" 
                    name="member_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('member_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Pilih Anggota</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->nama }} ({{ $member->kelas }})
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                <select 
                    id="book_id" 
                    name="book_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('book_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Pilih Buku</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->judul }} (Stok: {{ $book->stok }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                <input 
                    type="date" 
                    id="borrow_date" 
                    name="borrow_date" 
                    value="{{ old('borrow_date', date('Y-m-d')) }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 @error('borrow_date') border-red-500 @enderror"
                    required
                >
                @error('borrow_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.transactions.index') }}" class="btn-secondary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                Batal
            </a>
            <button type="submit" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection