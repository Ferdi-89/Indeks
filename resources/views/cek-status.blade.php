<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Instalasi - R-NET</title>
    <meta name="description"
        content="Cek status pemasangan dan aktivasi layanan internet R-NET Anda secara real-time.">

    <script>
        (function() {
            var t = localStorage.getItem('rnet-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
    if (!function_exists('invertColorPHP')) {
        function invertColorPHP($hex, $isDark = true) {
            $hex = str_replace('#', '', $hex);
            if (strlen($hex) == 3) {
                $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
            }
            if (strlen($hex) != 6) return '#' . $hex;

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            // RGB to HSL
            $r_norm = $r / 255;
            $g_norm = $g / 255;
            $b_norm = $b / 255;
            $max = max($r_norm, $g_norm, $b_norm);
            $min = min($r_norm, $g_norm, $b_norm);
            $l = ($max + $min) / 2;
            if ($max == $min) {
                $h = $s = 0;
            } else {
                $d = $max - $min;
                $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
                switch ($max) {
                    case $r_norm: $h = ($g_norm - $b_norm) / $d + ($g_norm < $b_norm ? 6 : 0); break;
                    case $g_norm: $h = ($b_norm - $r_norm) / $d + 2; break;
                    case $b_norm: $h = ($r_norm - $g_norm) / $d + 4; break;
                }
                $h /= 6;
            }
            $h *= 360;
            $s *= 100;
            $l *= 100;

            // Adjust HSL based on mode
            if ($isDark) {
                // Sisi Dark Mode: Jangan di-invers! Cukup pastikan warnanya kontras (tidak terlalu gelap).
                // Jika lightness < 55%, naikkan ke 60% agar terlihat terang di latar gelap.
                if ($l < 55) {
                    $l = 60;
                }
                // Tingkatkan sedikit saturasi untuk mode gelap agar lebih "vibrant"
                $s = min(100, $s * 1.15);
            } else {
                // Sisi Light Mode: Cukup pastikan warnanya kontras (tidak terlalu terang/menyilaukan).
                // Jika lightness > 65%, turunkan ke 55% agar terbaca di latar putih.
                if ($l > 65) {
                    $l = 55;
                }
            }

            // HSL to RGB
            $h_norm = $h / 360;
            $s_norm = $s / 100;
            $l_norm = $l / 100;
            
            $r_res = $l_norm;
            $g_res = $l_norm;
            $b_res = $l_norm;
            
            $v = ($l_norm <= 0.5) ? ($l_norm * (1.0 + $s_norm)) : ($l_norm + $s_norm - $l_norm * $s_norm);
            if ($v > 0) {
                $m = $l_norm + $l_norm - $v;
                $sv = ($v - $m) / $v;
                $h_norm *= 6.0;
                $sextant = floor($h_norm);
                $fract = $h_norm - $sextant;
                $vsf = $v * $sv * $fract;
                $mid1 = $m + $vsf;
                $mid2 = $v - $vsf;
                switch ($sextant) {
                    case 0: $r_res = $v; $g_res = $mid1; $b_res = $m; break;
                    case 1: $r_res = $mid2; $g_res = $v; $b_res = $m; break;
                    case 2: $r_res = $m; $g_res = $v; $b_res = $mid1; break;
                    case 3: $r_res = $m; $g_res = $mid2; $b_res = $v; break;
                    case 4: $r_res = $mid1; $g_res = $m; $b_res = $v; break;
                    case 5: $r_res = $v; $g_res = $m; $b_res = $mid2; break;
                }
            }

            $r_hex = str_pad(dechex(max(0, min(255, round($r_res * 255)))), 2, '0', STR_PAD_LEFT);
            $g_hex = str_pad(dechex(max(0, min(255, round($g_res * 255)))), 2, '0', STR_PAD_LEFT);
            $b_hex = str_pad(dechex(max(0, min(255, round($b_res * 255)))), 2, '0', STR_PAD_LEFT);

            return '#' . $r_hex . $g_hex . $b_hex;
        }
    }
    @endphp

    <!-- Dynamic Theme Customization -->
    <style>
        /* Light Mode (Default) */
        :root, [data-theme="light"] {
            @if(isset($company) && $company->primary_color)
                --color-primary: {{ invertColorPHP($company->primary_color, false) }} !important;
                --color-primary-content: #ffffff !important;
                --color-primary-hover: {{ invertColorPHP($company->primary_color, false) }}ee !important;
            @endif
            @if(isset($company) && $company->secondary_color)
                --color-secondary: {{ invertColorPHP($company->secondary_color, false) }} !important;
                --color-secondary-content: #ffffff !important;
            @endif
            @if(isset($company) && $company->accent_color)
                --color-accent: {{ invertColorPHP($company->accent_color, false) }} !important;
                --color-accent-content: #ffffff !important;
            @endif
        }

        /* Dark Mode (Dynamic Contrast Correction) */
        [data-theme="dark"] {
            @if(isset($company) && $company->primary_color)
                --color-primary: {{ invertColorPHP($company->primary_color, true) }} !important;
                --color-primary-content: #ffffff !important;
                --color-primary-hover: {{ invertColorPHP($company->primary_color, true) }}ee !important;
            @endif
            @if(isset($company) && $company->secondary_color)
                --color-secondary: {{ invertColorPHP($company->secondary_color, true) }} !important;
                --color-secondary-content: #ffffff !important;
            @endif
            @if(isset($company) && $company->accent_color)
                --color-accent: {{ invertColorPHP($company->accent_color, true) }} !important;
                --color-accent-content: #ffffff !important;
            @endif
        }
    </style>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-tr from-base-200 to-base-100 font-sans pb-20 antialiased relative">

    {{-- Premium Navbar Area --}}
    <header class="sticky top-0 z-50 w-full bg-base-100/80 backdrop-blur-md border-b border-base-300/15">
        <nav class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Left Side: Brand Logo & Title -->
            <div class="flex items-center gap-6">
                <a href="/" class="flex items-center gap-2 shrink-0">
                    @if(isset($company) && $company->logo_path)
                        <img src="{{ $company->logo_path }}" alt="{{ $company->nama_perusahaan }}" class="h-7 w-auto object-contain">
                    @else
                        <img src="/logoprimary.svg" alt="R-NET Logo" class="h-7 w-auto">
                    @endif
                </a>
                <span class="text-xs font-semibold text-base-content/40 uppercase tracking-widest hidden sm:inline-block">| Pelacakan Pemasangan</span>
            </div>

            <!-- Right Side: Theme Toggle, Home & Register -->
            <div class="flex items-center gap-4">
                {{-- Theme Switcher --}}
                <label id="theme-toggle" class="btn btn-ghost btn-circle btn-sm swap swap-rotate" title="Ganti tema">
                    <input type="checkbox" id="theme-checkbox" class="hidden" />
                    <i data-lucide="sun" class="swap-on w-4 h-4 text-amber-500"></i>
                    <i data-lucide="moon" class="swap-off w-4 h-4 text-primary"></i>
                </label>

                <a href="/" class="btn btn-ghost btn-sm rounded-xl gap-2 font-bold text-base-content/75 hover:bg-base-200">
                    <i data-lucide="home" class="w-4 h-4"></i> Beranda
                </a>
                <a href="/daftar" class="btn btn-primary btn-sm rounded-xl gap-2 font-bold px-4">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Daftar Baru
                </a>
            </div>
        </nav>
    </header>

    <main class="max-w-4xl mx-auto px-4 md:px-8 pt-12 space-y-10">
        <div class="text-center max-w-xl mx-auto">
            <div
                class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                <i data-lucide="search" class="w-3.5 h-3.5"></i> Pelacakan Pemasangan
            </div>
            <h2 class="text-3xl font-extrabold mt-3">Cek Status Instalasi</h2>
            <p class="text-sm text-base-content/60 mt-2">Masukkan 5-karakter ID Pendaftaran Anda untuk memantau proses instalasi WiFi R-NET secara real-time.</p>
        </div>

        <div class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/30 shadow-lg space-y-6 bg-base-100/50 backdrop-blur-md">
            <!-- Search Form -->
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-base-content/40">
                        <i data-lucide="key" class="w-4 h-4"></i>
                    </span>
                    <input type="text" id="input-id-pendaftaran" placeholder="Masukkan ID Pendaftaran (misal: ABCDE)" 
                        maxlength="5" 
                        class="w-full input input-bordered pl-11 pr-4 py-3 bg-base-200/50 focus:bg-base-100 border-base-300/80 rounded-2xl text-sm font-semibold tracking-widest uppercase placeholder:tracking-normal placeholder:font-normal"
                        oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" />
                </div>
                <button type="button" id="btn-cek-status" onclick="fetchStatusInstalasi()" 
                    class="btn btn-primary rounded-2xl font-bold px-6 flex items-center gap-2 active:scale-95 transition-all">
                    <i data-lucide="search" class="w-4 h-4"></i> Cari Status
                </button>
            </div>

            <!-- Status Detail Container -->
            <div id="status-result-container" class="hidden animate-fade-in space-y-6">
                <div class="divider my-2"></div>
                
                <!-- Customer Details Info Card -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-base-200/40 border border-base-300/30 p-5 rounded-2xl">
                    <div>
                        <span class="text-[10px] text-base-content/40 uppercase font-bold tracking-widest block mb-0.5">Nama Pelanggan</span>
                        <span id="result-nama" class="font-bold text-base-content text-sm">-</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-base-content/40 uppercase font-bold tracking-widest block mb-0.5">ID Pendaftaran</span>
                        <span id="result-id" class="font-mono font-extrabold text-primary text-sm">-</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-base-content/40 uppercase font-bold tracking-widest block mb-0.5">Paket Layanan</span>
                        <span id="result-paket" class="font-bold text-base-content text-sm">-</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-base-content/40 uppercase font-bold tracking-widest block mb-0.5">Tanggal Registrasi</span>
                        <span id="result-tanggal" class="font-bold text-base-content text-sm">-</span>
                    </div>
                </div>

                <!-- Rejected Alert (Hidden by default) -->
                <div id="status-rejected-alert" class="hidden bg-error/15 text-error-content border border-error/20 p-5 rounded-2xl space-y-3">
                    <div class="flex items-start gap-3">
                        <i data-lucide="x-circle" class="w-6 h-6 shrink-0 text-error"></i>
                        <div>
                            <h4 class="font-bold text-sm">Pendaftaran Ditangguhkan / Ditolak</h4>
                            <p class="text-xs text-base-content/75 mt-1 leading-relaxed">
                                Maaf, pendaftaran Anda saat ini tidak dapat disetujui. Hal ini biasanya dikarenakan lokasi rumah di luar batas penarikan kabel atau kendala administratif lainnya.
                            </p>
                        </div>
                    </div>
                    <a href="https://wa.me/{{ isset($company) && $company->whatsapp ? preg_replace('/[^0-9]/', '', $company->whatsapp) : '6281373242673' }}?text=Halo%20Admin%20{{ isset($company) ? urlencode($company->nama_perusahaan) : 'R-NET' }},%20saya%20ingin%20bertanya%20mengenai%20status%20pendaftaran%20saya%20dengan%20ID%20" 
                        id="btn-wa-rejected" target="_blank" class="btn btn-error btn-sm w-full text-white font-bold rounded-xl flex items-center gap-1.5 justify-center">
                        <i data-lucide="message-circle" class="w-4 h-4"></i> Hubungi Customer Service
                    </a>
                </div>

                <!-- Stepper Progress Tracker (Hidden for rejected) -->
                <div id="status-stepper-container" class="space-y-6">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-primary/95 flex items-center gap-1.5">
                        <i data-lucide="activity" class="w-4 h-4"></i> Timeline Instalasi
                    </h4>
                    
                    <!-- Visual Steps -->
                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-8 md:gap-4 md:px-4">
                        <!-- Horizontal Progress bar (desktop) -->
                        <div class="absolute top-5 left-10 right-10 h-0.5 bg-base-300 hidden md:block -z-10">
                            <div id="stepper-progress-bar" class="h-full bg-primary transition-all duration-500 w-0"></div>
                        </div>

                        <!-- Step 1 -->
                        <div class="step-item flex md:flex-col items-center gap-4 md:gap-2 text-left md:text-center md:flex-1 relative">
                            <div id="step-node-1" class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-base-100 transition-all duration-300">1</div>
                            <div>
                                <h5 class="text-xs font-bold text-base-content">Pendaftaran</h5>
                                <p class="text-[10px] text-base-content/50 leading-relaxed md:max-w-[120px] mx-auto mt-0.5">Registrasi diterima admin.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step-item flex md:flex-col items-center gap-4 md:gap-2 text-left md:text-center md:flex-1 relative">
                            <div id="step-node-2" class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-base-100 transition-all duration-300">2</div>
                            <div>
                                <h5 class="text-xs font-bold text-base-content">Verifikasi</h5>
                                <p class="text-[10px] text-base-content/50 leading-relaxed md:max-w-[120px] mx-auto mt-0.5">Validasi berkas &amp; lokasi.</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="step-item flex md:flex-col items-center gap-4 md:gap-2 text-left md:text-center md:flex-1 relative">
                            <div id="step-node-3" class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-base-100 transition-all duration-300">3</div>
                            <div>
                                <h5 class="text-xs font-bold text-base-content">Instalasi</h5>
                                <p class="text-[10px] text-base-content/50 leading-relaxed md:max-w-[120px] mx-auto mt-0.5">Penarikan kabel &amp; modem.</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="step-item flex md:flex-col items-center gap-4 md:gap-2 text-left md:text-center md:flex-1 relative">
                            <div id="step-node-4" class="w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-base-100 transition-all duration-300">4</div>
                            <div>
                                <h5 class="text-xs font-bold text-base-content">Aktif</h5>
                                <p class="text-[10px] text-base-content/50 leading-relaxed md:max-w-[120px] mx-auto mt-0.5">Layanan siap digunakan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Indicator -->
            <div id="status-error-msg" class="hidden alert alert-warning rounded-2xl flex items-center gap-2 text-xs font-semibold">
                <i data-lucide="alert-circle" class="w-4 h-4 text-warning"></i>
                <span></span>
            </div>
        </div>
    </main>

    {{-- ==================== JAVASCRIPT ==================== --}}
    <script>
        // ── Theme Toggle ──────────────────────────────────────────
        const html = document.documentElement;
        const checkbox = document.getElementById('theme-checkbox');
        const THEME_KEY = 'rnet-theme';

        const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
        html.setAttribute('data-theme', savedTheme);
        checkbox.checked = savedTheme === 'dark';

        checkbox.addEventListener('change', () => {
            const t = checkbox.checked ? 'dark' : 'light';
            html.setAttribute('data-theme', t);
            localStorage.setItem(THEME_KEY, t);
        });

        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();

            // Check if there is an ?id=xxxxx parameter in the URL on load
            const urlParams = new URLSearchParams(window.location.search);
            const idParam = urlParams.get('id');
            if (idParam && idParam.length === 5) {
                document.getElementById('input-id-pendaftaran').value = idParam.toUpperCase();
                fetchStatusInstalasi();
            }
        });

        // ── Pelacakan Status Instalasi (AJAX) ───────────────────
        function fetchStatusInstalasi() {
            const inputId = document.getElementById('input-id-pendaftaran');
            const resultContainer = document.getElementById('status-result-container');
            const errorMsg = document.getElementById('status-error-msg');
            const btnCek = document.getElementById('btn-cek-status');
            
            const idVal = inputId.value.trim().toUpperCase();
            
            if (idVal.length !== 5) {
                showStatusError('ID Pendaftaran harus terdiri dari 5 karakter.');
                return;
            }

            // Update URL to match current search without reloading
            const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?id=' + idVal;
            window.history.pushState({ path: newUrl }, '', newUrl);

            // Show loading state
            btnCek.disabled = true;
            btnCek.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Mencari...`;
            errorMsg.classList.add('hidden');
            resultContainer.classList.add('hidden');

            fetch(`/cek-status/${idVal}`)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.message || 'Gagal mengambil data.') });
                    }
                    return response.json();
                })
                .then(res => {
                    if (res.success && res.data) {
                        renderStatusData(res.data);
                    } else {
                        throw new Error('Terjadi kesalahan pada format data.');
                    }
                })
                .catch(err => {
                    showStatusError(err.message || 'Koneksi bermasalah. Silakan coba lagi.');
                })
                .finally(() => {
                    btnCek.disabled = false;
                    btnCek.innerHTML = `<i data-lucide="search" class="w-4 h-4"></i> Cari Status`;
                    lucide.createIcons();
                });
        }

        function showStatusError(msg) {
            const errorMsg = document.getElementById('status-error-msg');
            const resultContainer = document.getElementById('status-result-container');
            errorMsg.querySelector('span').textContent = msg;
            errorMsg.classList.remove('hidden');
            resultContainer.classList.add('hidden');
        }

        function renderStatusData(data) {
            const resultContainer = document.getElementById('status-result-container');
            const rejectedAlert = document.getElementById('status-rejected-alert');
            const stepperContainer = document.getElementById('status-stepper-container');
            
            // Populate text info
            document.getElementById('result-nama').textContent = data.nama;
            document.getElementById('result-id').textContent = data.id_pendaftaran;
            document.getElementById('result-paket').textContent = data.paket;
            document.getElementById('result-tanggal').textContent = data.tanggal_daftar;
            
            const waBtn = document.getElementById('btn-wa-rejected');
            if (waBtn) {
                const waNumber = '{{ isset($company) && $company->whatsapp ? preg_replace('/[^0-9]/', '', $company->whatsapp) : "6281373242673" }}';
                const companyName = '{{ isset($company) ? addslashes($company->nama_perusahaan) : "R-NET" }}';
                waBtn.href = `https://wa.me/${waNumber}?text=Halo%20Admin%20${encodeURIComponent(companyName)},%20saya%20ingin%20bertanya%20mengenai%20status%20pendaftaran%20saya%20dengan%20ID%20${data.id_pendaftaran}`;
            }

            const status = data.status.toLowerCase();
            
            if (status === 'rejected') {
                rejectedAlert.classList.remove('hidden');
                stepperContainer.classList.add('hidden');
            } else {
                rejectedAlert.classList.add('hidden');
                stepperContainer.classList.remove('hidden');
                
                // Reset nodes
                for (let i = 1; i <= 4; i++) {
                    const node = document.getElementById(`step-node-${i}`);
                    node.className = "w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-base-100 text-base-content/50 border-base-300 transition-all duration-300";
                    node.innerHTML = i;
                }
                
                const progressBar = document.getElementById('stepper-progress-bar');
                
                // Map status to progress bar width and step styles
                if (status === 'pending') {
                    setNodeState(1, 'active');
                    progressBar.style.width = '0%';
                } else if (status === 'validated') {
                    setNodeState(1, 'done');
                    setNodeState(2, 'active');
                    progressBar.style.width = '33.33%';
                } else if (status === 'setup') {
                    setNodeState(1, 'done');
                    setNodeState(2, 'done');
                    setNodeState(3, 'active');
                    progressBar.style.width = '66.66%';
                } else if (status === 'active' || status === 'aktif') {
                    setNodeState(1, 'done');
                    setNodeState(2, 'done');
                    setNodeState(3, 'done');
                    setNodeState(4, 'done');
                    progressBar.style.width = '100%';
                }
            }
            
            resultContainer.classList.remove('hidden');
        }

        function setNodeState(step, state) {
            const node = document.getElementById(`step-node-${step}`);
            if (!node) return;
            
            if (state === 'done') {
                node.className = "w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-primary text-primary-content border-primary shadow transition-all duration-300";
                node.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>`;
            } else if (state === 'active') {
                node.className = "w-10 h-10 rounded-full flex items-center justify-center border-2 font-bold text-xs bg-primary/10 text-primary border-primary animate-pulse shadow-md transition-all duration-300";
                node.innerHTML = step;
            }
        }
    </script>
</body>

</html>
