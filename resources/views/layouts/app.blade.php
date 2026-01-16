<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Perpustakaan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --soft-brown: #C4A484;
            --dark-tea-brown: #8B6F47;
            --cream: #F5EFE6;
            --light-beige: #E8DCC8;
            --white: #FFFFFF;
            --border-soft: #D6D3CE;
        }
        
        body {
            background-color: var(--cream);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        .sidebar {
            background-color: var(--white);
            border-right: 1px solid var(--border-soft);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 10;
        }
        
        .sidebar-link {
            color: var(--dark-tea-brown);
            padding: 12px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: var(--light-beige);
            color: var(--dark-tea-brown);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .navbar {
            background-color: var(--white);
            border-bottom: 1px solid var(--border-soft);
            padding: 16px 24px;
        }
        
        .card {
            background-color: var(--white);
            border: 1px solid var(--border-soft);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .btn-primary {
            background-color: var(--soft-brown);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-tea-brown);
        }
        
        .btn-secondary {
            background-color: #E8E8E8;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #D8D8D8;
        }
        
        .btn-success {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #45a049;
        }
        
        .btn-danger {
            background-color: #f44336;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #da190b;
        }

        /* Animasi tombol */
        .btn-animate {
            transition: all 0.3s ease;
        }

        .btn-animate:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-animate:active {
            transform: translateY(0);
        }

        /* Efek ripple untuk tombol */
        .ripple {
            position: relative;
            overflow: hidden;
            transform: translateZ(0);
        }

        .ripple::after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10,10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }

        .ripple:active::after {
            transform: scale(0,0);
            opacity: .3;
            transition: 0s;
        }
    </style>
    <script src="{{ asset('js/button-animation.js') }}"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-center" style="color: var(--dark-tea-brown);">
                <i class="fas fa-book"></i> Perpustakaan
            </h1>
        </div>
        
        <div class="p-4">
            <!-- Menu untuk Admin -->
            @if(Auth::check() && Auth::user()->isAdmin())
                <div class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </div>
                
                <div class="mb-2">
                    <a href="{{ route('admin.books.index') }}" class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <i class="fas fa-book mr-3"></i> Data Buku
                    </a>
                </div>

                <div class="mb-2">
                    <a href="{{ route('admin.members.index') }}" class="sidebar-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                        <i class="fas fa-users mr-3"></i> Data Anggota
                    </a>
                </div>
                
                <div class="mb-2">
                    <a href="{{ route('admin.transactions.index') }}" class="sidebar-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt mr-3"></i> Transaksi
                    </a>
                </div>

            @endif
            
            <!-- Menu untuk Siswa -->
            @if(Auth::check() && Auth::user()->isStudent())
                <div class="mb-2">
                    <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </div>

                <div class="mb-2">
                    <a href="{{ route('student.books.index') }}" class="sidebar-link {{ request()->routeIs('student.books.*') ? 'active' : '' }}">
                        <i class="fas fa-book mr-3"></i> Daftar Buku
                    </a>
                </div>

                <div class="mb-2">
                    <a href="{{ route('student.transactions.index') }}" class="sidebar-link {{ request()->routeIs('student.transactions.*') ? 'active' : '' }}">
                        <i class="fas fa-history mr-3"></i> Riwayat Saya
                    </a>
                </div>
            @endif
        </div>
        
        <div class="absolute bottom-0 w-60 p-4 border-t border-gray-200">
            <div class="flex items-center">
                <div class="mr-3">
                    <i class="fas fa-user-circle text-2xl" style="color: var(--soft-brown);"></i>
                </div>
                <div>
                    <p class="text-sm font-medium" style="color: var(--dark-tea-brown);">{{ Auth::user()->username ?? 'Guest' }}</p>
                    <span class="text-xs text-gray-500">{{ Auth::user()->role ?? '' }}</span>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="mt-3 block text-center btn-primary py-2 px-4 rounded text-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <div class="navbar flex justify-between items-center">
            <h2 class="text-xl font-semibold">@yield('page-title', 'Dashboard')</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Halo, {{ Auth::user()->username ?? 'Guest' }}!</span>
            </div>
        </div>

        <!-- Content -->
        <div class="mt-6">
            @yield('content')
        </div>
    </div>

    <script>
        // Simple script for sidebar active state
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href;
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            
            sidebarLinks.forEach(link => {
                if (currentUrl.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>