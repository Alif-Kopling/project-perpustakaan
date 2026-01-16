@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')

@section('content')
<div class="card p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Kelola Transaksi</h3>
        <a href="{{ route('admin.transactions.create') }}" class="btn-primary py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i>Peminjaman Baru
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Anggota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->member->nama ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->book->judul ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($transaction->return_date)
                            {{ \Carbon\Carbon::parse($transaction->return_date)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($transaction->status == 'dipinjam') 
                                bg-yellow-100 text-yellow-800 
                            @else 
                                bg-green-100 text-green-800 
                            @endif">
                            {{ $transaction->status == 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($transaction->status == 'dipinjam')
                            <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="return" value="1">
                                <button type="submit" class="btn-success py-1 px-3 rounded text-sm" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                    <i class="fas fa-undo mr-1"></i>Kembalikan
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-center" colspan="7">
                        <div class="text-gray-500">Belum ada data transaksi</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection