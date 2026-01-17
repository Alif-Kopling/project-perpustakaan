<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Book;

/**
 * Controller untuk mengelola transaksi peminjaman buku
 * Termasuk CRUD (Create, Read, Update, Delete) transaksi
 */
class TransactionController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua transaksi beserta data member dan buku terkait
        $transactions = Transaction::with(['member', 'book'])->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form untuk membuat transaksi baru
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil semua data member
        $members = Member::all();
        // Ambil semua buku yang masih tersedia (stok > 0)
        $books = Book::where('stok', '>', 0)->get();
        return view('admin.transactions.create', compact('members', 'books'));
    }

    /**
     * Menyimpan transaksi baru ke database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        // Ambil data buku berdasarkan ID
        $book = Book::findOrFail($request->book_id);

        // Cek apakah stok buku mencukupi
        if ($book->stok < 1) {
            return redirect()->back()->withErrors(['book_id' => 'Stok buku tidak mencukupi.']);
        }

        // Simpan data transaksi ke database
        Transaction::create([
            'member_id' => $request->member_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'status' => 'dipinjam'
        ]);

        // Kurangi stok buku karena dipinjam
        $book->decrement('stok');

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi peminjaman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail transaksi tertentu
     * @param Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Menampilkan form untuk mengedit transaksi
     * @param Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        // Method ini tidak digunakan dalam aplikasi ini
        // Karena pengembalian buku dilakukan langsung dari halaman daftar transaksi
    }

    /**
     * Memperbarui data transaksi di database
     * @param Request $request
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Proses pengembalian buku
        if ($request->has('return')) {
            // Update status transaksi menjadi dikembalikan
            $transaction->update([
                'return_date' => now(),
                'status' => 'dikembalikan'
            ]);

            // Tambahkan stok buku karena sudah dikembalikan
            $transaction->book->increment('stok');

            // Redirect ke halaman daftar transaksi dengan pesan sukses
            return redirect()->route('admin.transactions.index')->with('success', 'Buku berhasil dikembalikan.');
        }

        // Jika bukan proses pengembalian, kembali ke halaman daftar transaksi
        return redirect()->route('admin.transactions.index');
    }

    /**
     * Menghapus transaksi dari database
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        // Method ini tidak digunakan dalam aplikasi ini
        // Karena transaksi tidak dihapus, hanya statusnya yang diubah saat pengembalian
    }
}