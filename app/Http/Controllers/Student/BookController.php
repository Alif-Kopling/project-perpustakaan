<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('student.books.index', compact('books'));
    }

    /**
     * Process book borrowing request
     */
    public function borrow(Book $book)
    {
        // Validasi apakah buku tersedia
        if ($book->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis, tidak dapat melakukan peminjaman.');
        }

        // Dapatkan user dan member yang sedang login
        $currentUser = Auth::user();
        $member = $currentUser->member;

        if (!$member) {
            return redirect()->back()->with('error', 'Data member tidak ditemukan.');
        }

        // Cek apakah user sudah meminjam buku ini sebelumnya dan belum dikembalikan
        $existingBorrow = Transaction::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'dipinjam')
            ->first();

        if ($existingBorrow) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini sebelumnya dan belum mengembalikannya.');
        }

        // Kurangi stok buku
        $book->decrement('stok');

        // Buat transaksi peminjaman
        Transaction::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => Carbon::now(),
            'status' => 'dipinjam'
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dipinjam.');
    }
}