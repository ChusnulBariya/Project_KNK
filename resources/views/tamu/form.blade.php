<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital - Bimbingan Belajar Meteor</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0052d4;
            --secondary-color: #4364f7;
            --accent-color: #6fb1fc;
            --meteor-gradient: linear-gradient(135deg, #0052d4 0%, #4364f7 50%, #6fb1fc 100%);
            --white: #ffffff;
            --light-bg: #f5f8ff;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--light-bg);
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }
        .header-banner {
            background: var(--meteor-gradient);
            padding: 40px 20px;
            color: var(--white);
            text-align: center;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 4px 15px rgba(0, 82, 212, 0.2);
            margin-bottom: -40px;
            position: relative;
            z-index: 1;
        }
        .logo-icon {
            font-size: 3.5rem;
            margin-bottom: 10px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto 50px;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }
        .card-form {
            background: var(--white);
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 82, 212, 0.08);
            padding: 40px 30px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        .form-label::after {
            content: " *";
            color: red;
        }
        .form-control, .form-select {
            border: 1.5px solid #e1e8ed;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(67, 100, 247, 0.15);
        }
        .btn-submit {
            background: var(--meteor-gradient);
            color: var(--white);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 100, 247, 0.3);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 100, 247, 0.5);
            background: linear-gradient(135deg, #0045b5 0%, #3553d1 50%, #5899eb 100%);
            color: var(--white);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .footer-copyright {
            margin-top: auto;
            text-align: center;
            padding: 20px;
            font-size: 0.8rem;
            color: #7d879c;
        }

    </style>
</head>
<body>

    <!-- Header Banner -->
    <div class="header-banner">
        <div class="logo-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Meteor" style="width:80px;height:80px;object-fit:contain;border-radius:12px;background:#fff;padding:4px;">
        </div>
        <h2 class="fw-bold mb-1">Buku Tamu Digital</h2>
        <h5 class="fw-medium text-white-50">Bimbingan Belajar Meteor</h5>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="card-form">
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-1" style="color: #0f2027">Formulir Kehadiran</h4>
                <p class="text-muted small">Silakan isi data kunjungan Anda dengan lengkap dan benar.</p>
            </div>

            <form action="{{ route('tamu.form.submit') }}" method="POST">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           placeholder="Contoh: Chusnul Bariya" 
                           value="{{ old('nama') }}" 
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nomor HP -->
                <div class="mb-3">
                    <label for="nomor_hp" class="form-label">Nomor HP / WhatsApp</label>
                    <input type="tel" 
                           id="nomor_hp" 
                           name="nomor_hp" 
                           class="form-control @error('nomor_hp') is-invalid @enderror" 
                           placeholder="Contoh: 08123456789" 
                           value="{{ old('nomor_hp') }}" 
                           required>
                    @error('nomor_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" 
                              name="alamat" 
                              rows="3" 
                              class="form-control @error('alamat') is-invalid @enderror" 
                              placeholder="Masukkan alamat rumah Anda" 
                              required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keperluan Kunjungan -->
                <div class="mb-4">
                    <label for="kategori_id" class="form-label">Keperluan Kunjungan</label>
                    <select id="kategori_id" 
                            name="kategori_id" 
                            class="form-select @error('kategori_id') is-invalid @enderror" 
                            required>
                        <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>-- Pilih Keperluan Kunjungan --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-submit w-100">
                    <i class="bi bi-send-fill me-2"></i>Kirim Kehadiran
                </button>
            </form>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="footer-copyright">
        &copy; 2026 Bimbingan Belajar Meteor. Hak Cipta Dilindungi.
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
