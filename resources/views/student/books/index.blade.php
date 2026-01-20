@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('page-title', 'Daftar Buku')

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

    .action-borrow {
        background: linear-gradient(135deg, var(--soft-brown), var(--dark-tea-brown));
        color: white;
    }

    .action-borrow:disabled {
        background: #d1d5db;
        color: #6b7280;
        cursor: not-allowed;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .stock-available {
        background-color: #d1fae5;
        color: #065f46;
    }

    .stock-low {
        background-color: #fef3c7;
        color: #d97706;
    }

    .stock-empty {
        background-color: #fee2e2;
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

    .book-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid var(--border-soft);
        background: white;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .book-cover {
        height: 200px;
        background: linear-gradient(135deg, var(--soft-brown), var(--dark-tea-brown));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
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

    .filter-section {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .filter-button {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        background-color: #f3f4f6;
        color: #374151;
        transition: all 0.2s ease;
    }

    .filter-button.active {
        background-color: var(--soft-brown);
        color: white;
    }
</style>

<div class="modern-card card p-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Semua Buku Tersedia</h3>
            <p class="text-gray-600">Jelajahi koleksi buku yang dapat Anda pinjam</p>
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

    <!-- Search and Filter Bar -->
    <form method="GET" action="{{ route('student.books.index') }}">
        <div class="mb-6 relative">
            <div class="absolute search-icon">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku berdasarkan judul, penulis, atau kategori..." class="search-input w-full py-3 pl-10 pr-4 border focus:outline-none focus:ring-2 focus:ring-soft-brown focus:border-transparent">
            @if(request('search'))
                <a href="{{ route('student.books.index') }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </div>
    </form>

    <!-- Filter Section -->
    <div class="filter-section mb-6">
        <div class="flex flex-wrap gap-2">
            <button class="filter-button active">Semua</button>
            <button class="filter-button">Fiksi</button>
            <button class="filter-button">Non-Fiksi</button>
            <button class="filter-button">Pendidikan</button>
            <button class="filter-button">Novel</button>
            <button class="filter-button">Komik</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($books as $book)
        <div class="book-card">
            <div class="book-cover">
                <i class="fas fa-book"></i>
            </div>
            <div class="p-5">
                <h4 class="font-bold text-lg text-gray-800 mb-2">{{ $book->judul }}</h4>
                <p class="text-gray-600 text-sm mb-1"><span class="font-medium">Penulis:</span> {{ $book->penulis }}</p>
                <p class="text-gray-600 text-sm mb-1"><span class="font-medium">Penerbit:</span> {{ $book->penerbit }}</p>
                <p class="text-gray-600 text-sm mb-3"><span class="font-medium">Kategori:</span> {{ $book->kategori }}</p>

                <div class="flex justify-between items-center mb-4">
                    <span class="status-badge
                        @if($book->stok > 5)
                            stock-available
                        @elseif($book->stok > 0)
                            stock-low
                        @else
                            stock-empty
                        @endif">
                        Stok: {{ $book->stok }}
                    </span>

                    @if($book->stok > 0)
                        <span class="text-green-600 font-medium">Tersedia</span>
                    @else
                        <span class="text-red-600 font-medium">Habis</span>
                    @endif
                </div>

                <div class="mt-4">
                    @if($book->stok > 0)
                        <!-- Button to open modal -->
                        <button onclick="openBorrowModal({{ $book->id }}, '{{ addslashes($book->judul) }}')" class="action-button action-borrow w-full justify-center">
                            <i class="fas fa-book-reader mr-2"></i>Pinjam Buku
                        </button>
                    @else
                        <button class="action-button w-full justify-center" style="background-color: #e5e7eb; color: #6b7280;" disabled>
                            <i class="fas fa-book mr-2"></i>Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center col-span-full py-12">
            <div class="flex flex-col items-center">
                <i class="fas fa-book-open text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada buku tersedia</h3>
                <p class="text-gray-500">Belum ada buku dalam perpustakaan</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($books, 'hasPages') && $books->hasPages())
    <div class="mt-6">
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($books->onFirstPage())
                <span class="pagination-link disabled opacity-50 cursor-not-allowed"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $books->previousPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($books->getUrlRange(max(1, $books->currentPage() - 2), min($books->lastPage(), $books->currentPage() + 2)) as $page => $url)
                @if ($page == $books->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="pagination-link disabled opacity-50 cursor-not-allowed"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Borrow Book Modal -->
<div id="borrowModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Pinjam Buku</h3>
            <button onclick="closeBorrowModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="borrowForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                <div id="bookTitle" class="px-4 py-2 bg-gray-100 rounded-lg text-gray-800"></div>
            </div>

            <div class="mb-6">
                <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi Peminjaman</label>
                <select
                    id="duration"
                    name="duration"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-soft-brown focus:border-transparent"
                    required
                >
                    <option value="">Pilih Durasi</option>
                    <option value="1">1 Minggu</option>
                    <option value="2">2 Minggu</option>
                    <option value="3">3 Minggu</option>
                    <option value="4">1 Bulan</option>
                </select>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeBorrowModal()" class="action-button" style="background-color: #e5e7eb; color: #374151;">
                    Batal
                </button>
                <button type="submit" class="action-button action-borrow">
                    <i class="fas fa-book-reader mr-2"></i>Pinjam
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openBorrowModal(bookId, bookTitle) {
        document.getElementById('bookTitle').textContent = bookTitle;
        document.getElementById('borrowForm').action = `/student/books/${bookId}/borrow`;
        document.getElementById('borrowModal').classList.remove('hidden');
    }

    function closeBorrowModal() {
        document.getElementById('borrowModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('borrowModal');
        if (modal && !modal.classList.contains('hidden') && event.target === modal) {
            closeBorrowModal();
        }
    });
</script>
@endsection