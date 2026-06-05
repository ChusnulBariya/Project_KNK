<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Buku Tamu Meteor</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-blue: #0052d4;
            --secondary-blue: #4364f7;
            --accent-blue: #6fb1fc;
            --dark-color: #0f2027;
            --body-bg: #f8fafc;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        /* Sidebar layout */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0f2027 0%, #203a43 100%);
            color: #fff;
            z-index: 100;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand i {
            font-size: 1.8rem;
            color: var(--accent-blue);
        }
        .sidebar-brand span {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .sidebar-menu {
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }
        .sidebar-menu-item {
            margin: 4px 15px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }
        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 4px 12px rgba(67, 100, 247, 0.3);
        }
        .sidebar-link i {
            font-size: 1.2rem;
        }
        
        /* Content area layout */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }
        .top-navbar {
            height: 70px;
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 90;
        }
        .toggle-sidebar-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #333;
        }
        .content-body {
            padding: 30px;
            flex-grow: 1;
        }
        
        /* Footer style */
        .admin-footer {
            padding: 20px 30px;
            background-color: #fff;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
            margin-top: auto;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .top-navbar {
                padding: 0 20px;
            }
            .toggle-sidebar-btn {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Meteor" style="width:42px;height:42px;object-fit:contain;border-radius:8px;background:#fff;padding:2px;">
            <span>Bimbel Meteor<br><small class="text-white-50 fs-6 fw-normal">Buku Tamu Digital</small></span>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.tamu') }}" class="sidebar-link {{ Request::routeIs('admin.tamu*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Data Tamu</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.laporan') }}" class="sidebar-link {{ Request::routeIs('admin.laporan') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('admin.profil') }}" class="sidebar-link {{ Request::routeIs('admin.profil') ? 'active' : '' }}">
                    <i class="bi bi-person-fill-gear"></i>
                    <span>Profil Admin</span>
                </a>
            </li>
            <li class="sidebar-menu-item mt-4 pt-4 border-top border-secondary">
                <form action="{{ route('admin.logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="sidebar-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <button class="toggle-sidebar-btn" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-secondary small d-none d-md-inline">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                <div class="user-profile dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.profil') }}">
                                <i class="bi bi-person-circle me-2 text-primary"></i>Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <div class="content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-left: 4px solid #198754 !important;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-left: 4px solid #dc3545 !important;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Admin Footer -->
        <div class="admin-footer">
            &copy; 2026 Bimbingan Belajar Meteor. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @yield('scripts')
</body>
</html>
