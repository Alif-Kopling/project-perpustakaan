@extends('layouts.app')

@section('title', 'Data Anggota')
@section('page-title', 'Data Anggota')

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

    .action-edit {
        background-color: var(--soft-brown);
        color: white;
    }

    .action-delete {
        background-color: #ef4444;
        color: white;
    }

    .action-add {
        background: linear-gradient(135deg, var(--soft-brown), var(--dark-tea-brown));
        color: white;
    }

    .action-import {
        background: linear-gradient(135deg, var(--dark-tea-brown), var(--soft-brown));
        color: white;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .member-active {
        background-color: #d1fae5;
        color: #065f46;
    }

    .member-inactive {
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

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--soft-brown), var(--dark-tea-brown));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>

<div class="modern-card card p-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Kelola Data Anggota</h3>
            <p class="text-gray-600">Tambah, edit, atau hapus data anggota perpustakaan</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="action-button action-import">
                <i class="fas fa-file-import mr-2"></i>Import Anggota
            </button>
            <a href="{{ route('admin.members.create') }}" class="action-button action-add">
                <i class="fas fa-plus mr-2"></i>Tambah Anggota
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.members.index') }}">
        <div class="mb-6 relative">
            <div class="absolute search-icon">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota berdasarkan nama, NIT, atau kelas..." class="search-input w-full py-3 pl-10 pr-4 border focus:outline-none focus:ring-2 focus:ring-soft-brown focus:border-transparent">
            @if(request('search'))
                <a href="{{ route('admin.members.index') }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </div>
    </form>

    <!-- Modal Import -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative transform transition-all duration-300 scale-95 opacity-0 animate-fade-in">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Import Data Anggota</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.members.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-3">Pilih File CSV</label>
                    <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-gray-300 rounded-xl transition-colors hover:border-soft-brown">
                        <div class="space-y-3 text-center">
                            <div class="mx-auto w-16 h-16 bg-soft-brown bg-opacity-10 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-csv text-2xl text-soft-brown"></i>
                            </div>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-soft-brown hover:text-dark-tea-brown focus-within:outline-none">
                                    <span>Upload file</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".csv" required>
                                </label>
                                <p class="pl-1">atau drag dan drop</p>
                            </div>
                            <p class="text-xs text-gray-500">CSV file</p>
                        </div>
                    </div>
                    @error('file')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Format file:</strong> nama,nit,kelas,jurusan,username<br>
                                <a href="{{ asset('samples/contoh_anggota.csv') }}" class="font-medium underline hover:no-underline" download>Download contoh file CSV</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="action-button" style="background-color: #e5e7eb; color: #374151;">
                        Batal
                    </button>
                    <button type="submit" class="action-button action-import">
                        <i class="fas fa-upload mr-2"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="table-header">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">NIT</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Jurusan</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Username</th>
                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($members as $member)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="avatar mr-3">
                                {{ substr($member->nama, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $member->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $member->username }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->nit }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->kelas }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->jurusan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->username }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.members.edit', $member) }}" class="action-button action-edit">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button action-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-12 whitespace-nowrap text-center" colspan="7">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada data anggota</h3>
                            <p class="text-gray-500">Mulai tambahkan anggota untuk mengisi perpustakaan</p>
                            <a href="{{ route('admin.members.create') }}" class="mt-4 action-button action-add">
                                <i class="fas fa-plus mr-2"></i>Tambah Anggota
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($members, 'hasPages') && $members->hasPages())
    <div class="mt-6">
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($members->onFirstPage())
                <span class="pagination-link disabled opacity-50 cursor-not-allowed"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $members->previousPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($members->getUrlRange(max(1, $members->currentPage() - 2), min($members->lastPage(), $members->currentPage() + 2)) as $page => $url)
                @if ($page == $members->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($members->hasMorePages())
                <a href="{{ $members->nextPageUrl() }}" class="pagination-link"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="pagination-link disabled opacity-50 cursor-not-allowed"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('importModal');
        if (modal && !modal.contains(event.target) && !event.target.closest('[onclick*="importModal"]')) {
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        }
    });

    // Add fade-in animation class
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('importModal');
        if (modal) {
            modal.addEventListener('transitionend', function() {
                if (!modal.classList.contains('hidden')) {
                    modal.classList.remove('scale-95', 'opacity-0');
                }
            });
        }
    });
</script>
@endsection