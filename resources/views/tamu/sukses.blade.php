<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran Berhasil Dicatat - Bimbingan Belajar Meteor</title>
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
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 15px;
        }
        .success-card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 82, 212, 0.08);
            max-width: 550px;
            width: 100%;
            padding: 50px 40px;
            text-align: center;
            border: 1px solid rgba(0, 82, 212, 0.05);
            animation: slideIn 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        }
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .success-icon-container {
            width: 100px;
            height: 100px;
            background: var(--meteor-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 25px rgba(67, 100, 247, 0.4);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(67, 100, 247, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(67, 100, 247, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(67, 100, 247, 0);
            }
        }
        .success-icon {
            font-size: 3rem;
            color: var(--white);
        }
        .welcome-title {
            color: #0f2027;
            font-weight: 800;
            font-size: 1.8rem;
            line-height: 1.3;
            margin-bottom: 15px;
        }
        .guest-name {
            background: var(--meteor-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            display: block;
            margin-top: 5px;
            font-size: 2.1rem;
        }
        .message-body {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        .btn-back {
            background: var(--meteor-gradient);
            color: var(--white);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 100, 247, 0.3);
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 100, 247, 0.5);
            background: linear-gradient(135deg, #0045b5 0%, #3553d1 50%, #5899eb 100%);
            color: var(--white);
        }
        .btn-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="success-card">
        <!-- Icon -->
        <div class="success-icon-container">
            <i class="bi bi-check-lg success-icon"></i>
        </div>

        <!-- Welcome Message -->
        <h2 class="welcome-title">
            Selamat Datang di<br>Bimbingan Belajar Meteor, 
            <span class="guest-name">{{ $namaTamu ?? 'Pengunjung' }}</span>
        </h2>

        <!-- Description -->
        <p class="message-body">
            Terima kasih telah mengisi buku tamu digital kami. Data kunjungan Anda telah berhasil disimpan ke dalam sistem kami.
        </p>

        <!-- Back Button -->
        <a href="{{ route('tamu.form') }}" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Formulir
        </a>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
