@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi Saya')

@section('content')
<div class="card p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Riwayat Peminjaman</h3>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $index => $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->book->judul }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($transaction->return_date)
                            {{ \Carbon\Carbon::parse($transaction->return_date)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($transaction->status == 'dipinjam') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ $transaction->status == 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($transaction->status == 'dipinjam')
                            <span class="text-gray-500">Menunggu pengembalian</span>
                        @else
                            <span class="text-green-500">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap" colspan="6">
                        <div class="text-center text-gray-500 py-4">Belum ada riwayat transaksi</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection