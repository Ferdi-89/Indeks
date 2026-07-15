<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar R-NET - Internet Rakyat</title>
    <meta name="description"
        content="Daftarkan layanan internet R-NET di lokasi Anda. Internet berkecepatan tinggi untuk rumah Anda.">

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
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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

        /* Cache-proof fix for GPU rendering tearing/ghosting on mobile/tablet screens */
        @media (max-width: 1023px) {
            .glass-card,
            .glass-panel,
            [class*="backdrop-blur-"] {
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
                transition: none !important;
                overflow: hidden !important;
            }
            .glass-card:hover,
            .glass-panel:hover {
                transform: none !important;
            }
            [data-theme="light"] .glass-card {
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
            [data-theme="dark"] .glass-card {
                background-color: rgba(20, 26, 45, 0.96) !important;
            }
            .glass-panel {
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
            [data-theme="dark"] .glass-panel {
                background-color: rgba(15, 23, 42, 0.96) !important;
            }
        }
    </style>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-tr from-base-200 to-base-100 font-sans pb-20 antialiased relative">

    {{-- Error Banner --}}
    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 md:px-8 pt-4">
            <div class="alert alert-error bg-error/10 border border-error/30 text-error-content rounded-2xl shadow-sm">
                <div class="flex items-start gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-error"></i>
                    <div>
                        <span class="font-bold text-sm block mb-1">Periksa kembali data Anda:</span>
                        <ul class="list-disc pl-5 text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Konfirmasi Pendaftaran Berhasil --}}
    @if (session('sukses') || session('success'))
        <div id="success-overlay"
            class="fixed inset-0 z-[9999] overflow-y-auto bg-black/50 backdrop-blur-sm animate-fade-in">

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-base-100 rounded-3xl shadow-2xl p-8 md:p-10 max-w-md w-full text-center relative border border-base-300/40"
                    style="animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;">

                    {{-- Checkmark Circle --}}
                    <div class="mx-auto w-20 h-20 bg-success/15 rounded-full flex items-center justify-center mb-6"
                        style="animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;">
                        <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-base-content mb-2">Pendaftaran Berhasil!</h2>
                    <p class="text-base-content/70 text-sm leading-relaxed mb-2">
                        Terima kasih telah mendaftar layanan <span class="font-semibold text-primary">R-NET</span>.
                    </p>
                    <p class="text-base-content/70 text-sm leading-relaxed mb-8">
                        Tim teknisi kami akan segera menghubungi Anda untuk proses instalasi.
                        Mohon pastikan nomor telepon Anda aktif.
                    </p>

                    <div class="flex flex-col gap-3">
                        <a href="/"
                            class="w-full btn btn-primary font-bold py-3 px-6 rounded-xl shadow transition text-sm text-center">
                            Kembali ke Beranda
                        </a>
                        <button onclick="document.getElementById('success-overlay').remove()"
                            class="w-full btn btn-ghost text-base-content/60 font-semibold py-2.5 px-6 rounded-xl hover:bg-base-300/30 transition text-sm">
                            Daftar Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.85) translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }

            @keyframes popIn {
                from {
                    opacity: 0;
                    transform: scale(0);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        </style>
    @endif

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
                <span class="text-xs font-semibold text-base-content/40 uppercase tracking-widest hidden sm:inline-block">| Portal Pendaftaran</span>
            </div>

            <!-- Right Side: Theme Toggle & Back Button -->
            <div class="flex items-center gap-4">
                {{-- Theme Switcher --}}
                <label id="theme-toggle" class="btn btn-ghost btn-circle btn-sm swap swap-rotate" title="Ganti tema">
                    <input type="checkbox" id="theme-checkbox" class="hidden" />
                    <i data-lucide="sun" class="swap-on w-4 h-4 text-amber-500"></i>
                    <i data-lucide="moon" class="swap-off w-4 h-4 text-primary"></i>
                </label>

                <a href="/cek-status" class="btn btn-ghost btn-sm rounded-xl gap-2 font-bold text-base-content/75 hover:bg-base-200">
                    <i data-lucide="search" class="w-4 h-4"></i> Cek Status
                </a>
                <a href="/" class="btn btn-ghost btn-sm rounded-xl gap-2 font-bold text-base-content/75 hover:bg-base-200">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Beranda
                </a>
            </div>
        </nav>
    </header>

    {{-- Progress Steps bar (Clickable Navigators) --}}
    <div class="max-w-xl mx-auto mt-8 mb-4 px-6">
        <ul class="steps steps-horizontal w-full text-xs font-bold">
            <li id="step-indicator-1" onclick="goToStep(1)" class="step step-primary cursor-pointer hover:text-primary transition-colors">Data &amp; Paket</li>
            <li id="step-indicator-2" onclick="goToStep(2)" class="step cursor-pointer hover:text-primary transition-colors">Lokasi Rumah</li>
            <li id="step-indicator-3" onclick="goToStep(3)" class="step cursor-pointer hover:text-primary transition-colors">Foto Verifikasi</li>
        </ul>
    </div>

    <main class="max-w-7xl mx-auto px-4 md:px-8 pt-4 grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">

        <!-- Left Column: Guide & Instruction (Dynamic Panel) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="glass-card p-6 md:p-8 rounded-3xl shadow-lg border border-base-300/40 space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-base-content tracking-tight leading-tight">
                        Langkah Pendaftaran
                    </h2>
                    <p class="text-xs font-medium text-primary mt-1 uppercase tracking-widest" id="guide-step-title">Langkah 1 dari 3</p>
                </div>

                <!-- Dynamic text prompt for the active step -->
                <div id="guide-box" class="bg-base-200/50 border border-base-300/50 p-5 rounded-2xl">
                    <p id="guide-text" class="text-sm text-base-content/75 leading-relaxed">
                        Silakan masukkan nama lengkap Anda dan nomor telepon WhatsApp aktif yang dapat dihubungi. Setelah itu, pilih salah satu paket layanan internet yang Anda inginkan.
                    </p>
                </div>

                <!-- Map picking helper (shows only on Step 2) -->
                <div id="map-helper-box" class="hidden border border-base-300/60 p-5 rounded-2xl bg-base-100 shadow-inner">
                    <p class="font-bold text-xs mb-2 text-base-content flex items-center gap-1.5">
                        <i data-lucide="info" class="w-4 h-4 text-primary"></i> Panduan Pemetaan:
                    </p>
                    <ul class="list-disc pl-5 text-xs text-base-content/75 space-y-2 leading-relaxed">
                        <li>Gunakan tombol GPS <span class="badge badge-sm bg-base-200"><i data-lucide="navigation" class="w-3 h-3 text-slate-700"></i></span> untuk mendeteksi lokasi Anda saat ini.</li>
                        <li>Geser peta hingga ikon pin merah tepat berada di atap rumah Anda.</li>
                        <li>Klik <b>Konfirmasi Alamat</b> untuk mengunci koordinat lokasi.</li>
                    </ul>
                </div>

                <!-- Support Footer Info -->
                <div class="pt-4 border-t border-base-300/40 flex items-center gap-3 text-xs text-base-content/65 leading-relaxed">
                    <i data-lucide="lock" class="w-5 h-5 text-success shrink-0"></i>
                    <span>Data pendaftaran Anda aman dan hanya digunakan untuk kepentingan instalasi internet.</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Overhauled Multi-Step Form -->
        <div class="lg:col-span-8 space-y-6 mb-12">
            <div class="glass-card p-6 md:p-10 rounded-3xl shadow-xl border border-base-300/50">
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- hidden coordinates values -->
                    <input type="hidden" name="latitude" id="lat" value="{{ old('latitude', -2.0337714) }}">
                    <input type="hidden" name="longtitude" id="long" value="{{ old('longtitude', 101.3963373) }}">

                    <!-- ==================== STEP 1: INFORMASI DATA DIRI & PAKET ==================== -->
                    <div id="step-content-1" class="step-container active space-y-6 animate-fade-in">
                        <!-- Header -->
                        <div class="flex items-center gap-3 pb-3 border-b border-base-300/40">
                            <div class="bg-primary/10 text-primary p-2.5 rounded-xl">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-base-content">Informasi Personal</h3>
                                <p class="text-xs text-base-content/50">Masukkan nama lengkap dan nomor kontak Anda</p>
                            </div>
                        </div>

                        <!-- Inputs -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-base-content/75 flex items-center tracking-wide uppercase">
                                    Nama Lengkap <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda"
                                    value="{{ old('nama') }}" required
                                    class="w-full input input-bordered px-4 py-3 bg-base-200/50 focus:bg-base-100 border-base-300/80 premium-input rounded-xl text-sm">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-base-content/75 flex items-center tracking-wide uppercase">
                                    Nomor Telepon (WhatsApp) <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="flex w-full rounded-xl overflow-hidden border border-base-300/80 focus-within:ring-2 focus-within:ring-primary/25 bg-base-200/50">
                                    <span class="flex items-center justify-center px-4 border-r border-base-300/80 text-sm font-bold text-base-content/60 bg-base-300/30">
                                        +62
                                    </span>
                                    <input type="tel" name="nomor_tlpn" placeholder="8123456789"
                                        value="{{ old('nomor_tlpn') }}" required minlength="8"
                                        pattern="^(08|\+62|8)[0-9\s\-]{7,15}$" title="Format nomor HP harus diawali dengan 08, +62, atau langsung 8"
                                        class="w-full px-4 py-3 outline-none text-sm bg-transparent text-base-content focus:bg-base-100">
                                </div>
                            </div>
                        </div>

                        <!-- Section: Package selection -->
                        <div class="pt-6 space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-base-300/40">
                                <div class="bg-primary/10 text-primary p-2.5 rounded-xl">
                                    <i data-lucide="package" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-base-content">Pilih Paket Internet</h3>
                                    <p class="text-xs text-base-content/50">Pilih paket langganan bulanan Anda</p>
                                </div>
                            </div>

                            <input type="hidden" name="id_paket" id="selected-paket"
                                value="{{ old('id_paket', request('paket')) }}" required>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                @foreach ($pakets as $paket)
                                    @php
                                        if (!is_object($paket) || !($paket instanceof \App\Models\paket)) {
                                            continue;
                                        }
                                    @endphp
                                    <button type="button" data-paket-id="{{ $paket->id_paket }}"
                                        onclick="selectPaket(this)" class="paket-card group relative flex flex-col items-center text-center p-5 rounded-2xl border-2 transition-all duration-300 cursor-pointer w-full bg-base-200/40 border-base-300/60 hover:border-primary/50 hover:bg-base-100 {{ old('id_paket', request('paket')) == $paket->id_paket ? 'border-primary bg-primary/5 ring-1 ring-primary/25 font-bold' : '' }}">

                                        {{-- Check indicator inside badge --}}
                                        <div class="absolute top-3 right-3 w-5 h-5 rounded-full flex items-center justify-center transition-all duration-300 border-2 {{ old('id_paket', request('paket')) == $paket->id_paket ? 'bg-primary border-primary text-white scale-100' : 'border-base-300/80 scale-90' }}">
                                            <svg class="w-3 h-3 {{ old('id_paket', request('paket')) == $paket->id_paket ? '' : 'hidden' }}"
                                                fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>

                                        <p class="text-sm font-bold text-base-content mt-1">{{ $paket->title_paket }}</p>
                                        <p class="text-primary font-black text-xl leading-tight mt-2">
                                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                        </p>
                                        <p class="text-[10px] text-base-content/50 font-semibold uppercase tracking-wider">/bulan</p>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- ==================== STEP 2: TITIK LOKASI & ALAMAT ==================== -->
                    <div id="step-content-2" class="step-container space-y-6 animate-fade-in">
                        <!-- Header -->
                        <div class="flex items-center gap-3 pb-3 border-b border-base-300/40">
                            <div class="bg-primary/10 text-primary p-2.5 rounded-xl">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-base-content">Detail Lokasi &amp; Alamat</h3>
                                <p class="text-xs text-base-content/50">Tentukan lokasi rumah Anda di peta</p>
                            </div>
                        </div>

                        <!-- Peta / Map Picker Container -->
                        <div class="space-y-3">
                            <label class="text-xs font-bold text-base-content/75 flex items-center tracking-wide uppercase">
                                Tandai Titik Pemasangan di Peta <span class="text-red-500 ml-1">*</span>
                            </label>
                            
                            <div class="rounded-2xl overflow-hidden border border-base-300/80 shadow-md bg-base-100">
                                <div class="relative h-[22rem] w-full z-0 block">
                                    <div id="map" class="h-full w-full"></div>
                                    
                                    <!-- Fixed Center Pin overlay (Premium UI) -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-full z-[400] drop-shadow-lg pointer-events-none flex flex-col items-center">
                                        <div id="map-loading-indicator"
                                            class="hidden absolute -top-8 bg-black/80 text-white text-[10px] px-3 py-1 rounded-md font-bold whitespace-nowrap mb-1 shadow animate-pulse">
                                            Mencari alamat...
                                        </div>
                                        <div id="map-pin-icon" class="transition-transform duration-200 ease-in-out translate-y-0">
                                            <svg width="44" height="44" viewBox="0 0 24 24" fill="#ef4444"
                                                stroke="white" stroke-width="1.8" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3" fill="white"></circle>
                                            </svg>
                                        </div>
                                        <div id="map-pin-shadow"
                                            class="w-3 h-1 bg-black/40 rounded-full mt-1 blur-[1px] transition-opacity duration-200 opacity-100">
                                        </div>
                                    </div>

                                    <!-- GPS button -->
                                    <button id="btn-gps" title="Gunakan Lokasi Saat Ini (GPS)" type="button"
                                        class="absolute bottom-4 right-4 z-[400] btn btn-circle bg-base-100 border border-base-300 shadow-xl text-base-content hover:bg-base-200 transition active:scale-90">
                                        <i data-lucide="navigation" class="w-5 h-5 text-primary"></i>
                                    </button>
                                </div>

                                <!-- Map Address display card overlay -->
                                <div class="bg-base-200/50 p-4 border-t border-base-300/80 space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-red-500/15 p-2 rounded-xl text-red-500 shrink-0">
                                            <i data-lucide="map-pin" class="w-4.5 h-4.5"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[10px] font-bold text-base-content/50 uppercase tracking-widest mb-0.5">Alamat Peta</p>
                                            <p id="temp-address-display" class="text-xs font-semibold text-base-content/85 line-clamp-2 leading-relaxed">
                                                Geser peta untuk menentukan area pemasangan...
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Wilayah check status -->
                                    <div id="wilayah-validation-status" class="text-xs font-bold hidden rounded-xl p-3 border"></div>

                                    <button id="btn-confirm-address" type="button" disabled
                                        class="w-full btn btn-primary font-bold rounded-xl shadow">
                                        Konfirmasi Alamat
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Wilayah & Alamat Textarea -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-2">
                            <div class="md:col-span-1 space-y-1.5">
                                <label class="text-xs font-bold text-base-content/75 flex items-center tracking-wide uppercase">
                                    Wilayah Layanan <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="select-wilayah" name="wilayah" required
                                    class="w-full select select-bordered px-4 py-3 bg-base-200/50 focus:bg-base-100 border-base-300/80 premium-input rounded-xl text-sm">
                                    <option value="" disabled {{ old('wilayah') ? '' : 'selected' }}>Pilih Wilayah</option>
                                    @foreach($areaLayanan as $area)
                                        @php
                                            if (!is_object($area) || !($area instanceof \App\Models\AreaLayanan)) {
                                                continue;
                                            }
                                        @endphp
                                        <option value="{{ $area->nama_area }}" {{ old('wilayah') == $area->nama_area ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                                    @endforeach
                                    <option value="konsultasi" class="text-primary font-bold">💬 Hubungi Admin R-NET</option>
                                </select>
                            </div>

                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-xs font-bold text-base-content/75 flex items-center tracking-wide uppercase">
                                    Alamat Lengkap Rumah <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="alamat-input" name="alamat" rows="2" required
                                    class="w-full textarea textarea-bordered px-4 py-3 bg-base-200/50 focus:bg-base-100 border-base-300/80 premium-input rounded-xl text-sm resize-none"
                                    placeholder="Contoh: Jl. Diponegoro No. 45, RT 02/RW 03, Kelurahan Jati, Kode Pos 37111">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                    </div>

                    <!-- ==================== STEP 3: FOTO VERIFIKASI ==================== -->
                    <div id="step-content-3" class="step-container space-y-6 animate-fade-in">
                        <!-- Header -->
                        <div class="flex items-center gap-3 pb-3 border-b border-base-300/40">
                            <div class="bg-primary/10 text-primary p-2.5 rounded-xl">
                                <i data-lucide="camera" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-base-content">Foto Rumah &amp; Verifikasi</h3>
                                <p class="text-xs text-base-content/50">Upload foto rumah tampak depan</p>
                            </div>
                        </div>

                        <!-- File upload box styled as drag/drop card -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-base-content/75 flex items-center tracking-wide uppercase">
                                Upload Foto Depan Rumah <span class="text-red-500 ml-1">*</span>
                            </label>

                            <div class="relative border-2 border-dashed border-base-300/80 hover:border-primary/60 rounded-2xl transition-all duration-300 overflow-hidden bg-base-200/20">
                                <!-- Image Preview panel -->
                                <div id="preview-container" class="hidden items-center p-4 border-b border-base-300/60 bg-base-100">
                                    <img id="image-preview" src="#" alt="Preview"
                                        class="w-24 h-24 object-cover rounded-xl shadow border border-base-300/50">
                                    <div class="flex-1 ml-4">
                                        <p class="text-sm font-bold text-base-content">Foto berhasil dipilih</p>
                                        <p class="text-xs text-base-content/50 mt-1">Kami secara otomatis mengompres foto Anda agar lebih hemat kuota.</p>
                                    </div>
                                </div>

                                <label for="file-input" class="flex flex-col items-center justify-center p-8 cursor-pointer hover:bg-base-200/30 transition w-full">
                                    <div class="bg-primary/10 p-3.5 rounded-2xl mb-4 text-primary shadow-sm">
                                        <i data-lucide="upload-cloud" class="w-6 h-6 animate-pulse"></i>
                                    </div>
                                    <p class="text-sm font-bold text-base-content mb-1" id="upload-label">
                                        Pilih foto rumah dari galeri
                                    </p>
                                    <p class="text-xs text-base-content/40 font-semibold uppercase tracking-wider">PNG, JPG (Maksimal 1 MB)</p>
                                </label>

                                <input type="file" id="file-input" name="path_gambar" accept=".png,.jpg,.jpeg" class="hidden" required>
                            </div>
                        </div>

                        <!-- Agreements T&C disclaimer -->
                        <div class="bg-base-200/50 border border-base-300/60 p-5 rounded-2xl text-xs text-base-content/70 leading-relaxed">
                            <p>Dengan menekan tombol <b>Kirim Pendaftaran</b>, Anda menyatakan bahwa data pendaftaran, nomor telepon, dan letak koordinat rumah yang Anda berikan adalah benar dan valid.</p>
                        </div>

                        <!-- Footer Navigation (Kirim Pendaftaran Only) -->
                        <div class="pt-6 border-t border-base-300/40 flex justify-end">
                            <button type="submit" id="submit-btn"
                                class="btn btn-success text-white font-bold px-8 rounded-xl active:scale-95 transition-transform flex items-center gap-1.5 shadow-md shadow-success/20">
                                Kirim Pendaftaran <i data-lucide="send" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            
            <!-- Contact Customer Service support box below -->
            <div class="glass-card p-6 rounded-3xl shadow-lg border border-base-300/50 flex flex-col sm:flex-row gap-5 items-start sm:items-center">
                <div class="bg-primary/10 p-3.5 rounded-2xl text-primary shrink-0">
                    <i data-lucide="headphones" class="w-6 h-6 sm:w-8 sm:h-8"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base-content text-base">Butuh Bantuan Pendaftaran?</h4>
                    <p class="text-sm text-base-content/50 mt-1 mb-3">Customer service kami siap memandu proses pemasangan Anda.</p>
                    <div class="flex flex-col sm:flex-row gap-4 text-xs font-bold uppercase tracking-wider">
                        @if(isset($company) && $company->telepon_perusahaan)
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->telepon_perusahaan) }}" class="flex items-center gap-2 text-base-content/75 hover:text-primary transition">
                                <i data-lucide="phone" class="w-4 h-4 text-primary"></i> {{ $company->telepon_perusahaan }}
                            </a>
                        @else
                            <a href="tel:+6281373242873" class="flex items-center gap-2 text-base-content/75 hover:text-primary transition">
                                <i data-lucide="phone" class="w-4 h-4 text-primary"></i> 0813-7324-2873
                            </a>
                        @endif
                        @if(isset($company) && $company->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" class="flex items-center gap-2 text-success hover:text-success-focus transition">
                                <i data-lucide="message-square" class="w-4 h-4"></i> Chat WhatsApp
                            </a>
                        @else
                            <a href="https://wa.me/6281373242873" target="_blank" class="flex items-center gap-2 text-success hover:text-success-focus transition">
                                <i data-lucide="message-square" class="w-4 h-4"></i> Chat WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // ── Init Lucide Icons ──────────────────────────────────────────────
        lucide.createIcons();

        // ── Step Navigation & Guidances ──────────────────────────────────────────
        let currentStep = 1;
        const stepIndicators = [
            document.getElementById('step-indicator-1'),
            document.getElementById('step-indicator-2'),
            document.getElementById('step-indicator-3')
        ];
        const stepContents = [
            document.getElementById('step-content-1'),
            document.getElementById('step-content-2'),
            document.getElementById('step-content-3')
        ];
        const guideStepTitle = document.getElementById('guide-step-title');
        const guideText = document.getElementById('guide-text');
        const mapHelperBox = document.getElementById('map-helper-box');

        const guides = {
            1: "Silakan masukkan nama lengkap Anda dan nomor telepon WhatsApp aktif yang dapat dihubungi. Setelah itu, pilih salah satu paket layanan internet yang Anda inginkan.",
            2: "Tandai titik lokasi rumah Anda di peta dengan menggeser peta hingga pin merah berada di posisi yang tepat. Gunakan tombol GPS jika Anda sedang berada di lokasi rumah.",
            3: "Upload foto bagian depan rumah Anda dengan jelas. Foto ini digunakan untuk memudahkan teknisi kami memetakan kabel ke rumah Anda."
        };

        function goToStep(step) {
            if (step === currentStep) return;
            
            // Allow going back to any previous step without validation
            if (step < currentStep) {
                // proceed
            } else if (step === currentStep + 1) {
                // Validate current step before going to next
                if (currentStep === 1) {
                    const name = document.querySelector('input[name="nama"]').value.trim();
                    const tel = document.querySelector('input[name="nomor_tlpn"]').value.trim();
                    const paket = document.getElementById('selected-paket').value;

                    if (!name) {
                        alert("Nama Lengkap harus diisi terlebih dahulu.");
                        return;
                    }
                    if (!tel) {
                        alert("Nomor telepon harus diisi terlebih dahulu.");
                        return;
                    }
                    if (!paket) {
                        alert("Silakan pilih salah satu Paket Internet.");
                        return;
                    }
                } else if (currentStep === 2) {
                    const selectWilayah = document.getElementById('select-wilayah');
                    const selectedVal = selectWilayah ? selectWilayah.value : "";
                    const isConfirmed = !document.getElementById('btn-confirm-address').disabled;
                    const addressVal = document.getElementById('alamat-input').value.trim();

                    if (!selectedVal) {
                        alert("Wilayah layanan harus dipilih terlebih dahulu.");
                        return;
                    }
                    if (document.getElementById('btn-confirm-address').textContent === "Wilayah Tidak Terjangkau") {
                        alert("Titik lokasi peta Anda berada di luar jangkauan wilayah R-NET. Silakan hubungi admin.");
                        return;
                    }
                    if (isConfirmed && btnConfirm.textContent.includes("Konfirmasi")) {
                        alert("Silakan tekan tombol 'Konfirmasi Alamat' terlebih dahulu untuk mengunci lokasi peta.");
                        return;
                    }
                    if (!addressVal || addressVal.length < 5) {
                        alert("Alamat rumah lengkap harus diisi.");
                        return;
                    }
                }
            } else {
                // Prevent skipping steps forward (e.g. going to step 3 from step 1)
                alert("Silakan selesaikan langkah sebelumnya terlebih dahulu.");
                return;
            }

            // Update content display
            stepContents.forEach((content, index) => {
                if (index + 1 === step) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });

            // Update step indicators
            stepIndicators.forEach((indicator, index) => {
                if (index + 1 <= step) {
                    indicator.classList.add('step-primary');
                } else {
                    indicator.classList.remove('step-primary');
                }
            });

            // Update Guidance text
            currentStep = step;
            guideStepTitle.textContent = `Langkah ${step} dari 3`;
            guideText.textContent = guides[step];

            if (step === 2) {
                mapHelperBox.classList.remove('hidden');
                // Force Leaflet recalculation when switching to tab
                if (map) {
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 200);
                }
            } else {
                mapHelperBox.classList.add('hidden');
            }
        }

        // ── Paket Card Selector ───────────────────────────────────────────
        function selectPaket(el) {
            var id = el.getAttribute('data-paket-id');
            document.getElementById('selected-paket').value = id;

            document.querySelectorAll('.paket-card').forEach(function (card) {
                var indicator = card.querySelector('div');
                var checkSvg = card.querySelector('svg');

                if (card.getAttribute('data-paket-id') === id) {
                    card.className = "paket-card group relative flex flex-col items-center text-center p-5 rounded-2xl border-2 transition-all duration-300 cursor-pointer w-full border-primary bg-primary/5 ring-1 ring-primary/25 font-bold";
                    indicator.className = "absolute top-3 right-3 w-5 h-5 rounded-full flex items-center justify-center transition-all duration-300 border-2 bg-primary border-primary text-white scale-100";
                    checkSvg.classList.remove('hidden');
                } else {
                    card.className = "paket-card group relative flex flex-col items-center text-center p-5 rounded-2xl border-2 transition-all duration-300 cursor-pointer w-full bg-base-200/40 border-base-300/60 hover:border-primary/50 hover:bg-base-100";
                    indicator.className = "absolute top-3 right-3 w-5 h-5 rounded-full flex items-center justify-center transition-all duration-300 border-2 border-base-300/80 scale-90";
                    checkSvg.classList.add('hidden');
                }
            });
        }

        // ── Leaflet Map (MapPicker React behavior port) ────────────
        var defaultLat = parseFloat(document.getElementById('lat').value) || -2.0337714;
        var defaultLong = parseFloat(document.getElementById('long').value) || 101.3963373;
        var map = L.map('map', { zoomControl: false }).setView([defaultLat, defaultLong], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        setTimeout(() => map.invalidateSize(), 250);

        var tempCenter = { lat: defaultLat, lng: defaultLong };
        var tempAddr = '';
        var isMapSelected = false;

        var pinIcon = document.getElementById('map-pin-icon');
        var pinShadow = document.getElementById('map-pin-shadow');
        var loadingObj = document.getElementById('map-loading-indicator');
        var displayAddr = document.getElementById('temp-address-display');
        var btnConfirm = document.getElementById('btn-confirm-address');
        var alamatInput = document.getElementById('alamat-input');

        // Draw active area circles on the map
        const activeAreasData = @json($areaLayanan);
        activeAreasData.forEach(area => {
            if (area.latitude && area.longitude) {
                L.circle([area.latitude, area.longitude], {
                    radius: parseInt(area.radius) || 1000,
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.15,
                    weight: 2,
                    dashArray: '4, 4'
                }).addTo(map);
            }
        });

        // Global auto-switch wilayah function
        window.autoSwitchWilayah = function (newRegion) {
            var selectWilayah = document.getElementById('select-wilayah');
            if (selectWilayah) {
                selectWilayah.value = newRegion;
                validateWilayahLocation();
            }
        };

        function validateWilayahLocation() {
            var selectWilayah = document.getElementById('select-wilayah');
            var selectedVal = selectWilayah ? selectWilayah.value : "";
            var validationEl = document.getElementById('wilayah-validation-status');

            if (!selectWilayah || !validationEl) return;

            // Logika baru: Cek jarak geografis (radius) ke wilayah layanan terdaftar
            const pinLatLng = L.latLng(tempCenter.lat, tempCenter.lng);
            let detectedRegion = null;
            let minDistance = Infinity;

            activeAreasData.forEach(area => {
                if (!area.latitude || !area.longitude) return;
                const areaLatLng = L.latLng(area.latitude, area.longitude);
                const distance = pinLatLng.distanceTo(areaLatLng);
                const radius = parseInt(area.radius) || 1000;

                if (distance <= radius) {
                    if (distance < minDistance) {
                        minDistance = distance;
                        detectedRegion = area.nama_area;
                    }
                }
            });

            validationEl.classList.remove('hidden');

            // Hapus kelas warna tombol konfirmasi agar bisa diset dinamis
            btnConfirm.className = "w-full btn font-bold rounded-xl shadow";

            // Kasus 1: Wilayah Tidak Terdaftar (di luar radius semua area)
            if (!detectedRegion) {
                btnConfirm.disabled = true;
                btnConfirm.classList.add('btn-disabled');
                btnConfirm.textContent = "Wilayah Tidak Terjangkau";
                delete btnConfirm.dataset.pendingRegion;

                selectWilayah.disabled = true;
                selectWilayah.value = "";

                validationEl.className = "text-xs font-bold text-error bg-error/10 p-3 rounded-xl border border-error/20 flex flex-col gap-2";
                validationEl.innerHTML = `
                    <div class="flex items-start gap-2">
                        <i data-lucide="x-circle" class="w-4 h-4 shrink-0 mt-0.5 text-error"></i>
                        <div>
                            <span class="block font-bold text-error">Lokasi Di Luar Wilayah Layanan R-NET</span>
                            <span class="block font-medium text-base-content/70 mt-0.5 leading-normal">Maaf, titik koordinat yang Anda tandai berada di luar jangkauan wilayah operasional resmi kami.</span>
                        </div>
                    </div>
                    <a href="https://wa.me/6281373242873?text=Halo%20Admin%20R-NET,%20lokasi%20saya%20terdeteksi%20di%20luar%20wilayah%20layanan%20berikut%3A%20${encodeURIComponent(tempAddr)}" target="_blank" class="btn btn-error btn-xs w-full text-white font-bold py-1.5 rounded-lg">
                        <i data-lucide="message-circle" class="w-3.5 h-3.5 mr-1"></i> Hubungi Admin
                    </a>
                `;
                lucide.createIcons();
                return;
            }

            // Jika wilayah terdaftar, buka kunci tombol konfirmasi alamat & select wilayah
            btnConfirm.disabled = false;
            selectWilayah.disabled = false;

            // Kasus 2: Pengguna belum memilih wilayah
            if (!selectedVal) {
                btnConfirm.classList.add('btn-warning');
                btnConfirm.textContent = "Konfirmasi & Pilih Wilayah";
                btnConfirm.dataset.pendingRegion = detectedRegion;

                validationEl.className = "text-xs font-bold text-warning bg-warning/10 p-3 rounded-xl border border-warning/20 flex items-center gap-1.5 animate-pulse";
                validationEl.innerHTML = `
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span>Terdeteksi di "${detectedRegion}". Klik tombol konfirmasi untuk memilih wilayah ini otomatis.</span>
                `;
                lucide.createIcons();
                return;
            }

            // Kasus 3: Lokasi terdeteksi cocok dengan pilihan wilayah
            if (selectedVal === detectedRegion) {
                btnConfirm.classList.add('btn-primary');
                btnConfirm.textContent = "Konfirmasi Alamat";
                delete btnConfirm.dataset.pendingRegion;

                validationEl.className = "text-xs font-bold text-success bg-success/10 p-3 rounded-xl border border-success/20 flex items-center gap-1.5";
                validationEl.innerHTML = `
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0"></i>
                    <span>Sesuai wilayah jangkauan "${selectedVal}"</span>
                `;
            } else {
                // Kasus 4: Alamat terdaftar tetapi salah memilih wilayah
                btnConfirm.classList.add('btn-warning');
                btnConfirm.textContent = "Konfirmasi & Sesuaikan Wilayah";
                btnConfirm.dataset.pendingRegion = detectedRegion;

                validationEl.className = "text-xs font-bold text-warning bg-warning/10 p-3 rounded-xl border border-warning/20 flex items-start gap-1.5";
                validationEl.innerHTML = `
                    <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    <div>
                        <span>Lokasi terdeteksi di "${detectedRegion}", bukan "${selectedVal}". Klik konfirmasi untuk menyesuaikan otomatis.</span>
                    </div>
                `;
            }

            // Re-render icons
            lucide.createIcons();
        }

        // Listener untuk select wilayah
        document.getElementById('select-wilayah').addEventListener('change', function () {
            if (this.value === 'konsultasi') {
                window.open('https://wa.me/6281373242873?text=Halo%20Admin%20R-NET,%20saya%20ingin%20berkonsultasi%20mengenai%20wilayah%20layanan%20internet%20di%20lokasi%20saya.', '_blank');
                this.value = ""; // Reset kembali pilihan
            } else {
                const area = activeAreasData.find(a => a.nama_area === this.value);
                if (area && area.latitude && area.longitude) {
                    map.flyTo([area.latitude, area.longitude], 14); // Geser peta secara dinamis
                }
            }
            validateWilayahLocation();
        });

        function setMapLoading(loading) {
            loadingObj.classList.toggle('hidden', !loading);
            btnConfirm.disabled = loading || !tempAddr;
            if (loading) {
                displayAddr.textContent = "Mencari lokasi di peta...";
            } else {
                displayAddr.textContent = tempAddr || "Geser peta untuk menentukan area";
                validateWilayahLocation();
            }
        }

        async function fetchAddress(lat, lon) {
            setMapLoading(true);
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1&email=admin@r-net.com`, {
                    headers: { 'Accept-Language': 'id-ID,id;q=0.9' }
                });
                if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                const data = await res.json();

                if (data && data.address) {
                    const addr = data.address;
                    const parts = [];

                    const localName = addr.road || addr.hamlet || addr.neighbourhood || addr.residential;
                    if (localName) parts.push(localName);

                    const village = addr.village || addr.suburb || addr.town;
                    if (village && village !== localName) parts.push(village);

                    const district = addr.city_district || addr.county;
                    if (district) parts.push(district.toLowerCase().includes('kec') ? district : `Kec. ${district}`);

                    const city = addr.city || addr.municipality || addr.state_district;
                    if (city && (!parts.length || !parts[parts.length - 1].includes(city))) parts.push(city);

                    const state = addr.state || addr.region;
                    if (state) parts.push(state);

                    let formatted = parts.filter(Boolean).join(', ');
                    if (addr.postcode) formatted += ` ${addr.postcode}`;
                    if (!formatted) formatted = data.display_name;

                    tempAddr = formatted;
                } else if (data && data.display_name) {
                    tempAddr = data.display_name;
                } else {
                    tempAddr = 'Gagal memuat alamat. Pastikan Anda tersambung internet.';
                }
            } catch (err) {
                console.warn("Geocoding API blocked (trying fallback):", err);
                try {
                    const fallbackRes = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
                    const fallData = await fallbackRes.json();
                    if (fallData && (fallData.locality || fallData.city)) {
                        const parts = [fallData.locality, fallData.city, fallData.principalSubdivision, fallData.countryName].filter(Boolean);
                        tempAddr = parts.join(', ');
                    } else {
                        tempAddr = "Pencarian lokasi gagal";
                    }
                } catch (fallbackError) {
                    tempAddr = "Pencarian lokasi gagal (Koneksi jaringan terganggu)";
                }
            } finally {
                setMapLoading(false);
            }
        }

        // Fetch initial
        fetchAddress(defaultLat, defaultLong);

        map.on('movestart zoomstart', function () {
            pinIcon.classList.remove('translate-y-0');
            pinIcon.classList.add('-translate-y-3');
            pinShadow.classList.remove('opacity-100');
            pinShadow.classList.add('opacity-50');
        });

        map.on('moveend', function () {
            pinIcon.classList.add('translate-y-0');
            pinIcon.classList.remove('-translate-y-3');
            pinShadow.classList.add('opacity-100');
            pinShadow.classList.remove('opacity-50');

            var center = map.getCenter();
            tempCenter = { lat: center.lat, lng: center.lng };
            fetchAddress(center.lat, center.lng);
        });

        document.getElementById('btn-gps').addEventListener('click', function (e) {
            e.preventDefault();
            setMapLoading(true);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        map.flyTo([pos.coords.latitude, pos.coords.longitude], 17);
                    },
                    function () {
                        alert("Akses lokasi ditolak atau tidak tersedia pada perangkat Anda.");
                        setMapLoading(false);
                    },
                    { enableHighAccuracy: true }
                );
            }
        });

        btnConfirm.addEventListener('click', function () {
            var pendingRegion = btnConfirm.dataset.pendingRegion;
            if (pendingRegion) {
                autoSwitchWilayah(pendingRegion);
            }

            document.getElementById('lat').value = tempCenter.lat;
            document.getElementById('long').value = tempCenter.lng;
            alamatInput.value = tempAddr;

            isMapSelected = true;
            setTimeout(function () { isMapSelected = false; }, 5000);

            // Floating premium feedback pop-up
            var successBanner = document.createElement('div');
            successBanner.className = "fixed bottom-8 left-1/2 z-[9999] bg-slate-900/95 text-white backdrop-blur-md px-6 py-4 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-slate-800/80 flex items-center gap-3.5 w-[92%] max-w-md";
            successBanner.style.transform = "translate(-50%, 30px)";
            successBanner.style.opacity = "0";
            successBanner.style.transition = "all 0.5s cubic-bezier(0.16, 1, 0.3, 1)";

            successBanner.innerHTML = `
                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </span>
                <div class="flex flex-col text-left">
                    <span class="font-bold text-sm tracking-wide text-white">Konfirmasi Berhasil</span>
                    <span class="text-xs text-slate-400">Alamat & wilayah lokasi Anda telah disimpan.</span>
                </div>
            `;
            document.body.appendChild(successBanner);
            lucide.createIcons();

            // Trigger enter animation
            requestAnimationFrame(() => {
                successBanner.style.transform = "translate(-50%, 0)";
                successBanner.style.opacity = "1";
            });

            setTimeout(() => {
                successBanner.style.transform = "translate(-50%, -20px)";
                successBanner.style.opacity = "0";
                setTimeout(() => successBanner.remove(), 500);
            }, 3500);
        });

        // Auto tracking: Move map automatically if user typed something in Alamat Lengkap
        var typingTimer = null;
        document.getElementById('alamat-input').addEventListener('input', async function () {
            var alamatValue = this.value;

            // Don't auto map if less than some characters or if change was caused by map click
            if (isMapSelected || !alamatValue || alamatValue.length < 10) return;

            if (typingTimer) clearTimeout(typingTimer);
            var timer = setTimeout(async function () {
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamatValue)}&limit=1&email=admin@r-net.com`, {
                        headers: { 'Accept-Language': 'id-ID,id;q=0.9' }
                    });
                    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                    const data = await res.json();
                    if (data && data.length > 0) {
                        const { lat, lon } = data[0];
                        map.setView([parseFloat(lat), parseFloat(lon)], 15);
                        tempCenter = { lat: parseFloat(lat), lng: parseFloat(lon) };
                        fetchAddress(parseFloat(lat), parseFloat(lon));
                    }
                } catch (err) {
                    console.warn("Geocode lookup gracefully aborted (rate limit/network issue):", err);
                }
            }, 2000); // Wait 2 seconds after typing stops
            typingTimer = timer;
        });

        // ── Image Preview & Auto Compress ───────────────────────────────────
        var fileInput = document.getElementById('file-input');
        var previewContainer = document.getElementById('preview-container');
        var previewImage = document.getElementById('image-preview');
        var uploadLabel = document.getElementById('upload-label');

        fileInput.addEventListener('change', function (e) {
            var file = fileInput.files[0];
            if (!file) return;

            if (!file.type.match(/image.*/)) {
                alert('Mohon pilih file gambar (JPG/PNG).');
                fileInput.value = '';
                return;
            }

            uploadLabel.textContent = 'Memproses dan mengkompres gambar...';

            var reader = new FileReader();
            reader.onload = function (readerEvent) {
                var image = new Image();
                image.onload = function () {
                    var canvas = document.createElement('canvas');
                    var max_size = 1920;
                    var width = image.width;
                    var height = image.height;

                    if (width > height) {
                        if (width > max_size) {
                            height *= max_size / width;
                            width = max_size;
                        }
                    } else {
                        if (height > max_size) {
                            width *= max_size / height;
                            height = max_size;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    var ctx = canvas.getContext('2d');

                    // Latar putih mencegah background hitam pada PNG transparan
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    ctx.drawImage(image, 0, 0, width, height);

                    // Kompresi rekursif untuk memastikan ukuran < 1MB
                    var quality = 0.9;
                    var compressImage = function () {
                        canvas.toBlob(function (blob) {
                            if (blob.size > 1048576 && quality > 0.1) {
                                // Kurangi kualitas jika masih > 1MB
                                quality -= 0.1;
                                compressImage();
                            } else {
                                // Selesai
                                var compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, ".jpg"), {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                });

                                // Masukkan file terkompresi kembali ke input
                                var dataTransfer = new DataTransfer();
                                dataTransfer.items.add(compressedFile);
                                fileInput.files = dataTransfer.files;

                                previewImage.src = URL.createObjectURL(compressedFile);
                                previewContainer.classList.remove('hidden');
                                previewContainer.classList.add('flex');
                                uploadLabel.textContent = 'Klik untuk mengganti gambar';
                            }
                        }, 'image/jpeg', quality);
                    };

                    compressImage();
                };
                image.src = readerEvent.target.result;
            };
            reader.readAsDataURL(file);
        });

        // ── Submit loading state with Wilayah check ─────────────────────────
        document.querySelector('form').addEventListener('submit', function (e) {
            var selectWilayah = document.querySelector('select[name="wilayah"]');
            var selectedVal = selectWilayah ? selectWilayah.value : "";

            var currentLat = parseFloat(document.getElementById('lat').value) || tempCenter.lat;
            var currentLng = parseFloat(document.getElementById('long').value) || tempCenter.lng;

            if (selectedVal && !isNaN(currentLat) && !isNaN(currentLng)) {
                var selectedArea = activeAreasData.find(function(area) {
                    return area.nama_area === selectedVal;
                });

                if (selectedArea && selectedArea.latitude && selectedArea.longitude) {
                    var pinLatLng = L.latLng(currentLat, currentLng);
                    var areaLatLng = L.latLng(selectedArea.latitude, selectedArea.longitude);
                    var distance = pinLatLng.distanceTo(areaLatLng);
                    var radius = parseInt(selectedArea.radius) || 1000;

                    if (distance > radius) {
                        var confirmSubmit = confirm(`Perhatian: Lokasi yang Anda tandai di peta sepertinya berada di luar wilayah layanan "${selectedVal}" yang Anda pilih.\n\nApakah Anda yakin lokasi pemasangan sudah benar dan ingin melanjutkan pendaftaran?`);
                        if (!confirmSubmit) {
                            e.preventDefault();
                            return;
                        }
                    }
                }
            }

            var btn = document.getElementById('submit-btn');
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Memproses Data...';
                btn.classList.add('btn-disabled');
            }
        });

        // ── Theme Switcher Initializer ──────────────────────────────────────
        (function() {
            const checkbox = document.getElementById('theme-checkbox');
            const html = document.documentElement;
            const THEME_KEY = 'rnet-theme';
            if (checkbox) {
                const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
                checkbox.checked = savedTheme === 'dark';
                checkbox.addEventListener('change', () => {
                    const t = checkbox.checked ? 'dark' : 'light';
                    html.setAttribute('data-theme', t);
                    localStorage.setItem(THEME_KEY, t);
                });
            }
        })();
    </script>
</body>

</html>
