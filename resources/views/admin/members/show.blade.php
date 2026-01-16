@extends('layouts.app')

@section('title', 'Detail Anggota')
@section('page-title', 'Detail Anggota')

@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $member->nama }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Teknis (NIT)</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $member->nit }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $member->kelas }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $member->jurusan }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <p class="bg-gray-50 p-3 rounded border">{{ $member->username }}</p>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('admin.members.index') }}" class="btn-secondary py-2 px-4 rounded">
            Kembali
        </a>
        <a href="{{ route('admin.members.edit', $member) }}" class="btn-primary py-2 px-4 rounded">
            Edit
        </a>
    </div>
</div>
@endsection