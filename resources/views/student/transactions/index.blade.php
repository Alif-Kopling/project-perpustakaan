@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi Saya')

@section('content')
<style>
    .modern-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .action-return {
        background-color: var(--soft-brown);
        color: white;
    }

    .action-extend {
        background-color: #3b82f6;
        color: white;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-dipinjam {
        background-color: #fef3c7;
        color: #d97706;
    }

    .status-dikembalikan {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-terlambat {
        background-color: #fecaca;
        color: #dc2626;
    }

    .search-input {
        border-radius: 9999px;
        padding-left: 2.5rem;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        border-color: var(--soft-brown);
        box-shadow: 0 0 0 3px rgba(196, 164, 132, 0.2);
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .table-container {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .table-header {
        background: linear-gradient(135deg, var(--soft-brown), var(--dark-tea-brown));
        color: white;
    }

    .pagination-links {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background-color: #f3f4f6;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination-link:hover {
        background-color: var(--soft-brown);
        color: white;
    }

    .pagination-link.active {
        background-color: var(--soft-brown);
        color: white;
    }

    .pagination-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        color: #9ca3af;
    }

    .book-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid var(--border-soft);
    }

    .book-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="modern-card card p-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman Saya</h3>
            <p class="text-gray-600">Lihat semua transaksi peminjaman buku yang pernah Anda lakukan</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Search Bar -->
    <form method="GET" action="{{ route('student.transactions.index') }}">
        <div class="mb-6 relative">
            <div class="absolute search-icon">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi berdasarkan judul buku..." class="search-input w-full py-3 pl-10 pr-4 border focus:outline-none focus:ring-2 focus:ring-soft-brown focus:border-transparent">
            @if(request('search'))
                <a href="{{ route('student.transactions.index') }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </div>
    </form>

    <div class="table-container overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="table-header">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Tanggal Kembali</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $index => $transaction)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $transaction->book->judul }}</div>
                        <div class="text-sm text-gray-500">{{ $transaction->book->penulis }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($transaction->return_date)
                            {{ \Carbon\Carbon::parse($transaction->return_date)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-badge
                            @if($transaction->status == 'dipinjam')
                                @php
                                    $borrowDate = \Carbon\Carbon::parse($transaction->borrow_date);
                                    $dueDate = $borrowDate->copy()->addDays(7);
                                    $isOverdue = \Carbon\Carbon::now()->gt($dueDate);
                                @endphp
                                @if($isOverdue)
                                    status-terlambat
                                @else
                                    status-dipinjam
                                @endif
                            @else
                                status-dikembalikan
                            @endif">
                            {{ $transaction->status == 'dipinjam' ? ($isOverdue ?? false ? 'Terlambat' : 'Dipinjam') : 'Dikembalikan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($transaction->status == 'dipinjam')
                            <form action="{{ route('student.transactions.return', $transaction) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="action-button action-return" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                    <i class="fas fa-undo mr-1"></i>Kembalikan
                                </button>
                            </form>
                        @else
                            <span class="text-green-600 font-medium">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-12 whitespace-nowrap text-center" colspan="6">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-history text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada riwayat transaksi</h3>
                            <p class="text-gray-500">Anda belum pernah melakukan peminjaman buku</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
    <div class="mt-6">
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($transactions->onFirstPage())
                <span class="pagination-link disabled opacity-50 cursor-not-allowed"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $transactions->previousPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($transactions->getUrlRange(max(1, $transactions->currentPage() - 2), min($transactions->lastPage(), $transactions->currentPage() + 2)) as $page => $url)
                @if ($page == $transactions->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($transactions->hasMorePages())
                <a href="{{ $transactions->nextPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="pagination-link disabled opacity-50 cursor-not-allowed"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
    // Add fade-in animation class
    document.addEventListener('DOMContentLoaded', function() {
        // Check for overdue transactions
        const statusBadges = document.querySelectorAll('.status-badge');
        statusBadges.forEach(badge => {
            if (badge.textContent.includes('Terlambat')) {
                badge.classList.add('status-terlambat');
                badge.classList.remove('status-dipinjam');
            }
        });
    });
</script>
@endsection