@extends('layouts.app')

@section('title', 'Siswa Dashboard')
@section('page-title', 'Dashboard Siswa')

@section('content')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--soft-brown), var(--dark-tea-brown));
    }

    .chart-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .period-toggle {
        display: inline-flex;
        background: #f3f4f6;
        border-radius: 9999px;
        padding: 4px;
    }

    .period-btn {
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .period-btn.active {
        background: var(--soft-brown);
        color: white;
    }

    .recent-transactions {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .action-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid var(--border-soft);
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .action-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        border-radius: 12px;
        font-size: 1.5rem;
    }

    .action-card h3 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .action-card p {
        color: #6B7280;
        font-size: 0.875rem;
    }

    .book-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid var(--border-soft);
    }

    .book-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .progress-bar {
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--soft-brown), var(--dark-tea-brown));
        border-radius: 4px;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-dipinjam {
        background-color: #fef3c7;
        color: #d97706;
    }

    .status-dikembalikan {
        background-color: #d1fae5;
        color: #065f46;
    }
</style>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Card Jumlah Buku Tersedia -->
    <div class="stat-card card p-6 bg-gradient-to-br from-blue-50 to-blue-100">
        <div class="flex items-center">
            <div class="action-icon bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Buku Tersedia</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $availableBooks }}/{{ $totalBooks }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Buku Sedang Dipinjam -->
    <div class="stat-card card p-6 bg-gradient-to-br from-yellow-50 to-yellow-100">
        <div class="flex items-center">
            <div class="action-icon bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Sedang Dipinjam</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $borrowedBooks->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Total Transaksi -->
    <div class="stat-card card p-6 bg-gradient-to-br from-green-50 to-green-100">
        <div class="flex items-center">
            <div class="action-icon bg-green-100 text-green-600 mr-4">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Transaksi</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 chart-container card p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Statistik Peminjaman Saya</h3>
            <div class="period-toggle">
                <button id="dailyBtnStudent" class="period-btn" data-period="daily">Harian</button>
                <button id="weeklyBtnStudent" class="period-btn" data-period="weekly">Mingguan</button>
                <button id="monthlyBtnStudent" class="period-btn active" data-period="monthly">Bulanan</button>
            </div>
        </div>
        <canvas id="chart" width="400" height="200"></canvas>
    </div>

    <div class="recent-transactions card p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Status Terkini</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="action-icon bg-blue-100 text-blue-600 mr-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Menunggu Persetujuan</p>
                    <p class="text-sm text-gray-500">0 permintaan</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="action-icon bg-green-100 text-green-600 mr-3">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Peminjaman Aktif</p>
                    <p class="text-sm text-gray-500">{{ $borrowedBooks->count() }} buku</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="action-icon bg-purple-100 text-purple-600 mr-3">
                    <i class="fas fa-history"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Riwayat</p>
                    <p class="text-sm text-gray-500">{{ $returnedBooks }} buku</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="action-icon bg-yellow-100 text-yellow-600 mr-3">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Terlambat</p>
                    <p class="text-sm text-gray-500">0 buku</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 card p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Riwayat Peminjaman Terakhir</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($borrowedBooks->take(5) as $transaction)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $transaction->book->judul ?? '-' }}</div>
                        <div class="text-sm text-gray-500">{{ $transaction->book->penulis ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($transaction->return_date)
                            {{ \Carbon\Carbon::parse($transaction->return_date)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-badge
                            @if($transaction->status == 'dipinjam')
                                status-dipinjam
                            @else
                                status-dikembalikan
                            @endif">
                            {{ $transaction->status == 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($transaction->status == 'dipinjam')
                            <a href="#" class="text-soft-brown hover:text-dark-tea-brown font-medium">Kembalikan</a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap" colspan="5">
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-book-open text-4xl mb-4 text-gray-300"></i>
                            <p>Belum ada riwayat peminjaman</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('student.books.index') }}" class="action-card">
        <div class="action-icon bg-soft-brown text-white">
            <i class="fas fa-book"></i>
        </div>
        <h3>Cari Buku</h3>
        <p>Jelajahi koleksi buku</p>
    </a>
    <a href="{{ route('student.transactions.index') }}" class="action-card">
        <div class="action-icon bg-dark-tea-brown text-white">
            <i class="fas fa-history"></i>
        </div>
        <h3>Riwayat Saya</h3>
        <p>Lihat semua transaksi</p>
    </a>
    <a href="#" class="action-card">
        <div class="action-icon bg-soft-brown text-white">
            <i class="fas fa-bell"></i>
        </div>
        <h3>Pemberitahuan</h3>
        <p>Info penting</p>
    </a>
    <a href="#" class="action-card">
        <div class="action-icon bg-dark-tea-brown text-white">
            <i class="fas fa-cog"></i>
        </div>
        <h3>Profil</h3>
        <p>Pengaturan akun</p>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari server
    let chartData = {
        labels: {{ json_encode($chartLabels) }},
        datasets: [{
            label: 'Jumlah Peminjaman Saya',
            data: {{ json_encode($chartValues) }},
            backgroundColor: 'rgba(196, 164, 132, 0.2)',
            borderColor: 'rgba(196, 164, 132, 1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true
        }]
    };

    // Konfigurasi chart
    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    };

    // Render chart
    const ctx = document.getElementById('chart').getContext('2d');
    const chart = new Chart(ctx, config);

    // Fungsi untuk memperbarui chart
    function updateStudentChart(period) {
        fetch(`/student/dashboard/chart-data?period=${period}`)
            .then(response => response.json())
            .then(data => {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.values;
                chart.update();

                // Update active button
                document.querySelectorAll('.period-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                const activeBtn = document.querySelector(`[data-period="${period}"]`);
                activeBtn.classList.add('active');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Event listener untuk tombol periode
    document.querySelectorAll('.period-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const period = this.getAttribute('data-period');
            updateStudentChart(period);
        });
    });
</script>
@endsection