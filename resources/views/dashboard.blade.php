@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <div class="text-sm text-gray-500">
            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Attendance Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Hadir</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">22 Hari</p>
                    <p class="text-xs text-gray-400 mt-1">Bulan Ini</p>
                </div>
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Leave Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Izin</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">2 Hari</p>
                    <p class="text-xs text-gray-400 mt-1">Bulan Ini</p>
                </div>
                <div class="p-3 rounded-lg bg-green-50 text-green-600">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Percentage Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Persentase Kehadiran</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">92%</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 92%"></div>
                    </div>
                </div>
                <div class="p-3 rounded-lg bg-cyan-50 text-cyan-600">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Late Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Keterlambatan</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">3 Hari</p>
                    <p class="text-xs text-gray-400 mt-1">Bulan Ini</p>
                </div>
                <div class="p-3 rounded-lg bg-amber-50 text-amber-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Attendance Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Statistik Kehadiran Bulan Ini</h2>
            </div>
            <div class="h-80">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Distribution Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Distribusi Kehadiran</h2>
            </div>
            <div class="h-80">
                <canvas id="distributionChart"></canvas>
            </div>
            <div class="flex justify-center space-x-4 mt-4 text-sm">
                <div class="flex items-center">
                    <span class="w-3 h-3 rounded-full bg-blue-500 mr-1"></span>
                    <span>Hadir</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 rounded-full bg-green-500 mr-1"></span>
                    <span>Izin</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 rounded-full bg-cyan-500 mr-1"></span>
                    <span>Sakit</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Attendance Chart
const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(attendanceCtx, {
    type: 'line',
    data: {
        labels: Array.from({length: 30}, (_, i) => i + 1),
        datasets: [{
            label: 'Kehadiran',
            data: [1,1,1,1,1,1,0,0,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.05)',
            borderWidth: 2,
            tension: 0.1,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value === 1 ? 'Hadir' : 'Tidak Hadir';
                    }
                },
                grid: {
                    drawBorder: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.raw === 1 ? 'Hadir' : 'Tidak Hadir';
                    }
                }
            }
        }
    }
});

// Distribution Chart
const distributionCtx = document.getElementById('distributionChart').getContext('2d');
const distributionChart = new Chart(distributionCtx, {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Izin', 'Sakit'],
        datasets: [{
            data: [85, 10, 5],
            backgroundColor: ['#3b82f6', '#10b981', '#06b6d4'],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush
@endsection
