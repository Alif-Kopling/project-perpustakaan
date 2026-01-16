<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Book;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['member', 'book'])->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::where('stok', '>', 0)->get();
        return view('admin.transactions.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok < 1) {
            return redirect()->back()->withErrors(['book_id' => 'Stok buku tidak mencukupi.']);
        }

        Transaction::create([
            'member_id' => $request->member_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'status' => 'dipinjam'
        ]);

        // Kurangi stok buku
        $book->decrement('stok');

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Proses pengembalian buku
        if ($request->has('return')) {
            $transaction->update([
                'return_date' => now(),
                'status' => 'dikembalikan'
            ]);

            // Tambahkan stok buku
            $transaction->book->increment('stok');

            return redirect()->route('admin.transactions.index')->with('success', 'Buku berhasil dikembalikan.');
        }

        return redirect()->route('admin.transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}