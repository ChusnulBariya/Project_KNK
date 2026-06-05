@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    .stat-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }
    .bg-light-blue {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .bg-light-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    .chart-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        background-color: #fff;
    }

    .kategori-list-item {
        border: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .kategori-list-item:last-child {
        border-bottom: none;
    }
    .badge-count {
        background-color: #e2e8f0;
        color: #334155;
        font-weight: 600;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark m-0">Ringkasan Statistik</h3>
            <p class="text-secondary small">Statistik terkini kunjungan tamu Bimbingan Belajar Meteor.</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row mb-4">
        <!-- Tamu Hari Ini -->
        <div class="col-md-4 mb-3">
            <div class="card stat-card p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-secondary fw-semibold mb-1">Tamu Hari Ini</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $tamuHariIni }}</h2>
                    </div>
                    <div class="stat-icon bg-light-blue">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tamu Bulan Ini -->
        <div class="col-md-4 mb-3">
            <div class="card stat-card p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-secondary fw-semibold mb-1">Tamu Bulan Ini</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $tamuBulanIni }}</h2>
                    </div>
                    <div class="stat-icon bg-light-success">
                        <i class="bi bi-calendar-month-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tamu -->
        <div class="col-md-4 mb-3">
            <div class="card stat-card p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-secondary fw-semibold mb-1">Total Kunjungan Tamu</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalTamu }}</h2>
                    </div>
                    <div class="stat-icon bg-light-warning">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Grafik Kunjungan -->
        <div class="col-12 mb-4">
            <div class="card chart-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0">Grafik Kunjungan (7 Hari Terakhir)</h5>
                    <i class="bi bi-graph-up text-primary fs-5"></i>
                </div>
                <div style="position: relative; height:320px; width:100%;">
                    <canvas id="visitsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kategori Keperluan -->
        <div class="col-12">
            <div class="card chart-card p-4">
                <h5 class="fw-bold text-dark mb-4">Statistik Kategori Keperluan Kunjungan</h5>
                <div class="row">
                    @foreach($kategoriStats->chunk(5) as $chunk)
                        <div class="col-md-6">
                            <div class="list-group list-group-flush">
                                @foreach($chunk as $stat)
                                    <div class="kategori-list-item">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-check-circle-fill text-primary small"></i>
                                            <span class="text-dark fw-medium small">{{ $stat->nama_kategori }}</span>
                                        </div>
                                        <span class="badge-count">{{ $stat->tamus_count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Render Chart.js
    const ctx = document.getElementById('visitsChart').getContext('2d');
    
    // Gradient color for chart fill
    const chartGradient = ctx.createLinearGradient(0, 0, 0, 300);
    chartGradient.addColorStop(0, 'rgba(0, 82, 212, 0.4)');
    chartGradient.addColorStop(1, 'rgba(0, 82, 212, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: {!! json_encode($chartData) !!},
                borderColor: '#4364f7',
                borderWidth: 3,
                pointBackgroundColor: '#0052d4',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                backgroundColor: chartGradient,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 12,
                    backgroundColor: '#0f2027',
                    titleFont: {
                        family: 'Plus Jakarta Sans',
                        size: 13,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: 'Plus Jakarta Sans',
                        size: 13
                    },
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#64748b',
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 11
                        }
                    },
                    grid: {
                        color: '#e2e8f0'
                    }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 11
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection
