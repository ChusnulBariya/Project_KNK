@extends('layouts.admin')

@section('title', 'Data Tamu')

@section('styles')
<style>
    .search-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
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
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .pagination {
        margin: 0;
        gap: 4px;
    }
    .page-link {
        border-radius: 8px !important;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        transition: all 0.18s ease;
        line-height: 1;
    }
    .page-link:hover {
        background-color: #f0f5ff;
        border-color: #4364f7;
        color: #4364f7;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #0052d4 0%, #4364f7 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(67, 100, 247, 0.35);
    }
    .page-item.disabled .page-link {
        background-color: #f8fafc;
        color: #cbd5e1;
        border-color: #f1f5f9;
        cursor: not-allowed;
    }
    .detail-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .detail-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 500;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark m-0">Data Tamu</h3>
            <p class="text-secondary small">Kelola seluruh riwayat kehadiran pengunjung Bimbingan Belajar Meteor.</p>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card search-card p-4 mb-4 bg-white">
        <form action="{{ route('admin.tamu') }}" method="GET" class="row g-3 align-items-end">
            <!-- Search input -->
            <div class="col-md-5">
                <label for="q" class="form-label fw-semibold small text-secondary">Cari Nama Tamu</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" id="q" class="form-control bg-light border-start-0" placeholder="Masukkan nama tamu..." value="{{ request('q') }}">
                </div>
            </div>

            <!-- Date filter -->
            <div class="col-md-4">
                <label for="tanggal" class="form-label fw-semibold small text-secondary">Filter Tanggal Kunjungan</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-calendar3"></i></span>
                    <input type="date" name="tanggal" id="tanggal" class="form-control bg-light border-start-0" value="{{ request('tanggal') }}">
                </div>
            </div>

            <!-- Buttons -->
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3">
                    <i class="bi bi-funnel-fill me-1"></i>Filter
                </button>
                @if(request('q') || request('tanggal'))
                    <a href="{{ route('admin.tamu') }}" class="btn btn-light border w-100 fw-bold py-2 rounded-3 text-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card table-card bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;" class="text-center">No</th>
                        <th>Nama Tamu</th>
                        <th>Nomor HP</th>
                        <th style="max-width: 250px;">Alamat</th>
                        <th>Kategori Keperluan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Jam</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tamus as $tamu)
                        <tr>
                            <td class="text-center fw-bold text-secondary">{{ $tamus->firstItem() + $loop->index }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $tamu->nama }}</span>
                            </td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $tamu->nomor_hp) }}" target="_blank" class="text-decoration-none text-secondary">
                                    <i class="bi bi-whatsapp text-success me-1"></i>{{ $tamu->nomor_hp }}
                                </a>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 230px;" title="{{ $tamu->alamat }}">
                                    {{ $tamu->alamat }}
                                </span>
                            </td>
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
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Detail Button -->
                                    <button class="btn btn-outline-info btn-action" 
                                            title="Detail Tamu" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal"
                                            data-nama="{{ $tamu->nama }}"
                                            data-hp="{{ $tamu->nomor_hp }}"
                                            data-alamat="{{ $tamu->alamat }}"
                                            data-kategori="{{ $tamu->kategori->nama_kategori }}"
                                            data-tanggal="{{ $tamu->created_at->translatedFormat('l, d F Y') }}"
                                            data-jam="{{ $tamu->created_at->format('H:i') }} WIB">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.tamu.delete', $tamu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tamu ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-action" title="Hapus Tamu">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-secondary">
                                <i class="bi bi-journal-x fs-1 d-block mb-3 text-muted"></i>
                                Tidak ada data kunjungan tamu ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="text-secondary small">
                @if($tamus->total() > 0)
                    Menampilkan <strong>{{ $tamus->firstItem() }}–{{ $tamus->lastItem() }}</strong>
                    dari <strong>{{ $tamus->total() }}</strong> tamu
                @else
                    Tidak ada data tamu
                @endif
            </span>
            @if($tamus->hasPages())
                <div>
                    {{ $tamus->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 bg-primary text-white py-3" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold" id="detailModalLabel"><i class="bi bi-info-circle-fill me-2"></i>Detail Kunjungan Tamu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-12">
                        <div class="detail-label">Nama Tamu</div>
                        <div class="detail-value fs-5 fw-bold text-dark" id="modal-nama">-</div>
                        
                        <div class="detail-label">Nomor HP</div>
                        <div class="detail-value" id="modal-hp">-</div>

                        <div class="detail-label">Alamat</div>
                        <div class="detail-value bg-light p-3 rounded-3" id="modal-alamat">-</div>

                        <div class="detail-label">Kategori Keperluan</div>
                        <div class="detail-value" id="modal-kategori">
                            <span class="badge-keperluan" id="modal-badge-kategori">-</span>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="detail-label">Tanggal Kunjungan</div>
                                <div class="detail-value" id="modal-tanggal">-</div>
                            </div>
                            <div class="col-6">
                                <div class="detail-label">Waktu Kunjungan</div>
                                <div class="detail-value" id="modal-jam">-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 justify-content-center">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-3 fw-bold" data-bs-dismiss="modal">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Handle data pass to Detail Modal dynamically
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        const button = event.relatedTarget;
        
        // Extract info from data-* attributes
        const nama = button.getAttribute('data-nama');
        const hp = button.getAttribute('data-hp');
        const alamat = button.getAttribute('data-alamat');
        const kategori = button.getAttribute('data-kategori');
        const tanggal = button.getAttribute('data-tanggal');
        const jam = button.getAttribute('data-jam');

        // Update the modal's content
        detailModal.querySelector('#modal-nama').textContent = nama;
        detailModal.querySelector('#modal-hp').textContent = hp;
        detailModal.querySelector('#modal-alamat').textContent = alamat;
        detailModal.querySelector('#modal-kategori').innerHTML = `<span class="badge-keperluan">${kategori}</span>`;
        detailModal.querySelector('#modal-tanggal').textContent = tanggal;
        detailModal.querySelector('#modal-jam').textContent = jam;
    });
</script>
@endsection
