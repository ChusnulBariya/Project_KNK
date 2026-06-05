<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Buku Tamu Digital Bimbingan Belajar Meteor</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --bg-gradient: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            --meteor-gradient: linear-gradient(135deg, #0052d4 0%, #4364f7 50%, #6fb1fc 100%);
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow-x: hidden;
            position: relative;
        }
        /* Background decorative elements */
        body::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(13, 110, 253, 0.15);
            top: -50px;
            right: -50px;
            filter: blur(80px);
            z-index: 1;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(111, 177, 252, 0.15);
            bottom: -100px;
            left: -100px;
            filter: blur(100px);
            z-index: 1;
        }
        .login-container {
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 15px;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        .card-header-gradient {
            background: var(--meteor-gradient);
            padding: 40px 20px;
            text-align: center;
            color: #fff;
            position: relative;
        }
        .logo-circle {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 32px;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-body {
            padding: 40px 30px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #6c757d;
        }
        .form-control {
            border-left: none;
            padding: 10px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        .input-group:focus-within .form-control {
            border-color: var(--primary-color);
        }
        .btn-login {
            background: var(--meteor-gradient);
            border: none;
            padding: 12px;
            font-weight: 700;
            border-radius: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(67, 100, 247, 0.4);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #0043b3 0%, #3252d9 50%, #589deb 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 100, 247, 0.6);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .alert {
            border-radius: 12px;
            font-size: 0.85rem;
        }
        .footer-text {
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="card-header-gradient">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Meteor" style="width:56px;height:56px;object-fit:contain;border-radius:8px;background:#fff;padding:3px;">
                </div>
                <h4 class="mb-0 fw-bold">Admin Login</h4>
                <p class="mb-0 text-white-50 small">Bimbingan Belajar Meteor</p>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf
                    <!-- Username Input -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   placeholder="Masukkan username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autocomplete="username">
                        </div>
                        @error('username')
                            <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control" 
                                   placeholder="Masukkan password" 
                                   required 
                                   autocomplete="current-password">
                        </div>
                        @error('password')
                            <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me checkbox -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label class="form-check-label text-secondary small" for="remember">Ingat Saya</label>
                        </div>
                        <a href="{{ route('tamu.form') }}" class="text-decoration-none small text-primary fw-semibold">
                            <i class="bi bi-journal-text me-1"></i>Buku Tamu
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 btn-login text-white">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-text">
            &copy; 2026 Bimbingan Belajar Meteor. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
