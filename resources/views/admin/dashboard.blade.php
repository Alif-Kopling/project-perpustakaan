@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Card Jumlah Buku -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Jumlah Buku</p>
                <h3 class="text-2xl font-bold">{{ $totalBooks }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Jumlah Anggota -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Jumlah Anggota</p>
                <h3 class="text-2xl font-bold">{{ $totalMembers }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Jumlah Transaksi -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-exchange-alt text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Transaksi Aktif</p>
                <h3 class="text-2xl font-bold">{{ $activeTransactions }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 card p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Statistik Peminjaman</h3>
        <div class="flex space-x-2">
            <button id="dailyBtn" class="px-3 py-1 rounded text-sm period-btn" data-period="daily">Harian</button>
            <button id="weeklyBtn" class="px-3 py-1 rounded text-sm period-btn" data-period="weekly">Mingguan</button>
            <button id="monthlyBtn" class="px-3 py-1 rounded bg-soft-brown text-white text-sm period-btn active" data-period="monthly">Bulanan</button>
        </div>
    </div>
    <canvas id="chart" width="400" height="200"></canvas>
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
            borderWidth: 1
        }]
    };

    // Konfigurasi chart
    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
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
                    btn.classList.remove('bg-soft-brown', 'text-white');
                    btn.classList.add('text-gray-700');
                });

                const activeBtn = document.querySelector(`[data-period="${period}"]`);
                activeBtn.classList.remove('text-gray-700');
                activeBtn.classList.add('bg-soft-brown', 'text-white');
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Event listener untuk tombol periode
    document.querySelectorAll('.period-btn').forEach(button => {
        button.addEventListener('click', function() {
            const period = this.getAttribute('data-period');
            updateChart(period);
        });
    });
</script>
@endsection