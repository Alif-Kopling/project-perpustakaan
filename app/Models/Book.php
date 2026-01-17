<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk entitas Buku
 * Menyimpan informasi tentang buku-buku yang tersedia di perpustakaan
 */
class Book extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal
     * @var array
     */
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'kategori',
        'stok'
    ];

    /**
     * Relasi ke transaksi peminjaman
     * Satu buku bisa dipinjam dalam banyak transaksi
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
