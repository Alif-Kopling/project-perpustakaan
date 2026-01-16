@extends('layouts.app')

@section('title', 'Detail Buku')
@section('page-title', 'Detail Buku')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $book->judul }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $book->penulis }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $book->penerbit }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $book->kategori }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $book->stok }}</p>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('admin.books.index') }}" class="btn-secondary py-2 px-4 rounded">
            Kembali
        </a>
        <a href="{{ route('admin.books.edit', $book) }}" class="btn-primary py-2 px-4 rounded">
            Edit
        </a>
    </div>
</div>
@endsection