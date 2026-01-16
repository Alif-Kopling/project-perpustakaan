@extends('layouts.app')

@section('title', 'Import Anggota')
@section('page-title', 'Import Data Anggota dari CSV')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <form action="{{ route('admin.import.members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
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
        
        <div class="mb-6">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Format file:</strong> nama,kelas,username<br>
                            <a href="{{ asset('samples/contoh_anggota.csv') }}" class="font-medium underline" download>Download contoh file CSV</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.members.index') }}" class="btn-secondary py-2 px-4 rounded">
                Batal
            </a>
            <button type="submit" class="btn-primary py-2 px-4 rounded transform transition-transform duration-150 hover:scale-105">
                <i class="fas fa-upload mr-2"></i>Import
            </button>
        </div>
    </form>
</div>
@endsection