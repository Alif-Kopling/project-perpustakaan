<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk entitas Transaksi
 * Menyimpan informasi tentang peminjaman buku oleh member
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal
     * @var array
     */
    protected $fillable = [
        'member_id',
        'book_id',
        'borrow_date',
        'return_date',
        'status'
    ];

    /**
     * Relasi ke member
     * Transaksi dimiliki oleh satu member
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relasi ke buku
     * Transaksi terkait dengan satu buku
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
