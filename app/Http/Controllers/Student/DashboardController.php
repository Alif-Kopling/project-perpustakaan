<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $member = $currentUser->member;

        // Statistik untuk siswa
        if ($member) {
            $borrowedBooks = Transaction::where('member_id', $member->id)
                ->where('status', 'dipinjam')
                ->with(['book'])
                ->get();

            $returnedBooks = Transaction::where('member_id', $member->id)
                ->where('status', 'dikembalikan')
                ->count();

            // Total transaksi milik siswa
            $totalTransactions = Transaction::where('member_id', $member->id)->count();
        } else {
            $borrowedBooks = collect();
            $returnedBooks = 0;
            $totalTransactions = 0;
        }

        // Statistik umum yang bisa dilihat siswa
        $totalBooks = Book::count(); // Total buku yang tersedia
        $availableBooks = Book::where('stok', '>', 0)->count(); // Buku yang tersedia untuk dipinjam

        // Ambil data statistik bulanan untuk grafik
        $chartData = $this->getMonthlyData($member ? $member->id : null);
        $chartLabels = $chartData['labels'];
        $chartValues = $chartData['values'];

        return view('student.dashboard', compact(
            'borrowedBooks',
            'returnedBooks',
            'totalTransactions',
            'totalBooks',
            'availableBooks',
            'chartLabels',
            'chartValues'
        ));
    }

    public function getChartData(Request $request)
    {
        $period = $request->query('period', 'monthly');

        switch ($period) {
            case 'daily':
                $data = $this->getDailyData();
                break;
            case 'weekly':
                $data = $this->getWeeklyData();
                break;
            case 'monthly':
            default:
                $data = $this->getMonthlyData();
                break;
        }

        return response()->json($data);
    }

    private function getDailyData()
    {
        // Ambil data harian untuk 7 hari terakhir
        $labels = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Transaction::whereDate('borrow_date', $date->toDateString())->count();

            $labels[] = $date->format('d M');
            $values[] = $count;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    private function getWeeklyData()
    {
        // Ambil data mingguan untuk 6 minggu terakhir
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $startDate = Carbon::now()->startOfWeek()->subWeeks($i);
            $endDate = Carbon::now()->endOfWeek()->subWeeks($i);

            $count = Transaction::whereDate('borrow_date', '>=', $startDate)
                               ->whereDate('borrow_date', '<=', $endDate)
                               ->count();

            $labels[] = $startDate->format('d M') . ' - ' . $endDate->format('d M');
            $values[] = $count;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    private function getMonthlyData($memberId = null)
    {
        // Ambil data bulanan untuk 6 bulan terakhir
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            if ($memberId) {
                // Jika ada ID member, hanya ambil transaksi milik member tersebut
                $count = Transaction::where('member_id', $memberId)
                                  ->whereYear('borrow_date', $month->year)
                                  ->whereMonth('borrow_date', $month->month)
                                  ->count();
            } else {
                // Jika tidak ada ID member, ambil semua transaksi
                $count = Transaction::whereYear('borrow_date', $month->year)
                                  ->whereMonth('borrow_date', $month->month)
                                  ->count();
            }

            $labels[] = $month->format('M Y');
            $values[] = $count;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}