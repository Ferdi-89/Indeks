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

    <!-- Tab Wilayah -->
    <div class="admin-tab-panel" id="panel-wilayah" style="display:none;">
        @include('admin.partials.wilayah')
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
        <div class="flex flex-col items-center justify-center py-20 text-center" id="monitoring-loader">
            <span class="loading loading-spinner loading-lg text-primary mb-4"></span>
            <p class="text-base-content/70 font-medium">Memuat data monitoring sistem...</p>
        </div>
        <div id="monitoring-content"></div>
    </div>

    <!-- Tab Server -->
    <div class="admin-tab-panel" id="panel-server" style="display:none;">
        @include('admin.partials.server')
    </div>

</div>
@endsection

@section('scripts')
<script>
    // ═══════════════════════════════════════════
    // Lazy-load helper
    // ═══════════════════════════════════════════
    function loadScript(src, onload) {
        if (document.querySelector(`script[src="${src}"]`)) { onload && onload(); return; }
        const s = document.createElement('script'); s.src = src; s.onload = onload; document.head.appendChild(s);
    }
    function loadStyle(href) {
        if (document.querySelector(`link[href="${href}"]`)) return;
        const l = document.createElement('link'); l.rel = 'stylesheet'; l.href = href; document.head.appendChild(l);
    }

    // ═══════════════════════════════════════════
    // Global Toast Helper (dipakai seluruh SPA)
    // ═══════════════════════════════════════════
    function spaToast(message, type = 'success') {
        const existing = document.getElementById('_spa_toast');
        if (existing) existing.remove();
        const alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-error' : type === 'warning' ? 'alert-warning' : 'alert-info';
        const iconPath   = type === 'error'
            ? 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
            : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
        const t = document.createElement('div');
        t.id = '_spa_toast';
        t.className = 'toast toast-end toast-bottom z-[9999]';
        t.innerHTML = `<div class="alert ${alertClass} shadow-lg max-w-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"/></svg>
            <span class="text-sm">${message}</span></div>`;
        document.body.appendChild(t);
        setTimeout(() => t.style.opacity = '0', 3000);
        setTimeout(() => t.remove(), 3400);
    }
    // Alias lama (dipakai di beberapa partial)
    window.showToast = spaToast;

    // ═══════════════════════════════════════════
    // Admin SPA Tab Controller (Vanilla JS)
    // ═══════════════════════════════════════════
    const VALID_TABS = ['dashboard', 'pendaftaran', 'paket', 'pengumuman', 'promosi', 'wilayah', 'profil', 'pengaturan', 'monitoring', 'server'];
    const TAB_TITLES = {
        dashboard: 'Dasbor',
        pendaftaran: 'Pendaftaran',
        paket: 'Paket Internet',
        pengumuman: 'Pengumuman',
        promosi: 'Promosi',
        wilayah: 'Wilayah Layanan',
        profil: 'Profil Admin',
        pengaturan: 'Pengaturan Perusahaan',
        monitoring: 'Monitoring Sistem',
        server: 'Kontrol Server'
    };

    function switchTab(tabName) {
        if (!VALID_TABS.includes(tabName)) tabName = 'dashboard';

        document.querySelectorAll('.admin-tab-panel').forEach(p => { p.style.display = 'none'; });

        const target = document.getElementById('panel-' + tabName);
        if (target) target.style.display = '';

        document.querySelectorAll('.admin-nav-link').forEach(link => {
            const linkTab = link.getAttribute('data-tab');
            if (linkTab === tabName) {
                link.classList.add('active', 'bg-primary/10', 'text-primary', 'font-semibold');
                link.classList.remove('hover:bg-base-200');
            } else {
                link.classList.remove('active', 'bg-primary/10', 'text-primary', 'font-semibold');
                link.classList.add('hover:bg-base-200');
            }
        });

        const titleEl = document.getElementById('navbar-title');
        if (titleEl) titleEl.textContent = TAB_TITLES[tabName] || 'Dasbor';
        window.location.hash = tabName;

        // Lazy-load Chart.js hanya saat Dashboard pertama kali dibuka
        if (tabName === 'dashboard') {
            if (typeof Chart !== 'undefined') {
                setTimeout(() => window.initDashboardChart && window.initDashboardChart(), 150);
            } else {
                loadScript('https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', () => {
                    setTimeout(() => window.initDashboardChart && window.initDashboardChart(), 150);
                });
            }
        }

        // Async load monitoring
        if (tabName === 'monitoring' && !window.monitoringLoaded) {
            _loadMonitoring();
        }
    }

    // ── Fungsi load/refresh monitoring panel ──
    function _loadMonitoring() {
        const loader  = document.getElementById('monitoring-loader');
        const content = document.getElementById('monitoring-content');
        if (loader)  loader.style.display = '';
        if (content) content.innerHTML = '';
        fetch("{{ route('admin.api.monitoring') }}")
            .then(res => res.text())
            .then(html => {
                if (content) content.innerHTML = html;
                if (loader)  loader.style.display = 'none';
                window.monitoringLoaded = true;
            })
            .catch(() => {
                if (loader) loader.innerHTML = '<p class="text-error font-medium">Gagal memuat data monitoring.</p>';
            });
    }

    // Tombol refresh di monitoring partial (tanpa reload halaman)
    window.monitoringRefresh = function() {
        window.monitoringLoaded = false;
        const btn  = document.getElementById('monitoring-refresh-btn');
        const icon = document.getElementById('monitoring-refresh-icon');
        if (btn)  btn.disabled = true;
        if (icon) icon.classList.add('animate-spin');
        _loadMonitoring();
        setTimeout(() => {
            if (btn)  btn.disabled = false;
            if (icon) icon.classList.remove('animate-spin');
        }, 2000);
    };

    // ═══════════════════════════════════════════
    // Lazy-load Leaflet saat modal Detail dibuka
    // ═══════════════════════════════════════════
    const LEAFLET_CSS = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    const LEAFLET_JS  = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';

    window.openDetailModal = function(modalId, lat, lng, mapId, imgId, imgSrc) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        // Lazy-load gambar
        const img = document.getElementById(imgId);
        if (img && !img.src) img.src = img.getAttribute('data-src') || imgSrc;

        modal.showModal();

        // Lazy-load Leaflet + render peta
        if (!window['map_init_' + mapId]) {
            loadStyle(LEAFLET_CSS);
            loadScript(LEAFLET_JS, () => {
                setTimeout(() => {
                    const mapEl = document.getElementById(mapId);
                    if (!mapEl) return;
                    const map = L.map(mapId).setView([lat, lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19, attribution: '© OpenStreetMap'
                    }).addTo(map);
                    L.marker([lat, lng]).addTo(map).bindPopup('Lokasi Pendaftar').openPopup();
                    window['map_init_' + mapId] = true;
                }, 200);
            });
        }
    };

    // ═══════════════════════════════════════════
    // Init on page load
    // ═══════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.admin-nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                switchTab(link.getAttribute('data-tab'));
            });
        });

        const hash = window.location.hash.substring(1);
        switchTab(VALID_TABS.includes(hash) ? hash : 'dashboard');

        if (typeof window.initPendaftaranPanel === 'function') {
            window.initPendaftaranPanel();
        }

        // --- UNIVERSAL AJAX HANDLER ---

        // 1. Intercept Pagination Links (SPA no-reload)
        document.addEventListener('click', async function(e) {
            const link = e.target.closest('nav[role="navigation"] a');
            if (link) {
                e.preventDefault();
                const panel = link.closest('.admin-tab-panel');
                if (panel) {
                    panel.style.opacity = '0.5';
                    try {
                        const response = await fetch(link.href);
                        const html = await response.text();
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const newPanel = doc.getElementById(panel.id);
                        if (newPanel) {
                            panel.innerHTML = newPanel.innerHTML;
                            history.pushState(null, '', link.href);
                            if (panel.id === 'panel-pendaftaran' && typeof window.initPendaftaranPanel === 'function') {
                                window.initPendaftaranPanel();
                            } else if (typeof STATUS_COLORS !== 'undefined') {
                                document.querySelectorAll('.status-select').forEach(el => {
                                    const val = el.value;
                                    Object.values(STATUS_COLORS).forEach(c => el.classList.remove(c));
                                    el.classList.add(STATUS_COLORS[val] || '');
                                    el.setAttribute('data-prev', val);
                                });
                            }
                        }
                    } catch (err) { console.error('Pagination Error:', err); }
                    finally { panel.style.opacity = '1'; }
                }
            }
        });

        // 2. Intercept Form Submissions (SPA no-reload)
        document.addEventListener('submit', async function(e) {
            if (e.target.closest('.admin-tab-panel') && !e.target.hasAttribute('data-no-ajax')) {
                if (e.target.getAttribute('method') && e.target.getAttribute('method').toLowerCase() === 'dialog') return;
                
                e.preventDefault();
                const form = e.target;
                const panel = form.closest('.admin-tab-panel');
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn ? submitBtn.innerHTML : '';

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="loading loading-spinner loading-xs"></span>';
                }
                try {
                    const formData = new FormData(form);
                    let url = form.action.split('#')[0];
                    if (form.method.toUpperCase() === 'GET') {
                        const params = new URLSearchParams(formData).toString();
                        if (params) {
                            url += (url.includes('?') ? '&' : '?') + params;
                        }
                    }
                    const response = await fetch(url, {
                        method: form.method.toUpperCase(),
                        body: form.method.toUpperCase() === 'GET' ? null : formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json, text/html' }
                    });

                    // ── JSON response: hanya tampilkan toast, panel tidak di-reload ──
                    const contentType = response.headers.get('Content-Type') || '';
                    if (contentType.includes('application/json')) {
                        const json = await response.json();
                        if (response.ok && json.success) {
                            spaToast(json.message || 'Berhasil disimpan.', 'success');
                            // Reset password form jika ada
                            if (form.id === 'passwordForm') form.reset();
                        } else {
                            const errMsg = json.message || (json.errors ? Object.values(json.errors).flat().join(' ') : 'Terjadi kesalahan.');
                            spaToast(errMsg, 'error');
                            // Tampilkan inline error jika ada
                            if (json.errors) {
                                Object.entries(json.errors).forEach(([field, msgs]) => {
                                    const input = form.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('input-error', 'textarea-error');
                                        let errEl = input.parentNode.querySelector('.spa-field-error');
                                        if (!errEl) { errEl = document.createElement('span'); errEl.className = 'text-error text-xs mt-1 spa-field-error'; input.parentNode.appendChild(errEl); }
                                        errEl.textContent = msgs[0];
                                        input.addEventListener('input', () => { input.classList.remove('input-error', 'textarea-error'); errEl.remove(); }, { once: true });
                                    }
                                });
                            }
                        }
                        return; // jangan replace panel
                    }

                    // ── HTML response: replace panel (untuk tab CRUD) ──
                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const newPanel = doc.getElementById(panel.id);
                    if (newPanel) {
                        panel.innerHTML = newPanel.innerHTML;
                        history.pushState(null, '', url);
                        if (panel.id === 'panel-pendaftaran' && typeof window.initPendaftaranPanel === 'function') {
                            window.initPendaftaranPanel();
                        }
                        if (typeof showToast === 'function') showToast('Aksi berhasil dilakukan', 'success');
                        document.querySelectorAll('dialog.modal').forEach(m => m.close());
                    }
                } catch (err) {
                    console.error('AJAX Form Error:', err);
                    if (typeof showToast === 'function') showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                } finally {
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
                }
            }
        });
    });

    // Handle browser back/forward
    window.addEventListener('hashchange', () => {
        const hash = window.location.hash.substring(1);
        switchTab(VALID_TABS.includes(hash) ? hash : 'dashboard');
    });

    // ═══════════════════════════════════════════
    // Chart.js Initialization (dipanggil setelah lazy-load)
    // ═══════════════════════════════════════════
    window.initDashboardChart = function() {
        const canvas = document.getElementById('regChart');
        if (!canvas || typeof Chart === 'undefined') return;
        if (window.regChartInstance) window.regChartInstance.destroy();

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

    // ═══════════════════════════════════════════
    // Pendaftaran Tab Functions (SPA Global Scope)
    // ═══════════════════════════════════════════
    window.STATUS_COLORS = {
        pending:   'text-warning',
        validated: 'text-info',
        rejected:  'text-error',
        setup:     'text-accent',
        active:    'text-success'
    };

    window.resetPendaftaranFilters = async function(event) {
        if (event) event.preventDefault();
        
        // Use the href attribute of the clicked element for dynamic routing (works in subdirectories)
        const targetUrl = event.currentTarget.getAttribute('href') || '/admin#pendaftaran';
        const cleanUrl = targetUrl.split('#')[0];
        
        const panel = document.getElementById('panel-pendaftaran');
        if (panel) {
            panel.style.opacity = '0.5';
            try {
                const response = await fetch(cleanUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!response.ok) throw new Error('Fetch failed: ' + response.status);
                
                const html = await response.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newPanel = doc.getElementById('panel-pendaftaran');
                if (newPanel) {
                    panel.innerHTML = newPanel.innerHTML;
                    history.pushState(null, '', targetUrl);
                    window.initPendaftaranPanel();
                }
            } catch (err) {
                console.error('Reset Error:', err);
                // Fallback to standard link click navigation
                window.location.href = targetUrl;
            } finally {
                panel.style.opacity = '1';
            }
        }
    };

    window.toggleFilterPanel = function() {
        const panel = document.getElementById('filter-panel');
        if (panel) {
            panel.classList.toggle('hidden');
        }
    };

    window.toggleAllExportColumns = function(select) {
        const checkboxes = document.querySelectorAll('#export-columns-list input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = select);
    };

    window.moveExportColumn = function(btn, direction) {
        const li = btn.closest('li');
        const list = document.getElementById('export-columns-list');
        if (direction === 'up') {
            const prev = li.previousElementSibling;
            if (prev) {
                list.insertBefore(li, prev);
            }
        } else if (direction === 'down') {
            const next = li.nextElementSibling;
            if (next) {
                list.insertBefore(li, next.nextElementSibling);
            }
        }
    };

    window.updateStatus = async function(el) {
        const id = el.dataset.id;
        const newStatus = el.value;
        const prevValue = el.getAttribute('data-prev') || el.querySelector('option[selected]')?.value;
        const url = el.dataset.url || `/admin/pendaftaran/${id}/status`;

        el.disabled = true;
        el.classList.add('opacity-50');

        try {
            const res = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            });

            if (!res.ok) throw new Error('Request gagal');

            Object.values(window.STATUS_COLORS).forEach(c => el.classList.remove(c));
            el.classList.add(window.STATUS_COLORS[newStatus] || '');
            el.setAttribute('data-prev', newStatus);

            const BADGE_MAP = {
                pending: 'bg-warning/10 text-warning border-warning/20',
                validated: 'bg-info/10 text-info border-info/20',
                rejected: 'bg-error/10 text-error border-error/20',
                setup: 'bg-accent/10 text-accent border-accent/20',
                active: 'bg-success/10 text-success border-success/20'
            };
            const badge = document.getElementById('detail_status_' + id);
            if (badge) {
                badge.className = 'px-2 py-1 font-bold rounded-md border text-xs ' + (BADGE_MAP[newStatus] || 'bg-base-200 text-base-content/70 border-base-300');
                badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            }

            spaToast(`Status berhasil diubah ke "${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}"`, 'success');
        } catch (err) {
            if (prevValue) el.value = prevValue;
            spaToast('Gagal mengubah status. Coba lagi.', 'error');
        } finally {
            el.disabled = false;
            el.classList.remove('opacity-50');
        }
    };

    window.initExportDragAndDrop = function() {
        const list = document.getElementById('export-columns-list');
        if (!list) return;

        let dragEl = null;

        list.addEventListener('dragstart', (e) => {
            const li = e.target.closest('li');
            if (!li) return;
            dragEl = li;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', '');
            setTimeout(() => {
                li.classList.add('opacity-40', 'border-primary', 'border-dashed');
            }, 0);
        });

        list.addEventListener('dragover', (e) => {
            e.preventDefault();
            if (!dragEl) return;
            const targetLi = e.target.closest('li');
            if (targetLi && targetLi !== dragEl && targetLi.parentNode === list) {
                const rect = targetLi.getBoundingClientRect();
                const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;
                list.insertBefore(dragEl, next ? targetLi.nextSibling : targetLi);
            }
        });

        list.addEventListener('dragend', (e) => {
            if (!dragEl) return;
            dragEl.classList.remove('opacity-40', 'border-primary', 'border-dashed');
            dragEl = null;
        });
    };

    window.initPendaftaranPanel = function() {
        document.querySelectorAll('.status-select').forEach(el => {
            const val = el.value;
            Object.values(window.STATUS_COLORS).forEach(c => el.classList.remove(c));
            el.classList.add(window.STATUS_COLORS[val] || '');
            el.setAttribute('data-prev', val);
        });
        window.initExportDragAndDrop();
    };

    window.sharePendaftaran = function(nama, alamat, lat, lng, imageUrl) {
        let text = `Data Pemasangan Teknisi R-NET:\n` +
                   `Nama Pelanggan: ${nama}\n` +
                   `Alamat: ${alamat}\n` +
                   `Koordinat: ${lat}, ${lng}\n` +
                   `Lihat di Peta: https://maps.google.com/?q=${lat},${lng}`;
        
        if (imageUrl) {
            text += `\nFoto Rumah: ${imageUrl}`;
        }
        
        if (navigator.share) {
            navigator.share({
                title: 'Data Pemasangan R-NET',
                text: text
            }).catch(err => {
                console.error('Error sharing:', err);
            });
        } else {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    if (typeof spaToast === 'function') {
                        spaToast('Data disalin ke papan klip! Silakan bagikan ke teknisi.', 'success');
                    } else {
                        alert('Data disalin ke papan klip! Silakan bagikan ke teknisi.');
                    }
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                    alert(text);
                });
            } else {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    if (typeof spaToast === 'function') {
                        spaToast('Data disalin ke papan klip! Silakan bagikan ke teknisi.', 'success');
                    } else {
                        alert('Data disalin ke papan klip! Silakan bagikan ke teknisi.');
                    }
                } catch (err) {
                    console.error('Copy failed: ', err);
                    alert(text);
                }
                document.body.removeChild(textArea);
            }
        }
    };
</script>
@endsection

