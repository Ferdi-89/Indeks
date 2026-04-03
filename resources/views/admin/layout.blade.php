<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — R-NET Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #0ea5e9; --accent: #6366f1;
            --dark: #0f172a; --dark-2: #1e293b; --dark-3: #334155;
            --sidebar-w: 250px;
            --text: #e2e8f0; --text-muted: #94a3b8;
            --border: rgba(255,255,255,0.08);
            --success: #10b981; --danger: #ef4444; --warning: #f59e0b;
        }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--text); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w); background: var(--dark-2); border-right: 1px solid var(--border);
            display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh;
            z-index: 100; transition: transform .3s;
        }
        .sidebar-header {
            padding: 1.5rem; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: .6rem;
        }
        .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: .95rem; flex-shrink: 0;
        }
        .sidebar-header .brand { font-size: 1.2rem; font-weight: 800; color: #fff; }
        .sidebar-header .sub { font-size: .65rem; color: var(--text-muted); display: block; }
        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section-label { padding: .5rem 1.25rem; font-size: .65rem; font-weight: 700; color: var(--text-muted); letter-spacing: .1em; text-transform: uppercase; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem 1.25rem; color: var(--text-muted);
            text-decoration: none; font-size: .875rem; font-weight: 500;
            border-radius: 8px; margin: .1rem .75rem;
            transition: background .2s, color .2s;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,.06); color: #fff; }
        .sidebar-nav a.active { background: rgba(14,165,233,.15); color: var(--primary); font-weight: 600; }
        .sidebar-nav a .icon { width: 20px; text-align: center; }
        .sidebar-footer { padding: 1rem; border-top: 1px solid var(--border); }
        .user-info { display: flex; align-items: center; gap: .75rem; padding: .75rem; border-radius: 10px; background: rgba(255,255,255,.04); }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; font-size: .85rem; flex-shrink: 0; }
        .user-name { font-size: .85rem; font-weight: 600; color: #fff; }
        .user-role { font-size: .72rem; color: var(--text-muted); }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
        .topbar {
            background: rgba(30,41,59,.9); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border); padding: 1rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar h2 { font-size: 1.1rem; font-weight: 700; color: #fff; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .btn-logout {
            background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5; padding: .45rem 1rem; border-radius: 8px;
            text-decoration: none; font-size: .8rem; font-weight: 600;
            transition: background .2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,.2); }
        .content { padding: 2rem; flex: 1; }

        /* CARDS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; margin-bottom: 2rem; }
        .stat-card { background: rgba(255,255,255,.04); border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; }
        .stat-card .icon { font-size: 1.5rem; margin-bottom: .75rem; }
        .stat-card .label { font-size: .8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
        .stat-card .value { font-size: 2rem; font-weight: 800; color: #fff; }
        .stat-card.blue { border-color: rgba(14,165,233,.3); }
        .stat-card.blue .icon { color: var(--primary); }
        .stat-card.purple { border-color: rgba(99,102,241,.3); }
        .stat-card.purple .icon { color: var(--accent); }
        .stat-card.green { border-color: rgba(16,185,129,.3); }
        .stat-card.green .icon { color: var(--success); }
        .stat-card.orange { border-color: rgba(245,158,11,.3); }
        .stat-card.orange .icon { color: var(--warning); }

        /* TABLE */
        .table-card { background: rgba(255,255,255,.04); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
        .table-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .table-header h3 { font-size: 1rem; font-weight: 700; color: #fff; }
        table { width: 100%; border-collapse: collapse; }
        th { background: rgba(255,255,255,.03); padding: .75rem 1.25rem; text-align: left; font-size: .75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; }
        td { padding: .9rem 1.25rem; font-size: .875rem; color: var(--text-muted); border-top: 1px solid var(--border); vertical-align: middle; }
        td strong { color: #fff; font-weight: 600; }
        tr:hover td { background: rgba(255,255,255,.02); }
        .badge { display: inline-flex; align-items: center; gap: .3rem; padding: .3rem .7rem; border-radius: 6px; font-size: .72rem; font-weight: 700; }
        .badge-success { background: rgba(16,185,129,.15); color: #6ee7b7; }
        .badge-danger  { background: rgba(239,68,68,.15); color: #fca5a5; }
        .action-btns { display: flex; gap: .5rem; }
        .btn-sm {
            padding: .35rem .75rem; border-radius: 7px; font-size: .78rem; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer; font-family: inherit;
            display: inline-flex; align-items: center; gap: .35rem; transition: opacity .2s;
        }
        .btn-sm:hover { opacity: .8; }
        .btn-sm.primary { background: rgba(14,165,233,.15); color: var(--primary); }
        .btn-sm.danger  { background: rgba(239,68,68,.15);  color: #fca5a5; }
        .btn-sm.success { background: rgba(16,185,129,.15); color: #6ee7b7; }
        .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
        .empty-state i { font-size: 2.5rem; margin-bottom: 1rem; display: block; }

        /* FORM */
        .form-card { background: rgba(255,255,255,.04); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .85rem; font-weight: 600; color: var(--text-muted); margin-bottom: .5rem; }
        .form-control {
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid var(--border);
            color: var(--text); padding: .7rem 1rem; border-radius: 10px;
            font-size: .9rem; font-family: inherit; outline: none; transition: border-color .2s;
        }
        .form-control:focus { border-color: var(--primary); }
        .form-control::placeholder { color: #475569; }
        textarea.form-control { min-height: 100px; resize: vertical; }
        .form-check { display: flex; align-items: center; gap: .5rem; cursor: pointer; }
        .form-check input { accent-color: var(--primary); width: 16px; height: 16px; }
        .form-check label { color: var(--text-muted); font-size: .9rem; cursor: pointer; }
        .btn-primary-action {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; border: none; padding: .75rem 1.75rem;
            border-radius: 10px; font-size: .9rem; font-weight: 700;
            cursor: pointer; font-family: inherit;
            display: inline-flex; align-items: center; gap: .5rem; transition: opacity .2s;
        }
        .btn-primary-action:hover { opacity: .9; }
        .btn-outline-sm {
            background: transparent; border: 1px solid var(--border); color: var(--text-muted);
            padding: .6rem 1.2rem; border-radius: 10px; font-size: .875rem; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: .5rem;
            font-family: inherit; cursor: pointer; transition: border-color .2s, color .2s;
        }
        .btn-outline-sm:hover { border-color: var(--primary); color: var(--primary); }

        /* ALERTS */
        .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.3); color: #6ee7b7; padding: .9rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: .875rem; }
        .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #fca5a5; padding: .9rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: .875rem; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">R</div>
            <div>
                <span class="brand">R-NET</span>
                <span class="sub">Admin Panel</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="nav-dashboard">
                <i class="fa-solid fa-gauge icon"></i> Dashboard
            </a>

            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('admin.pendaftaran') }}" class="{{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}" id="nav-pendaftaran">
                <i class="fa-solid fa-users icon"></i> Pendaftaran
            </a>
            <a href="{{ route('admin.promosi') }}" class="{{ request()->routeIs('admin.promosi*') ? 'active' : '' }}" id="nav-promosi">
                <i class="fa-solid fa-tag icon"></i> Promosi
            </a>
            <a href="{{ route('admin.pesan') }}" class="{{ request()->routeIs('admin.pesan*') ? 'active' : '' }}" id="nav-pesan">
                <i class="fa-solid fa-bullhorn icon"></i> Pesan
            </a>

            <div class="nav-section-label">Lainnya</div>
            <a href="{{ route('home') }}" target="_blank" id="nav-site">
                <i class="fa-solid fa-globe icon"></i> Lihat Website
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <div class="topbar">
            <h2>@yield('title', 'Dashboard')</h2>
            <div class="topbar-right">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;">
                        <a href="#" class="btn-logout" onclick="this.closest('form').submit()" id="btn-logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </a>
                    </button>
                </form>
            </div>
        </div>
        <div class="content">
            @if(session('success'))
                <div class="alert-success"><i class="fa-solid fa-circle-check" style="margin-right:.5rem;"></i>{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)<div><i class="fa-solid fa-circle-exclamation" style="margin-right:.4rem;"></i>{{ $error }}</div>@endforeach
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>
