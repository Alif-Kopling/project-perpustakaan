<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk entitas Member
 * Menyimpan informasi tentang anggota perpustakaan
 */
class Member extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal
     * @var array
     */
    protected $fillable = [
        'nama',
        'nit',
        'kelas',
        'jurusan',
        'username'
    ];

    /**
     * Relasi ke transaksi peminjaman
     * Satu member bisa memiliki banyak transaksi
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
