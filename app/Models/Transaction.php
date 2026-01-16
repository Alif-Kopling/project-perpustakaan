<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'book_id',
        'borrow_date',
        'return_date',
        'status'
    ];

    // Relasi ke member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
