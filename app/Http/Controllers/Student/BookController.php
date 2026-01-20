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
    public function index(Request $request)
    {
        $query = Book::query();

        // Tambahkan pencarian jika ada parameter pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('penulis', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('penerbit', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('kategori', 'LIKE', "%{$searchTerm}%");
            });
        }

        $books = $query->paginate(10); // Gunakan paginate untuk mendukung pagination

        return view('student.books.index', compact('books'));
    }

    /**
     * Process book borrowing request
     */
    public function borrow(Request $request, Book $book)
    {
        // Validasi input
        $request->validate([
            'duration' => 'required|in:1,2,3,4',
        ]);

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

        // Hitung tanggal jatuh tempo berdasarkan durasi
        $borrowDate = Carbon::now();
        $duration = $request->duration;

        switch ($duration) {
            case '1':
                $dueDate = $borrowDate->copy()->addWeek();
                break;
            case '2':
                $dueDate = $borrowDate->copy()->addWeeks(2);
                break;
            case '3':
                $dueDate = $borrowDate->copy()->addWeeks(3);
                break;
            case '4':
                $dueDate = $borrowDate->copy()->addMonth();
                break;
            default:
                $dueDate = $borrowDate->copy()->addWeek(); // Default ke 1 minggu
        }

        // Check if due_date column exists in the transactions table
        $tableColumns = \Schema::getColumnListing('transactions');
        $hasDueDateColumn = in_array('due_date', $tableColumns);

        // Prepare transaction data
        $transactionData = [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => $borrowDate,
            'status' => 'dipinjam'
        ];

        // Add due_date if the column exists
        if ($hasDueDateColumn) {
            $transactionData['due_date'] = $dueDate;
        }

        // Kurangi stok buku
        $book->decrement('stok');

        // Buat transaksi peminjaman
        Transaction::create($transactionData);

        return redirect()->back()->with('success', 'Buku berhasil dipinjam.');
    }
}