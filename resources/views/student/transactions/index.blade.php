@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi Saya')

@section('content')
<div class="card p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Riwayat Peminjaman</h3>
    </div>
    
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
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap" colspan="6">
                        <div class="text-center text-gray-500 py-4">Belum ada riwayat transaksi</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection