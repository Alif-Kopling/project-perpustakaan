@extends('layouts.app')

@section('title', 'Siswa Dashboard')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Card Buku Dipinjam -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Buku Sedang Dipinjam</p>
                <h3 class="text-2xl font-bold">{{ $borrowedBooks->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Buku Dikembalikan -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Buku Dikembalikan</p>
                <h3 class="text-2xl font-bold">{{ $returnedBooks }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 card p-6">
    <h3 class="text-lg font-semibold mb-4">Riwayat Peminjaman Terakhir</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($borrowedBooks as $transaction)
                <tr>
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
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap" colspan="4">
                        <div class="text-center text-gray-500 py-4">Belum ada riwayat peminjaman</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection