<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil member terkait dengan user yang sedang login
        $currentUser = Auth::user();
        $member = $currentUser->member;

        if ($member) {
            $query = Transaction::where('member_id', $member->id)->with(['book']);

            // Tambahkan pencarian jika ada parameter pencarian
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->whereHas('book', function($q) use ($searchTerm) {
                    $q->where('judul', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('penulis', 'LIKE', "%{$searchTerm}%");
                });
            }

            $transactions = $query->paginate(10); // Gunakan paginate untuk mendukung pagination
        } else {
            $transactions = collect(); // Kembalikan koleksi kosong jika tidak ada member
        }

        return view('student.transactions.index', compact('transactions'));
    }

    /**
     * Process book return request
     */
    public function returnBook(Request $request, Transaction $transaction)
    {
        // Check if the transaction belongs to the authenticated user
        $currentUser = Auth::user();
        $member = $currentUser->member;

        if ($transaction->member_id !== $member->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengembalikan buku ini.');
        }

        // Check if the transaction is already returned
        if ($transaction->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Update transaction status to returned
        $transaction->update([
            'return_date' => now(),
            'status' => 'dikembalikan'
        ]);

        // Increase book stock because it's returned
        $transaction->book->increment('stok');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }
}