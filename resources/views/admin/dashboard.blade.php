@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')

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
</style>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Card Jumlah Buku -->
    <div class="stat-card card p-6 bg-gradient-to-br from-blue-50 to-blue-100">
        <div class="flex items-center">
            <div class="action-icon bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Jumlah Buku</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalBooks }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Jumlah Anggota -->
    <div class="stat-card card p-6 bg-gradient-to-br from-green-50 to-green-100">
        <div class="flex items-center">
            <div class="action-icon bg-green-100 text-green-600 mr-4">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Jumlah Anggota</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalMembers }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Jumlah Transaksi -->
    <div class="stat-card card p-6 bg-gradient-to-br from-yellow-50 to-yellow-100">
        <div class="flex items-center">
            <div class="action-icon bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Transaksi Aktif</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $activeTransactions }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 chart-container card p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Statistik Peminjaman</h3>
            <div class="period-toggle">
                <button id="dailyBtn" class="period-btn" data-period="daily">Harian</button>
                <button id="weeklyBtn" class="period-btn" data-period="weekly">Mingguan</button>
                <button id="monthlyBtn" class="period-btn active" data-period="monthly">Bulanan</button>
            </div>
        </div>
        <canvas id="chart" width="400" height="200"></canvas>
    </div>

    <div class="recent-transactions card p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="action-icon bg-blue-100 text-blue-600 mr-3">
                    <i class="fas fa-book"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Peminjaman Baru</p>
                    <p class="text-sm text-gray-500">5 buku dipinjam hari ini</p>
                    <p class="text-xs text-gray-400">10 menit yang lalu</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="action-icon bg-green-100 text-green-600 mr-3">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Anggota Baru</p>
                    <p class="text-sm text-gray-500">2 anggota baru mendaftar</p>
                    <p class="text-xs text-gray-400">2 jam yang lalu</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="action-icon bg-purple-100 text-purple-600 mr-3">
                    <i class="fas fa-book-medical"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Pengembalian</p>
                    <p class="text-sm text-gray-500">8 buku dikembalikan</p>
                    <p class="text-xs text-gray-400">3 jam yang lalu</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="action-icon bg-yellow-100 text-yellow-600 mr-3">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">Terlambat</p>
                    <p class="text-sm text-gray-500">3 buku terlambat</p>
                    <p class="text-xs text-gray-400">5 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('admin.books.index') }}" class="action-card">
        <div class="action-icon bg-soft-brown text-white">
            <i class="fas fa-book"></i>
        </div>
        <h3>Data Buku</h3>
        <p>Kelola koleksi buku</p>
    </a>
    <a href="{{ route('admin.members.index') }}" class="action-card">
        <div class="action-icon bg-dark-tea-brown text-white">
            <i class="fas fa-users"></i>
        </div>
        <h3>Data Anggota</h3>
        <p>Kelola anggota perpustakaan</p>
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="action-card">
        <div class="action-icon bg-soft-brown text-white">
            <i class="fas fa-exchange-alt"></i>
        </div>
        <h3>Transaksi</h3>
        <p>Lihat semua transaksi</p>
    </a>
    <a href="#" class="action-card">
        <div class="action-icon bg-dark-tea-brown text-white">
            <i class="fas fa-chart-bar"></i>
        </div>
        <h3>Laporan</h3>
        <p>Cetak laporan statistik</p>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari server
    let chartData = {
        labels: {{ json_encode($chartLabels) }},
        datasets: [{
            label: 'Jumlah Peminjaman',
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
    function updateChart(period) {
        fetch(`/admin/dashboard/chart-data?period=${period}`)
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
            updateChart(period);
        });
    });
</script>
@endsection