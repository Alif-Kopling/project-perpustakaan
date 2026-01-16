<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $activeTransactions = Transaction::where('status', 'dipinjam')->count();
        
        // Ambil data statistik bulanan untuk 6 bulan terakhir
        $chartData = $this->getMonthlyData();
        $chartLabels = $chartData['labels'];
        $chartValues = $chartData['values'];
        
        return view('admin.dashboard', compact('totalBooks', 'totalMembers', 'activeTransactions', 'chartLabels', 'chartValues'));
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
            
            $count = Transaction::whereBetween('borrow_date', [$startDate, $endDate])->count();
            
            $labels[] = $startDate->format('d M') . ' - ' . $endDate->format('d M');
            $values[] = $count;
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
    
    private function getMonthlyData()
    {
        // Ambil data bulanan untuk 6 bulan terakhir
        $labels = [];
        $values = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Transaction::whereYear('borrow_date', $month->year)
                               ->whereMonth('borrow_date', $month->month)
                               ->count();
            
            $labels[] = $month->format('M Y');
            $values[] = $count;
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}