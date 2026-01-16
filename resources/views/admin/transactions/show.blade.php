@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $transaction->member->nama ?? '-' }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $transaction->member->kelas ?? '-' }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $transaction->book->judul ?? '-' }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
            <p class="bg-gray-50 p-3 rounded border">{{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d/m/Y') }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
            <p class="bg-gray-50 p-3 rounded border">
                @if($transaction->return_date)
                    {{ \Carbon\Carbon::parse($transaction->return_date)->format('d/m/Y') }}
                @else
                    -
                @endif
            </p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <p class="bg-gray-50 p-3 rounded border">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    @if($transaction->status == 'dipinjam') 
                        bg-yellow-100 text-yellow-800 
                    @else 
                        bg-green-100 text-green-800 
                    @endif">
                    {{ $transaction->status == 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                </span>
            </p>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('admin.transactions.index') }}" class="btn-secondary py-2 px-4 rounded">
            Kembali
        </a>
        @if($transaction->status == 'dipinjam')
            <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" class="inline-block">
                @csrf
                @method('PUT')
                <input type="hidden" name="return" value="1">
                <button type="submit" class="btn-success py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                    <i class="fas fa-undo mr-1"></i>Kembalikan Buku
                </button>
            </form>
        @endif
    </div>
</div>
@endsection