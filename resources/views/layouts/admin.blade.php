<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Roam Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy:       #0B1C2E;
            --navy-mid:   #152A42;
            --teal:       #0D7C78;
            --teal-light: #13A89E;
            --sky:        #5BC4D4;
            --sky-pale:   #E8F7F9;
            --coral:      #E8714A;
            --coral-dark: #d4623b;
            --cream:      #FAFAF8;
            --gray-100:   #F4F4F2;
            --gray-200:   #E8E8E4;
            --gray-400:   #ADADAA;
            --gray-600:   #6B6B68;
            --gray-800:   #3A3A38;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-body:    'DM Sans', sans-serif;
            --transition:   0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-full: 9999px;
            --shadow-sm: 0 2px 12px rgba(11,28,46,.06);
            --shadow-md: 0 8px 32px rgba(11,28,46,.10);
            --shadow-lg: 0 20px 60px rgba(11,28,46,.14);
            --sidebar-w: 260px;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            background: #F1F3F7;
            color: var(--gray-800);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Sidebar ───────────────────────────────────── */
        #adminSidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w); background: var(--navy);
            display: flex; flex-direction: column;
            z-index: 200; overflow-y: auto;
        }
        .sidebar-brand {
            padding: 24px 22px 18px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand-icon {
            width: 36px; height: 36px; background: var(--teal);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; color: white; font-size: 15px;
            flex-shrink: 0;
        }
        .sidebar-brand-text {
            font-family: var(--font-display);
            font-size: 1.25rem; font-weight: 700;
            color: white; line-height: 1;
        }
        .sidebar-brand-sub { font-size: .7rem; color: rgba(255,255,255,.4); letter-spacing: .06em; text-transform: uppercase; }

        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-section-label {
            font-size: .68rem; font-weight: 600;
            color: rgba(255,255,255,.3); letter-spacing: .1em;
            text-transform: uppercase; padding: 14px 10px 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 12px; border-radius: var(--radius-sm);
            color: rgba(255,255,255,.6); font-size: .875rem; font-weight: 500;
            text-decoration: none; transition: var(--transition);
            margin-bottom: 2px;
        }
        .sidebar-link i { width: 18px; text-align: center; font-size: 14px; flex-shrink: 0; }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,.09);
            color: white;
        }
        .sidebar-link.active { background: rgba(13,124,120,.25); color: var(--sky); font-weight: 600; }
        .sidebar-link .badge-pill {
            margin-left: auto;
            background: rgba(255,255,255,.12); color: rgba(255,255,255,.6);
            font-size: .68rem; padding: 2px 8px; border-radius: var(--radius-full);
        }

        .sidebar-footer {
            padding: 14px 20px 20px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-user-name { font-size: .875rem; font-weight: 600; color: white; }
        .sidebar-user-role { font-size: .75rem; color: rgba(255,255,255,.4); }

        /* ── Top Bar ───────────────────────────────────── */
        #adminTopbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0;
            height: 64px; background: white;
            border-bottom: 1px solid var(--gray-200);
            display: flex; align-items: center;
            padding: 0 28px; gap: 16px;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .topbar-title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; color: var(--navy); flex: 1; }
        .topbar-view-site {
            display: flex; align-items: center; gap: 7px;
            font-size: .8rem; color: var(--gray-600); text-decoration: none;
            padding: 7px 14px; border-radius: var(--radius-full);
            border: 1.5px solid var(--gray-200); transition: var(--transition);
        }
        .topbar-view-site:hover { border-color: var(--teal); color: var(--teal); }

        /* ── Main ──────────────────────────────────────── */
        #adminMain {
            margin-left: var(--sidebar-w);
            padding: 84px 28px 40px;
            min-height: 100vh;
        }

        /* ── Cards / Stats ─────────────────────────────── */
        .admin-card {
            background: white; border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm); padding: 24px;
        }
        .stat-card {
            background: white; border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm); padding: 24px 26px;
            display: flex; align-items: center; gap: 18px;
        }
        .stat-icon {
            width: 52px; height: 52px; border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-value { font-family: var(--font-display); font-size: 2rem; font-weight: 700; color: var(--navy); line-height: 1; }
        .stat-label { font-size: .82rem; color: var(--gray-400); margin-top: 3px; }

        /* ── Tables ────────────────────────────────────── */
        .admin-table thead th {
            background: var(--gray-100); color: var(--gray-600);
            font-size: .75rem; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            border: none; padding: 12px 16px;
        }
        .admin-table tbody td {
            border-color: var(--gray-100); padding: 13px 16px;
            vertical-align: middle; font-size: .875rem;
        }
        .admin-table tbody tr:hover { background: var(--cream); }

        /* ── Buttons ───────────────────────────────────── */
        .btn-admin-primary {
            background: var(--teal); color: white; border: none;
            padding: 10px 20px; border-radius: var(--radius-sm);
            font-size: .875rem; font-weight: 600; cursor: pointer;
            transition: var(--transition); text-decoration: none;
            display: inline-flex; align-items: center; gap: 7px;
        }
        .btn-admin-primary:hover { background: var(--teal-light); color: white; transform: translateY(-1px); }
        .btn-admin-danger {
            background: #FEE2E2; color: #DC2626; border: none;
            padding: 7px 14px; border-radius: var(--radius-sm);
            font-size: .8rem; font-weight: 600; cursor: pointer;
            transition: var(--transition); text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-admin-danger:hover { background: #DC2626; color: white; }
        .btn-admin-edit {
            background: var(--sky-pale); color: var(--teal); border: none;
            padding: 7px 14px; border-radius: var(--radius-sm);
            font-size: .8rem; font-weight: 600; cursor: pointer;
            transition: var(--transition); text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-admin-edit:hover { background: var(--teal); color: white; }

        /* ── Forms ─────────────────────────────────────── */
        .admin-form label {
            font-size: .82rem; font-weight: 600;
            color: var(--gray-800); margin-bottom: 6px;
        }
        .admin-form .form-control,
        .admin-form .form-select {
            border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm);
            padding: 11px 14px; font-size: .875rem; color: var(--gray-800);
            transition: border-color var(--transition), box-shadow var(--transition);
            background: white;
        }
        .admin-form .form-control:focus,
        .admin-form .form-select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(13,124,120,.1);
            outline: none;
        }
        .form-hint { font-size: .75rem; color: var(--gray-400); margin-top: 4px; }

        /* ── Badges ────────────────────────────────────── */
        .badge-on  { background: #D1FAE5; color: #065F46; padding: 4px 10px; border-radius: var(--radius-full); font-size: .72rem; font-weight: 600; }
        .badge-off { background: var(--gray-100); color: var(--gray-400); padding: 4px 10px; border-radius: var(--radius-full); font-size: .72rem; font-weight: 600; }

        /* ── Alerts ────────────────────────────────────── */
        .alert-admin {
            border: none; border-radius: var(--radius-sm);
            padding: 13px 18px; font-size: .875rem;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success-admin { background: #D1FAE5; color: #065F46; }
        .alert-danger-admin  { background: #FEE2E2; color: #991B1B; }

        /* ── Responsive ────────────────────────────────── */
        @media (max-width: 992px) {
            #adminSidebar { transform: translateX(-100%); transition: transform .3s ease; }
            #adminSidebar.open { transform: translateX(0); }
            #adminTopbar { left: 0; }
            #adminMain { margin-left: 0; padding: 80px 16px 40px; }
        }

        @yield('extra-css')
    </style>
</head>
<body>

{{-- Sidebar --}}
<aside id="adminSidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon"><i class="fas fa-compass"></i></div>
        <div>
            <div class="sidebar-brand-text">Roam</div>
            <div class="sidebar-brand-sub">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="sidebar-section-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="sidebar-section-label mt-2">Content</div>
        <a href="{{ route('admin.destinations.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
            <i class="fas fa-map-marked-alt"></i> Destinations
        </a>
        <a href="{{ route('admin.blog.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
            <i class="fas fa-pen-nib"></i> Blog Posts
        </a>

        <div class="sidebar-section-label mt-2">Quick Add</div>
        <a href="{{ route('admin.destinations.create') }}" class="sidebar-link">
            <i class="fas fa-plus-circle"></i> New Destination
        </a>
        <a href="{{ route('admin.blog.create') }}" class="sidebar-link">
            <i class="fas fa-file-alt"></i> New Blog Post
        </a>

        <div class="sidebar-section-label mt-2">Content</div>
        <a href="{{ route('admin.pages.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <i class="fas fa-file-lines"></i> Page Content
        </a>

        <div class="sidebar-section-label mt-2">Site</div>
        <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
            <i class="fas fa-external-link-alt"></i> View Website
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--teal); color: white; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                @csrf
                <button type="submit" style="background: none; border: none; color: rgba(255,255,255,.4); font-size: 14px; cursor: pointer; padding: 4px;" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Top Bar --}}
<header id="adminTopbar">
    <button class="d-lg-none btn p-0 me-2" style="color: var(--navy);" id="sidebarToggle">
        <i class="fas fa-bars" style="font-size: 18px;"></i>
    </button>
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    @yield('topbar-actions')
    <a href="{{ route('home') }}" target="_blank" class="topbar-view-site">
        <i class="fas fa-external-link-alt"></i> View Site
    </a>
</header>

{{-- Main Content --}}
<main id="adminMain">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert-admin alert-success-admin rounded-2 mb-4">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size: .75rem;"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert-admin alert-danger-admin rounded-2 mb-4">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size: .75rem;"></button>
    </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
// Sidebar toggle (mobile)
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('adminSidebar').classList.toggle('open');
});

// CSRF setup for jQuery
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>

@yield('extra-js')
@stack('scripts')
</body>
</html>
