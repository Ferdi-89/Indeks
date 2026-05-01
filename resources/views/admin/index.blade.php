@extends('admin.layouts.main')

@section('title', 'Admin Panel')

@section('content')
<div class="w-full" id="admin-spa-container">
    
    <!-- Tab Dashboard -->
    <div class="admin-tab-panel" id="panel-dashboard">
        @include('admin.partials.dashboard')
    </div>

    <!-- Tab Pendaftaran -->
    <div class="admin-tab-panel" id="panel-pendaftaran" style="display:none;">
        @include('admin.partials.pendaftaran')
    </div>

    <!-- Tab Paket -->
    <div class="admin-tab-panel" id="panel-paket" style="display:none;">
        @include('admin.partials.paket')
    </div>

    <!-- Tab Pengumuman -->
    <div class="admin-tab-panel" id="panel-pengumuman" style="display:none;">
        @include('admin.partials.pengumuman')
    </div>

    <!-- Tab Promosi -->
    <div class="admin-tab-panel" id="panel-promosi" style="display:none;">
        @include('admin.partials.promosi')
    </div>

    <!-- Tab Profil -->
    <div class="admin-tab-panel" id="panel-profil" style="display:none;">
        @include('admin.partials.profil')
    </div>

    <!-- Tab Pengaturan -->
    <div class="admin-tab-panel" id="panel-pengaturan" style="display:none;">
        @include('admin.partials.pengaturan')
    </div>

    <!-- Tab Monitoring -->
    <div class="admin-tab-panel" id="panel-monitoring" style="display:none;">
        @include('admin.partials.monitoring')
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ═══════════════════════════════════════════
    // Admin SPA Tab Controller (Vanilla JS)
    // ═══════════════════════════════════════════
    const VALID_TABS = ['dashboard', 'pendaftaran', 'paket', 'pengumuman', 'promosi', 'profil', 'pengaturan', 'monitoring'];
    const TAB_TITLES = {
        dashboard: 'Dasbor',
        pendaftaran: 'Pendaftaran',
        paket: 'Paket Internet',
        pengumuman: 'Pengumuman',
        promosi: 'Promosi',
        profil: 'Profil Admin',
        pengaturan: 'Pengaturan Perusahaan',
        monitoring: 'Monitoring Sistem'
    };

    function switchTab(tabName) {
        if (!VALID_TABS.includes(tabName)) tabName = 'dashboard';

        // Hide all panels
        document.querySelectorAll('.admin-tab-panel').forEach(p => {
            p.style.display = 'none';
        });

        // Show target panel
        const target = document.getElementById('panel-' + tabName);
        if (target) target.style.display = '';

        // Update sidebar active state
        document.querySelectorAll('.admin-nav-link').forEach(link => {
            const linkTab = link.getAttribute('data-tab');
            if (linkTab === tabName) {
                link.classList.add('active', 'bg-white/20');
                link.classList.remove('hover:bg-blue-800');
            } else {
                link.classList.remove('active', 'bg-white/20');
                link.classList.add('hover:bg-blue-800');
            }
        });

        // Update navbar title
        const titleEl = document.getElementById('navbar-title');
        if (titleEl) titleEl.textContent = TAB_TITLES[tabName] || 'Dasbor';

        // Update URL hash
        window.location.hash = tabName;

        // Re-init chart if switching to dashboard
        if (tabName === 'dashboard' && window.initDashboardChart) {
            setTimeout(() => window.initDashboardChart(), 150);
        }
    }

    // Init on page load
    document.addEventListener('DOMContentLoaded', () => {
        // Bind sidebar clicks
        document.querySelectorAll('.admin-nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                switchTab(link.getAttribute('data-tab'));
            });
        });

        // Read initial hash
        const hash = window.location.hash.substring(1);
        switchTab(VALID_TABS.includes(hash) ? hash : 'dashboard');
    });

    // Handle browser back/forward
    window.addEventListener('hashchange', () => {
        const hash = window.location.hash.substring(1);
        switchTab(VALID_TABS.includes(hash) ? hash : 'dashboard');
    });

    // ═══════════════════════════════════════════
    // Chart.js Initialization
    // ═══════════════════════════════════════════
    window.initDashboardChart = function() {
        const canvas = document.getElementById('regChart');
        if (!canvas) return;
        
        if (window.regChartInstance) {
            window.regChartInstance.destroy();
        }

        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        window.regChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $chartLabels !!},
                datasets: [{
                    label: 'Pendaftaran',
                    data: {!! $chartValues !!},
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false } },
                    x: { grid: { display: false } }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    };
</script>
@endsection
