<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InventarisKu - DISKOMINFO KOTA BINJAI</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-bg: #00008b; 
            --sidebar-hover: rgba(255, 255, 255, 0.15);
            --sidebar-active: #ffffff; 
            --text-muted: rgba(255, 255, 255, 0.6);
            --sidebar-width: 250px;
        }

        body { background-color: #f8fafc; font-family: 'Figtree', sans-serif; overflow-x: hidden; }
        
        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            margin-left: calc(-1 * var(--sidebar-width));
            transition: margin .25s ease-out;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
        }

        #sidebar-wrapper .sidebar-heading { 
            padding: 2.5rem 1rem 2rem; 
            color: white; 
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: transparent; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo-container {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            padding: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .sidebar-logo { max-width: 100%; max-height: 100%; object-fit: contain; }

        .brand-text {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            line-height: 1.3;
            color: #ffffff;
        }

        .text-accent-city { 
            color: #ff4d4d; 
            display: block; 
            font-size: 0.95rem; 
            font-weight: 800;
            margin-top: 1px;
        } 

        .sidebar-section-title {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-muted);
            padding: 1.5rem 1.5rem 0.5rem;
        }

        #sidebar-wrapper .list-group { width: var(--sidebar-width); flex-grow: 1; }
        
        #sidebar-wrapper .list-group-item { 
            background: transparent; 
            border: none; 
            color: #ffffff; 
            padding: 0.8rem 1.25rem; 
            transition: 0.2s;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            margin: 2px 12px;
            border-radius: 8px;
            text-decoration: none;
        }

        #sidebar-wrapper .list-group-item:hover { 
            background: var(--sidebar-hover); 
            color: #ffffff;
        }
        
        #sidebar-wrapper .list-group-item.active { 
            color: var(--sidebar-bg) !important; 
            background: var(--sidebar-active);
            font-weight: 600;
        }

        .logout-section {
            padding: 1rem 1.25rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }

        .btn-logout-sidebar {
            width: 100%;
            background: #dc3545; 
            color: #ffffff;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        #page-content-wrapper { min-width: 100vw; }
        body.sb-sidenav-toggled #sidebar-wrapper { margin-left: 0; }

        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: calc(-1 * var(--sidebar-width)); }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div id="sidebar-wrapper" class="shadow-lg d-print-none">
            <div class="sidebar-heading">
                <div class="sidebar-logo-container">
                    <img src="{{ asset('images/binjai.png') }}" alt="Logo Binjai" class="sidebar-logo">
                </div>
                <div class="brand-text">
                    DISKOMINFO
                    <span class="text-accent-city">KOTA BINJAI</span>
                </div>
            </div>
            
            <div class="list-group list-group-flush mt-3">
                <div class="sidebar-section-title">Utama</div>
                <a class="list-group-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
                </a>

                @if(Auth::user()->role == 'admin')
                    <div class="sidebar-section-title">Aset & Inventaris</div>
                    <a class="list-group-item {{ request()->routeIs('assets.*') ? 'active' : '' }}" href="{{ route('assets.index') }}">
                        <i class="bi bi-box-seam-fill me-3"></i> Daftar Aset
                    </a>
                    
                    <div class="sidebar-section-title">Transaksi</div>
                    <a class="list-group-item {{ request()->routeIs('borrowings.*') ? 'active' : '' }}" href="{{ route('borrowings.index') }}">
                        <i class="bi bi-arrow-left-right me-3"></i> Peminjaman
                    </a>
                    
                    <div class="sidebar-section-title">Laporan</div>
                    <a class="list-group-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-file-earmark-text-fill me-3"></i> Laporan Bulanan
                    </a>

                    <div class="sidebar-section-title">Pengaturan</div>
                    <a class="list-group-item {{ request()->routeIs('users.*') ? 'error' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-person-gear me-3"></i> Kelola Admin
                    </a>
                @else
                    <div class="sidebar-section-title">Layanan User</div>
                    <a class="list-group-item {{ request()->routeIs('user.assets.index') ? 'active' : '' }}" href="{{ route('user.assets.index') }}">
                        <i class="bi bi-search me-3"></i> Cari & Pinjam Aset
                    </a>
                    <a class="list-group-item {{ request()->routeIs('borrowings.index') ? 'active' : '' }}" href="{{ route('borrowings.index') }}">
                        <i class="bi bi-clock-history me-3"></i> Riwayat Saya
                    </a>
                @endif

                <div class="sidebar-section-title">Personal</div>
                <a class="list-group-item {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                    <i class="bi bi-person-bounding-box me-3"></i> Profil Saya
                </a>
            </div>

            <div class="logout-section">
                <form id="logout-form-sidebar" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
                <a href="#" class="btn-logout-sidebar" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <i class="bi bi-power me-2"></i> Keluar Sistem
                </a>
            </div>
        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-2 d-print-none">
                <div class="container-fluid">
                    <button class="btn btn-sm btn-light border shadow-sm" id="sidebarToggle">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <div class="ms-auto d-flex align-items-center">
                        @auth
                        <div class="d-flex flex-column text-end me-3 d-none d-sm-block">
                            <span class="fw-bold small lh-1 text-dark">{{ Auth::user()->name }}</span>
                            <span class="text-muted" style="font-size: 0.7rem; text-transform: uppercase;">{{ Auth::user()->role }}</span>
                        </div>
                        <div class="vr me-3 d-none d-sm-block" style="height: 30px; opacity: 0.1;"></div>
                        <i class="bi bi-person-circle fs-4 text-primary"></i>
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Toggle Sidebar
            $('#sidebarToggle').on('click', function(e) {
                e.preventDefault();
                $('body').toggleClass('sb-sidenav-toggled');
            });

            // KONFIRMASI HAPUS (Event Delegation agar pasti kena)
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let form = $('#delete-form-' + id);

                Swal.fire({
                    title: 'Hapus data?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#00008b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

</body>
</html>