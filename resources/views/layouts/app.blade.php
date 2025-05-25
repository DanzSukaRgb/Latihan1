<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Modern - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3a7bd5;
            --primary-hover: #2c65b8;
            --secondary-color: #f8f9fa;
            --text-color: #2d3748;
            --text-light: #718096;
            --border-radius: 12px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding-top: 70px;
            background-color: #ffffff;
            color: var(--text-color);
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--text-color) !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-light) !important;
            transition: var(--transition);
            padding: 0.5rem 1rem !important;
            border-radius: var(--border-radius);
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(58, 123, 213, 0.05);
        }

        .nav-link i {
            margin-right: 8px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-md);
            border-radius: var(--border-radius);
            padding: 0.5rem;
            margin-top: 8px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: rgba(58, 123, 213, 0.1);
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .form-control, .form-select {
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(58, 123, 213, 0.15);
        }

        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        .badge-success {
            background-color: #10b981;
        }

        .badge-warning {
            background-color: #f59e0b;
        }

        .badge-info {
            background-color: #3b82f6;
        }

        main.container {
            padding-top: 2rem;
            padding-bottom: 4rem;
        }

        /* Modern white theme extras */
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }
            .navbar-collapse {
                padding: 1rem;
                background-color: white;
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-md);
                margin-top: 8px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-calendar-check me-2" style="color: var(--primary-color);"></i>Absensi Modern
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin*') ? 'active' : '' }}" href="/admin/attendances">
                                    <i class="fas fa-users-cog me-1"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="/login">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="/register">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" class="avatar" alt="Profile">
                                @else
                                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="/profile"><i class="fas fa-user-circle me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
