@extends('layouts.app')

@section('title', 'Data Buku')
@section('page-title', 'Data Buku')

@section('content')
<div class="card p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h3 class="text-lg font-semibold">Kelola Data Buku</h3>
        <div class="flex flex-wrap gap-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                <i class="fas fa-file-import mr-2"></i>Import Buku
            </button>
            <a href="{{ route('admin.books.create') }}" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Tambah Buku
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Modal Import -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Import Data Buku</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin.books.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Pilih File CSV</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
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
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Format file:</strong> judul,penulis,penerbit,kategori,stok<br>
                                    <a href="{{ asset('samples/contoh_buku.csv') }}" class="font-medium underline" download>Download contoh file CSV</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="btn-secondary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                        <i class="fas fa-upload mr-2"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerbit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($books as $book)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->judul }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->penulis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->penerbit }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->kategori }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $book->stok }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn-primary py-1 px-3 rounded text-sm">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger py-1 px-3 rounded text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-center" colspan="7">
                        <div class="text-gray-500">Belum ada data buku</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection