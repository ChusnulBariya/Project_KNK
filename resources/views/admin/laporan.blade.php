@extends('layouts.admin')

@section('title', 'Laporan Kunjungan')

@section('styles')
<style>
    .filter-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }
    .summary-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        background: linear-gradient(135deg, #0052d4 0%, #4364f7 100%);
        color: #fff;
    }
    .table-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        overflow: hidden;
    }
    .table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        border-bottom: 2px solid #edf2f7;
    }
    .table td {
        padding: 16px 20px;
        vertical-align: middle;
        color: #334155;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .table tr:last-child td {
        border-bottom: none;
    }
    .badge-keperluan {
        background-color: rgba(67, 100, 247, 0.1);
        color: #4364f7;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark m-0">Laporan Kunjungan</h3>
            <p class="text-secondary small">Rekapitulasi kunjungan tamu dan export data ke file Excel.</p>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Filter Card -->
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="card filter-card p-4 h-100 bg-white">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-funnel me-2 text-primary"></i>Filter Rentang Tanggal</h5>
                
                <form action="{{ route('admin.laporan') }}" method="GET" id="filter-form">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tgl_mulai" class="form-label fw-semibold small text-secondary">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control bg-light" value="{{ $startDate }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_selesai" class="form-label fw-semibold small text-secondary">Tanggal Selesai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class="bi bi-calendar-x"></i></span>
                                <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control bg-light" value="{{ $endDate }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                            <i class="bi bi-search me-1"></i>Tampilkan Data
                        </button>
                        
                        @if($startDate || $endDate)
                            <a href="{{ route('admin.laporan') }}" class="btn btn-light border px-4 fw-bold rounded-3 text-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="col-lg-4">
            <div class="card summary-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold mb-1">Total Kunjungan</h5>
                    <p class="text-white-50 small">Jumlah tamu yang berkunjung pada periode terpilih.</p>
                </div>
                <div class="my-3">
                    <h1 class="display-3 fw-bold mb-0 text-white">{{ $totalKunjungan }}</h1>
                    <span class="text-white-50">Tamu terdaftar</span>
                </div>
                <div>
                    <form action="{{ route('admin.laporan.export') }}" method="GET">
                        <input type="hidden" name="tgl_mulai" value="{{ $startDate }}">
                        <input type="hidden" name="tgl_selesai" value="{{ $endDate }}">
                        <button type="submit" class="btn btn-light w-100 fw-bold py-2 rounded-3 text-primary shadow-sm" {{ $totalKunjungan === 0 ? 'disabled' : '' }}>
                            <i class="bi bi-file-earmark-excel-fill me-1 text-success"></i>Export Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card table-card bg-white">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark m-0">Data Hasil Pencarian</h5>
            <span class="badge bg-light text-secondary border fw-medium px-3 py-2 rounded-pill">
                @if($startDate && $endDate)
                    Periode: {{ Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                @elseif($startDate)
                    Mulai Dari: {{ Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
                @elseif($endDate)
                    Hingga Tanggal: {{ Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                @else
                    Tampilkan Semua Data
                @endif
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;" class="text-center">No</th>
                        <th>Nama Tamu</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Kategori Keperluan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Jam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tamus as $tamu)
                        <tr>
                            <td class="text-center fw-bold text-secondary">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $tamu->nama }}</td>
                            <td>{{ $tamu->nomor_hp }}</td>
                            <td>{{ $tamu->alamat }}</td>
                            <td>
                                <span class="badge-keperluan">
                                    {{ $tamu->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="text-center fw-medium text-secondary">
                                {{ $tamu->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center fw-bold text-dark">
                                {{ $tamu->created_at->format('H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                <i class="bi bi-journal-x fs-1 d-block mb-3 text-muted"></i>
                                Tidak ada data kunjungan tamu pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
