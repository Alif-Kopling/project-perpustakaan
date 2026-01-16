@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('page-title', 'Daftar Buku')

@section('content')
<div class="card p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Semua Buku Tersedia</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($books as $book)
        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
            <h4 class="font-semibold text-lg">{{ $book->judul }}</h4>
            <p class="text-gray-600 text-sm">Penulis: {{ $book->penulis }}</p>
            <p class="text-gray-600 text-sm">Penerbit: {{ $book->penerbit }}</p>
            <p class="text-gray-800 font-medium mt-2">Stok: {{ $book->stok }}</p>
            <div class="mt-4">
                @if($book->stok > 0)
                    <button class="btn-primary py-1 px-3 rounded text-sm">Pinjam</button>
                @else
                    <button class="btn-secondary py-1 px-3 rounded text-sm" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center col-span-full py-8 text-gray-500">
            <p>Belum ada data buku</p>
        </div>
        @endforelse
    </div>
</div>
@endsection