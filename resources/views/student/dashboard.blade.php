@extends('layouts.app')

@section('title', 'Siswa Dashboard')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Card Jumlah Buku -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Jumlah Buku Tersedia</p>
                <h3 class="text-2xl font-bold">{{ $availableBooks }}/{{ $totalBooks }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Buku Dipinjam -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-exchange-alt text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Buku Sedang Dipinjam</p>
                <h3 class="text-2xl font-bold">{{ $borrowedBooks->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Card Total Transaksi -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-history text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500">Total Transaksi</p>
                <h3 class="text-2xl font-bold">{{ $totalTransactions }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Grafik Statistik -->
    <div class="card p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Statistik Peminjaman Saya</h3>
            <div class="flex space-x-2">
                <button id="dailyBtnStudent" class="px-3 py-1 rounded text-sm period-btn-student" data-period="daily">Harian</button>
                <button id="weeklyBtnStudent" class="px-3 py-1 rounded text-sm period-btn-student" data-period="weekly">Mingguan</button>
                <button id="monthlyBtnStudent" class="px-3 py-1 rounded bg-soft-brown text-white text-sm period-btn-student active" data-period="monthly">Bulanan</button>
            </div>
        </div>
        <canvas id="chart" width="400" height="200"></canvas>
    </div>

    <!-- Riwayat Peminjaman Terakhir -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Riwayat Peminjaman Terakhir</h3>
        <div class="overflow-x-auto max-h-64 overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($borrowedBooks->take(5) as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->book->judul ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($transaction->borrow_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->return_date)
                                {{ \Carbon\Carbon::parse($transaction->return_date)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($transaction->status == 'dipinjam')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-green-100 text-green-800
                                @endif">
                                {{ $transaction->status == 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="4">
                            <div class="text-center text-gray-500 py-4">Belum ada riwayat peminjaman</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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
    function updateStudentChart(period) {
        fetch(`/student/dashboard/chart-data?period=${period}`)
            .then(response => response.json())
            .then(data => {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.values;
                chart.update();

                // Update active button
                document.querySelectorAll('.period-btn-student').forEach(btn => {
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
    document.querySelectorAll('.period-btn-student').forEach(button => {
        button.addEventListener('click', function() {
            const period = this.getAttribute('data-period');
            updateStudentChart(period);
        });
    });
</script>
@endsection