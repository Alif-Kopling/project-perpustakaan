<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $member = $currentUser->member;
        
        if ($member) {
            $borrowedBooks = Transaction::where('member_id', $member->id)
                ->where('status', 'dipinjam')
                ->with(['book'])
                ->get();
                
            $returnedBooks = Transaction::where('member_id', $member->id)
                ->where('status', 'dikembalikan')
                ->count();
        } else {
            $borrowedBooks = collect();
            $returnedBooks = 0;
        }
        
        return view('student.dashboard', compact('borrowedBooks', 'returnedBooks'));
    }
}