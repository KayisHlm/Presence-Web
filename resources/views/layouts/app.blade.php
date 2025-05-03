<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Aplikasi</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #212529;
            color: #fff;
            padding: 20px;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar a {
            color: #ced4da;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.2s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #343a40;
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <h4 class="text-white mb-4">✨ MyApp</h4>
        <a href="{{ route('dashboard.home') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('user.index') }}">👥 Data User</a>
        <a href="{{ route('lembur.index') }}" class="{{ request()->is('lembur*') ? 'active' : '' }}">💼 Data Lembur</a>
        <a href="{{ route('absen.index') }}" class="{{ request()->is('absen*') ? 'active' : '' }}">📅 Data Absen</a>
        <a href="{{ route('gaji.index') }}" class="{{ request()->is('gaji*') ? 'active' : '' }}">💰 Data Gaji</a>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand navbar-light bg-white mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Dashboard</span>
            </div>
        </nav>

        <!-- Dynamic Content -->
        @yield('content')
    </div>

</body>
</html>
