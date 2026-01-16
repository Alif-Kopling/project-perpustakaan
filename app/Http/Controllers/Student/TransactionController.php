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
    public function index()
    {
        // Ambil member terkait dengan user yang sedang login
        $currentUser = Auth::user();
        $member = $currentUser->member;
        
        if ($member) {
            $transactions = Transaction::where('member_id', $member->id)
                ->with(['book'])
                ->get();
        } else {
            $transactions = collect(); // Kembalikan koleksi kosong jika tidak ada member
        }
        
        return view('student.transactions.index', compact('transactions'));
    }
}