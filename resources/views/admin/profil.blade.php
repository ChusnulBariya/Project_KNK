@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('styles')
<style>
    .profile-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
    }
    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.92rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #4364f7;
        box-shadow: 0 0 0 3px rgba(67, 100, 247, 0.15);
    }
    .btn-save {
        background: linear-gradient(135deg, #0052d4 0%, #4364f7 100%);
        color: #fff;
        border: none;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px 24px;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(67, 100, 247, 0.2);
    }
    .btn-save:hover {
        background: linear-gradient(135deg, #0045b5 0%, #3553d1 50%, #5899eb 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(67, 100, 247, 0.3);
        color: #fff;
    }
    .btn-save:active {
        transform: translateY(0);
    }
    .admin-info-badge {
        background-color: rgba(0, 82, 212, 0.05);
        border: 1px dashed rgba(0, 82, 212, 0.15);
        border-radius: 12px;
        padding: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark m-0">Profil Admin</h3>
            <p class="text-secondary small">Kelola informasi profil dan ubah kata sandi akun Anda.</p>
        </div>
    </div>

    <!-- Error Alert from validations -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-left: 4px solid #dc3545 !important;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Terjadi kesalahan!</strong> Harap periksa kembali inputan Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Edit Profile Section -->
        <div class="col-lg-6 mb-4">
            <div class="card profile-card p-4 bg-white h-100">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                    <i class="bi bi-person-circle text-primary fs-4"></i>
                    <h5 class="fw-bold text-dark m-0">Ubah Profil</h5>
                </div>

                <div class="admin-info-badge mb-4">
                    <div class="row align-items-center">
                        <div class="col-3 col-md-2 text-center">
                            <i class="bi bi-shield-check text-primary display-6"></i>
                        </div>
                        <div class="col-9 col-md-10">
                            <h6 class="fw-bold text-dark mb-0">Role: Admin Utama</h6>
                            <span class="text-secondary small">Terdaftar sejak: {{ $admin->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $admin->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               class="form-control @error('username') is-invalid @enderror" 
                               value="{{ old('username', $admin->username) }}" 
                               required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $admin->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-check2-circle me-1"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="col-lg-6 mb-4">
            <div class="card profile-card p-4 bg-white h-100">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                    <i class="bi bi-key-fill text-primary fs-4"></i>
                    <h5 class="fw-bold text-dark m-0">Ubah Password</h5>
                </div>

                <form action="{{ route('admin.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               placeholder="Masukkan password saat ini" 
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Minimal 8 karakter" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="form-control" 
                               placeholder="Ketik ulang password baru" 
                               required>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-lock me-1"></i>Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
