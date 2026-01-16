<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample books
        Book::create([
            'judul' => 'Pemrograman Laravel untuk Pemula',
            'penulis' => 'Ahmad Fauzi',
            'penerbit' => 'Elex Media',
            'kategori' => 'teknologi',
            'stok' => 5
        ]);

        Book::create([
            'judul' => 'Desain Antarmuka Web Modern',
            'penulis' => 'Siti Rahma',
            'penerbit' => 'Andi Offset',
            'kategori' => 'teknologi',
            'stok' => 3
        ]);

        Book::create([
            'judul' => 'Algoritma dan Struktur Data',
            'penulis' => 'Bambang Prasetyo',
            'penerbit' => 'Gramedia',
            'kategori' => 'teknologi',
            'stok' => 7
        ]);

        Book::create([
            'judul' => 'Machine Learning untuk Pemula',
            'penulis' => 'Dewi Anggraini',
            'penerbit' => 'Erlangga',
            'kategori' => 'teknologi',
            'stok' => 4
        ]);

        Book::create([
            'judul' => 'Basis Data Relasional',
            'penulis' => 'Agus Salim',
            'penerbit' => 'Penerbit Informatika',
            'kategori' => 'teknologi',
            'stok' => 6
        ]);

        Book::create([
            'judul' => 'Novel Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'penerbit' => 'Gramedia',
            'kategori' => 'novel',
            'stok' => 10
        ]);

        Book::create([
            'judul' => 'Kimia Dasar untuk SMA',
            'penulis' => 'Dr. Sigit Sulistyo',
            'penerbit' => 'Nobel Ilmu Populer',
            'kategori' => 'kimia',
            'stok' => 5
        ]);

        Book::create([
            'judul' => 'Fisika Modern untuk Mahasiswa',
            'penulis' => 'Johan Christian',
            'penerbit' => 'Frempong Academic',
            'kategori' => 'fisika',
            'stok' => 4
        ]);
    }
}