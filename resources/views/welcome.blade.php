@php
    $biaya = number_format($company->biaya_pasang ?? 350000, 0, ',', '.');
    $estimasi = $company->estimasi_pasang ?? '1-3 Hari Kerja';
    
    $kelengkapanRaw = isset($company->kelengkapan_pasang) && !empty($company->kelengkapan_pasang)
        ? explode("\n", str_replace("\r", "", $company->kelengkapan_pasang))
        : ['Modem WiFi ONT Dual-Band', 'Kabel Fiber Optik FTTH', 'Jasa Pasang Teknisi', 'Aktivasi Layanan'];
        
    $langkahRaw = isset($company->langkah_pasang) && !empty($company->langkah_pasang)
        ? explode("\n", str_replace("\r", "", $company->langkah_pasang))
        : [
            "Verifikasi & Survei|Admin memproses berkas pendaftaran dan teknisi mensurvei jalur tiang ke rumah Anda.",
            "Instalasi & Aktivasi|Teknisi menarik kabel fiber optik, merapikan perangkat modem WiFi, serta mengaktifkan paket internet Anda."
          ];
@endphp
<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="R-NET - Penyedia layanan internet cepat, stabil, tanpa FUP. Nikmati koneksi unlimited dengan harga terjangkau untuk rumah dan keluarga Anda.">
    <title>R-NET - Internet Rakyat Berdaulat</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script>
        (function() {
            var t = localStorage.getItem('rnet-theme') || 'light';
            var img = t === 'dark' ? '{{ asset('backgroundherodarkmode.webp') }}' : '{{ asset('backgroundherolightmode.webp') }}';
            var link = document.createElement('link');
            link.rel = 'preload'; link.as = 'image'; link.href = img;
            document.head.appendChild(link);
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Dynamic Theme Customization -->
    <style>
        :root, [data-theme="light"], [data-theme="dark"] {
            @if(isset($company) && $company->primary_color)
                --color-primary: {{ $company->primary_color }} !important;
                --color-primary-content: #ffffff !important;
                --color-primary-hover: {{ $company->primary_color }}ee !important;
            @endif
            @if(isset($company) && $company->secondary_color)
                --color-secondary: {{ $company->secondary_color }} !important;
                --color-secondary-content: #ffffff !important;
            @endif
            @if(isset($company) && $company->accent_color)
                --color-accent: {{ $company->accent_color }} !important;
                --color-accent-content: #ffffff !important;
            @endif
        }
    </style>

    <!-- Theme Adaptive Hero Background -->
    <style>
        #hero-section {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        [data-theme="light"] #hero-section {
            background-image: url("{{ asset('backgroundherolightmode.webp') }}") !important;
        }

        [data-theme="dark"] #hero-section {
            background-image: url("{{ asset('backgroundherodarkmode.webp') }}") !important;
        }

        @keyframes flow-fast {
            to {
                stroke-dashoffset: -40;
            }
        }

        @keyframes flow-slow {
            to {
                stroke-dashoffset: -40;
            }
        }

        .animate-flow-fast {
            animation: flow-fast 1.2s linear infinite;
        }

        .animate-flow-slow {
            animation: flow-slow 6s linear infinite;
        }

        /* Card premium effects */
        .pricing-card-premium {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .pricing-card-premium::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(25, 119, 191, 0.04) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
            z-index: 0;
        }

        .pricing-card-premium:hover::before {
            opacity: 1;
        }

        .pricing-card-premium:hover {
            transform: translateY(-8px) scale(1.02) !important;
        }

        .pricing-mesh-bg {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(25, 119, 191, 0.05) 1px, transparent 1px);
            background-size: 16px 16px;
            pointer-events: none;
            opacity: 0.7;
            z-index: 0;
        }

        .premium-glow-active {
            --glow-color: var(--theme-border, var(--color-primary, #1977BF));
            box-shadow: 0 10px 30px -10px var(--glow-color) !important;
            border-color: var(--glow-color) !important;
            animation: pulseGlowPremium 3s ease-in-out infinite !important;
        }

        @keyframes pulseGlowPremium {
            0%, 100% {
                box-shadow: 0 10px 30px -10px var(--glow-color) !important;
                border-color: var(--glow-color) !important;
            }
            50% {
                box-shadow: 0 15px 45px -5px var(--glow-color) !important;
                border-color: var(--glow-color) !important;
                filter: brightness(1.1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.35s ease-out forwards;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <!-- Icons (pinned version + deferred) -->
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>
    <style>
        .leaflet-container {
            font-family: inherit;
            background: #f0f2f8;
        }

        [data-theme="dark"] .leaflet-container {
            background: #0a0e17;
        }



        .leaflet-bar {
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            box-shadow: none !important;
            border-radius: 8px !important;
            overflow: hidden;
        }

        .leaflet-bar a {
            background-color: var(--color-base-100) !important;
            color: var(--color-base-content) !important;
            border-bottom: 1px solid var(--color-base-300) !important;
        }

        .leaflet-bar a:hover {
            background-color: var(--color-base-200) !important;
        }

        .leaflet-popup-content-wrapper {
            background: var(--color-base-100) !important;
            color: var(--color-base-content) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .leaflet-popup-tip {
            background: var(--color-base-100) !important;
        }
    </style>
</head>

<body class="font-sans bg-base-100 text-base-content antialiased grid-bg">

    {{-- Modal Konfirmasi Pendaftaran Berhasil --}}
    @if (session('sukses') || session('success'))
        <div id="success-overlay"
            class="fixed inset-0 z-[9999] overflow-y-auto bg-black/60 backdrop-blur-md animate-fade-in">

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
                        <button onclick="document.getElementById('success-overlay').remove()"
                            class="w-full btn btn-primary font-bold py-3 px-6 rounded-xl transition shadow text-sm">
                            Siap, Terima Kasih!
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

    {{-- ==================== NAVBAR ==================== --}}
    <header class="sticky top-0 z-50 w-full bg-base-100/80 backdrop-blur-md border-b border-base-300/15">
        <nav class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Left Side: Brand Logo & Links -->
            <div class="flex items-center gap-10">
                <a href="/" class="flex items-center gap-2 shrink-0">
                    @if(isset($company) && $company->logo_path)
                        <img src="{{ $company->logo_path }}" alt="{{ $company->nama_perusahaan }}" class="h-7 w-auto object-contain">
                    @else
                        <img src="/logoprimary.svg" alt="R-NET Logo" class="h-7 w-auto">
                    @endif
                </a>

                <!-- Center Links (Desktop) -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#fitur"
                        class="text-xs font-semibold text-base-content/70 hover:text-primary transition-colors py-2">Fitur</a>
                    <a href="#speedtest"
                        class="text-xs font-semibold text-base-content/70 hover:text-primary transition-colors py-2">Speed
                        Test</a>
                    <a href="#kalkulator"
                        class="text-xs font-semibold text-base-content/70 hover:text-primary transition-colors py-2">Kalkulator</a>
                    <a href="#harga"
                        class="text-xs font-semibold text-base-content/70 hover:text-primary transition-colors py-2">Paket</a>
                    <a href="/cek-status"
                        class="text-xs font-semibold text-base-content/70 hover:text-primary transition-colors py-2">Cek Status</a>
                    <a href="#terminal-faq"
                        class="text-xs font-semibold text-base-content/70 hover:text-primary transition-colors py-2">FAQ</a>
                </div>
            </div>

            <!-- Right Side: Theme Toggle & CTA -->
            <div class="flex items-center gap-4">
                {{-- Theme Switcher --}}
                <label id="theme-toggle" class="btn btn-ghost btn-circle btn-sm swap swap-rotate" title="Ganti tema">
                    <input type="checkbox" id="theme-checkbox" class="hidden" />
                    <i data-lucide="sun" class="swap-on w-4 h-4 text-amber-500"></i>
                    <i data-lucide="moon" class="swap-off w-4 h-4 text-primary"></i>
                </label>

                <!-- CTA Button -->
                <a href="/daftar" id="btn-daftar-nav"
                    class="btn btn-primary btn-sm rounded-lg font-bold px-5 text-xs active:scale-95 transition-all">
                    Daftar Sekarang
                </a>

                {{-- Mobile Hamburger --}}
                <div class="dropdown dropdown-end lg:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle btn-sm" title="Menu">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-xl bg-base-100 border border-base-300/30 rounded-xl w-48 font-semibold text-xs">
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#speedtest">Speed Test</a></li>
                        <li><a href="#kalkulator">Kalkulator</a></li>
                        <li><a href="#harga">Paket</a></li>
                        <li><a href="/cek-status">Cek Status</a></li>
                        <li><a href="#terminal-faq">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        {{-- ==================== MARQUEE PENGUMUMAN ==================== --}}
        <div id="marquee-bar" class="bg-primary/10 border-b border-primary/20 overflow-hidden h-9 flex items-center">
            <div class="marquee-track text-primary text-xs font-bold gap-16" id="marquee-content">
                @foreach ($pengumuman as $ann)
                    <span class="shrink-0 flex items-center gap-2">• {{ $ann }}</span>
                @endforeach
                @foreach ($pengumuman as $ann)
                    <span class="shrink-0 flex items-center gap-2">• {{ $ann }}</span>
                @endforeach
                @foreach ($pengumuman as $ann)
                    <span class="shrink-0 flex items-center gap-2">• {{ $ann }}</span>
                @endforeach
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16 md:space-y-24">

        {{-- ==================== SECTION 1: HERO ==================== --}}
        <header id="hero-section"
            class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center py-8 px-5 sm:py-12 sm:px-10 md:px-12 rounded-3xl border border-base-300/20 shadow-xl min-h-[50vh] lg:min-h-[70vh]">
            <!-- Left Info column -->
            <div class="lg:col-span-7 space-y-6 sm:space-y-8 text-left animate-slide-up">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="wifi" class="w-3.5 h-3.5"></i>Internet Cepat & Terjangkau
                </div>

                <h1 class="text-3xl sm:text-5xl md:text-6xl font-black leading-tight tracking-tight text-base-content">
                    Koneksi Tanpa Batas.<br>
                    <span
                        class="bg-gradient-to-r from-primary via-cyan-500 to-blue-500 bg-clip-text text-transparent">Stabil
                        dan Cepat</span>
                </h1>

                <p class="text-sm sm:text-base text-base-content/70 leading-relaxed max-w-xl">
                    R-NET adalah penyedia internet kabel untuk rumah tangga, UMKM, dan komunitas. Kami
                    merancang layanan tanpa batasan FUP agar internet cepat merata di seluruh kalangan masyarakat.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-2">
                    <a href="/daftar"
                        class="btn btn-primary btn-md sm:btn-lg rounded-2xl font-bold px-8 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all text-sm">
                        Daftar Sekarang
                    </a>
                    <a href="#harga"
                        class="btn btn-outline btn-primary btn-md sm:btn-lg rounded-2xl font-bold px-8 hover:scale-[1.02] active:scale-95 transition-all text-sm">
                        Lihat Paket Langganan
                    </a>
                </div>

                <!-- Small Trust Indicator -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-6 border-t border-base-300/30">
                    <div class="flex -space-x-3 shrink-0">
                        <div
                            class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center border-2 border-base-100 text-[10px] font-bold">
                            U1</div>
                        <div
                            class="w-8 h-8 rounded-full bg-cyan-400/20 flex items-center justify-center border-2 border-base-100 text-[10px] font-bold">
                            U2</div>
                        <div
                            class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center border-2 border-base-100 text-[10px] font-bold">
                            U3</div>
                    </div>
                    <p class="text-xs font-semibold text-base-content/60 leading-normal">Didukung penuh oleh 500+ pelanggan aktif daerah</p>
                </div>
            </div>

        </header>


        {{-- ==================== SECTION 3: HARGA ==================== --}}
        <section id="harga" class="space-y-12 animate-slide-up">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="credit-card" class="w-3.5 h-3.5"></i> Skema Harga
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Paket Kecepatan Internet</h2>
                <p class="text-sm text-base-content/60 mt-2">Sesuaikan pilihan paket internet R-NET dengan kebutuhan
                    digital Anda.</p>
            </div>

            <!-- Pricing Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                @foreach($pakets as $index => $paket)
                    @php
                        $isPopular = ($index == 1);
                        $hasPromo = false;
                        $promoDiscount = 0;
                        $promoText = '';
                        if ($paket->promosi) {
                            $now = now();
                            if ($now->between($paket->promosi->valid_start, $paket->promosi->valid_end)) {
                                $hasPromo = true;
                                $promoDiscount = $paket->promosi->value_promosi;
                                $promoText = $paket->promosi->text_promosi;
                            }
                        }
                    @endphp
                    <div id="card-paket-{{ $paket->id_paket }}"
                        class="glass-card pricing-card-premium rounded-3xl overflow-hidden shadow-lg flex flex-col justify-between {{ $isPopular ? 'border-primary border-2 premium-glow-active' : 'border border-base-300/60' }}"
                        @if($paket->warna_bg || $paket->warna_font || $paket->warna_border || $paket->warna_button)
                        data-theme-card
                        data-theme-bg="{{ $paket->warna_bg ?? '' }}"
                        data-theme-font="{{ $paket->warna_font ?? '' }}"
                        data-theme-border="{{ $paket->warna_border ?? '' }}"
                        data-theme-button="{{ $paket->warna_button ?? '' }}"
                        @endif
                        style="@if($paket->warna_bg) background-color: {{ $paket->warna_bg }} !important; @endif @if($paket->warna_border) border-color: {{ $paket->warna_border }} !important; box-shadow: 0 10px 30px -10px {{ $paket->warna_border }}40 !important; --theme-border: {{ $paket->warna_border }} !important; @endif @if($paket->warna_font) color: {{ $paket->warna_font }} !important; @endif @if($paket->font_family) font-family: '{{ $paket->font_family }}', sans-serif !important; @endif">

                        <!-- Mesh Grid & Glow decoration -->
                        <div class="pricing-mesh-bg"></div>
                        <div class="absolute -top-12 -right-12 w-28 h-28 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="p-6 md:p-8 space-y-6 flex-1 flex flex-col justify-between relative z-10">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; opacity: 0.8; @endif @if($paket->warna_button) background-color: {{ $paket->warna_button }}15 !important; @endif">
                                        Jaringan FTTH
                                    </span>
                                    @if($paket->badge_text)
                                        <span class="badge font-black text-[9px] uppercase tracking-wider py-2.5 px-3 text-white border-none shadow-md" style="@if($paket->warna_button) background-color: {{ $paket->warna_button }} !important; border-color: {{ $paket->warna_button }} !important; box-shadow: 0 4px 12px -2px {{ $paket->warna_button }}40 !important; @else background-color: #2563eb !important; @endif">
                                            {{ $paket->badge_text }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-primary/15 flex items-center justify-center text-primary shrink-0" style="@if($paket->warna_button) background-color: {{ $paket->warna_button }}15 !important; color: {{ $paket->warna_button }} !important; @endif">
                                        <i data-lucide="gauge" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-base-content leading-tight tracking-tight" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; @endif">
                                        {{ $paket->title_paket }}
                                    </h3>
                                </div>
                            </div>

                            @if($hasPromo)
                                <div class="py-2 space-y-1 relative">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-base-content/40 line-through" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; opacity: 0.5; @endif">
                                        Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                    </div>
                                    <div class="flex items-baseline justify-start gap-1">
                                        <span class="text-5xl font-black text-base-content tracking-tight" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; @endif">
                                            {{ number_format(($paket->harga_paket - $promoDiscount) / 1000, 0) }}K
                                        </span>
                                        <span class="text-xs text-base-content/50 font-bold" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; opacity: 0.7; @endif">/bulan</span>
                                    </div>
                                    <div class="inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-wider text-secondary mt-1 bg-secondary/15 px-2 py-0.5 rounded" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; opacity: 0.9; @endif">
                                        <i data-lucide="sparkles" class="w-3 h-3"></i> PROMO: {{ $promoText }}
                                    </div>
                                </div>
                            @else
                                <div class="flex items-baseline justify-start gap-1 py-4">
                                    <span class="text-5xl font-black text-base-content tracking-tight" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; @endif">
                                        {{ number_format($paket->harga_paket / 1000, 0) }}K
                                    </span>
                                    <span class="text-xs text-base-content/50 font-bold" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; opacity: 0.7; @endif">/bulan</span>
                                </div>
                            @endif

                            <div class="border-t border-base-300/40 my-1"></div>

                            <ul class="space-y-3 text-xs text-base-content/85 font-medium flex-1 pt-2" style="@if($paket->warna_font) color: {{ $paket->warna_font }} !important; @endif">
                                @if($paket->point_keunggulan && is_array($paket->point_keunggulan))
                                    @foreach($paket->point_keunggulan as $point)
                                        <li class="flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                            <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 shadow-sm" style="background-color: {{ $paket->warna_button ? $paket->warna_button . '20' : 'rgba(34, 197, 94, 0.15)' }}; color: {{ $paket->warna_button ? $paket->warna_button : '#22c55e' }};">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            </span>
                                            <span class="text-[13px]">{{ $point }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                        <span class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0 shadow-sm">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        <span class="text-[13px]">Kuota 100% Unlimited Murni</span>
                                    </li>
                                    <li class="flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                        <span class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0 shadow-sm">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        <span class="text-[13px]">Bebas Lag &amp; Throttling FUP</span>
                                    </li>
                                    <li class="flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                        <span class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0 shadow-sm">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </span>
                                        <span class="text-[13px]">Modem WiFi ONT Dipinjamkan Gratis</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- Action Button Card -->
                        <div class="p-6 bg-base-200/40 border-t border-base-300/40 relative z-10" style="@if($paket->warna_border) border-color: {{ $paket->warna_border }}40 !important; @endif">
                            <a href="/daftar?paket={{ $paket->id_paket }}"
                                class="btn w-full rounded-xl font-bold text-xs active:scale-95 transition-all text-white border-none shadow-lg"
                                style="@if($paket->warna_button) background-color: {{ $paket->warna_button }} !important; border-color: {{ $paket->warna_button }} !important; box-shadow: 0 4px 14px -2px {{ $paket->warna_button }}50 !important; @else background-color: #2563eb !important; border-color: #2563eb !important; box-shadow: 0 4px 14px -2px rgba(37, 99, 235, 0.4) !important; @endif">
                                BELI PAKET
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="max-w-xl mx-auto bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm text-center space-y-4">
                <div class="inline-flex items-center justify-center gap-2 bg-yellow-400 text-amber-950 px-4 py-2.5 rounded-2xl sm:rounded-full text-xs font-bold w-full border border-yellow-500 shadow-sm">
                    <i data-lucide="info" class="w-4 h-4 shrink-0"></i> BIAYA PENARIKAN KABEL &amp; INSTALASI MODEM HANYA Rp {{ number_format($company->biaya_pasang ?? 350000, 0, ',', '.') }}
                </div>
                
                <div class="space-y-3 pt-1">
                    <span class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest block">Kelengkapan Paket Pasang yang Anda Dapatkan:</span>
                    <div class="flex flex-wrap justify-center gap-2">
                        @foreach($kelengkapanRaw as $item)
                            @if(trim($item))
                            <span class="px-3.5 py-2 bg-base-200 text-base-content/85 text-[11px] font-bold rounded-2xl border border-base-300 flex items-center gap-2 hover:border-primary/40 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ trim($item) }}
                            </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>


        {{-- ==================== SECTION: PETA JANGKAUAN INTERAKTIF ==================== --}}
        <section id="peta-jangkauan" class="space-y-10">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="map" class="w-3.5 h-3.5"></i> Wilayah Aktif
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Peta Jangkauan Layanan</h2>
                <p class="text-sm text-base-content/60 mt-2">Infrastruktur jaringan R-NET telah aktif di
                    wilayah berikut. Klik wilayah untuk informasi detail.</p>
            </div>

            <div class="glass-card p-4 rounded-3xl border border-base-300/30 shadow-sm overflow-hidden h-[320px] sm:h-[450px] relative">
                <div id="map" class="w-full h-full min-h-[290px] sm:min-h-[420px] rounded-2xl z-10"></div>
            </div>
        </section>


        {{-- ==================== BENTO INTERACTIVE DASHBOARD ==================== --}}
        <section id="speedtest" class="space-y-10">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="sliders" class="w-3.5 h-3.5"></i> Panel Kontrol
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Simulasi &amp; Kebutuhan Internet</h2>
                <p class="text-sm text-base-content/60 mt-2">Ketahui kecocokan paket, bandingkan performa tanpa batas kuota, dan pantau kestabilan latensi R-NET.</p>
            </div>

            <!-- The Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

                <!-- Card 2: Interactive Cost Configurator (12/12 width) -->
                <div id="kalkulator"
                    class="md:col-span-12 glass-card p-5 sm:p-8 rounded-3xl border border-base-300/30 flex flex-col justify-between shadow-sm">
                    <div class="space-y-1 mb-6">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Konfigurator Layanan</span>
                        <h3 class="text-lg font-bold text-base-content tracking-tight">Rekomendasi Paket Berdasarkan Aktivitas</h3>
                        <p class="text-xs text-base-content/60 leading-relaxed">Pilih profil penggunaan dan jenis aktivitas internet Anda untuk mendapatkan rekomendasi kapasitas jaringan yang paling tepat.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                        <!-- Left Side: Interactive Configurator -->
                        <div class="space-y-6 flex flex-col justify-between">
                            <!-- Step 1: User Profile -->
                            <div class="space-y-3">
                                <span class="text-[10px] font-bold text-base-content/40 uppercase tracking-wider block">1. Profil Pengguna</span>
                                <div class="grid grid-cols-3 gap-2.5">
                                    <button type="button" onclick="setProfile('personal', this)"
                                        class="profile-btn border-primary bg-primary/10 text-primary border rounded-2xl p-3 flex flex-col items-center justify-center gap-1.5 transition-all text-center">
                                        <i data-lucide="user" class="w-5 h-5 shrink-0"></i>
                                        <span class="text-[10px] font-black uppercase tracking-wider leading-tight">Personal</span>
                                        <span class="text-[9px] opacity-60">1-3 Perangkat</span>
                                    </button>
                                    <button type="button" onclick="setProfile('family', this)"
                                        class="profile-btn border-base-300/60 bg-base-100/50 hover:bg-base-200 border rounded-2xl p-3 flex flex-col items-center justify-center gap-1.5 transition-all text-center">
                                        <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
                                        <span class="text-[10px] font-black uppercase tracking-wider leading-tight">Keluarga</span>
                                        <span class="text-[9px] opacity-60">4-8 Perangkat</span>
                                    </button>
                                    <button type="button" onclick="setProfile('business', this)"
                                        class="profile-btn border-base-300/60 bg-base-100/50 hover:bg-base-200 border rounded-2xl p-3 flex flex-col items-center justify-center gap-1.5 transition-all text-center">
                                        <i data-lucide="building" class="w-5 h-5 shrink-0"></i>
                                        <span class="text-[10px] font-black uppercase tracking-wider leading-tight">Bisnis</span>
                                        <span class="text-[9px] opacity-60">9+ Perangkat</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Activities Toggles -->
                            <div class="space-y-3">
                                <span class="text-[10px] font-bold text-base-content/40 uppercase tracking-wider block">2. Aktivitas Utama</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <button type="button" onclick="toggleActivity('browsing', this)"
                                        class="activity-btn border-primary bg-primary/10 text-primary border rounded-2xl p-3.5 flex items-center gap-3 transition-all text-left">
                                        <div class="w-8 h-8 rounded-lg bg-primary/15 flex items-center justify-center shrink-0">
                                            <i data-lucide="globe" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold block leading-tight">Browsing &amp; Chatting</span>
                                            <span class="text-[10px] opacity-60 font-medium leading-none">Sosial Media, Chatting</span>
                                        </div>
                                    </button>
                                    <button type="button" onclick="toggleActivity('streaming', this)"
                                        class="activity-btn border-primary bg-primary/10 text-primary border rounded-2xl p-3.5 flex items-center gap-3 transition-all text-left">
                                        <div class="w-8 h-8 rounded-lg bg-primary/15 flex items-center justify-center shrink-0">
                                            <i data-lucide="video" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold block leading-tight">Streaming Video</span>
                                            <span class="text-[10px] opacity-60 font-medium leading-none">YouTube, Netflix HD/4K</span>
                                        </div>
                                    </button>
                                    <button type="button" onclick="toggleActivity('gaming', this)"
                                        class="activity-btn border-base-300/60 bg-base-100/50 hover:bg-base-200 border rounded-2xl p-3.5 flex items-center gap-3 transition-all text-left">
                                        <div class="w-8 h-8 rounded-lg bg-base-content/10 flex items-center justify-center shrink-0">
                                            <i data-lucide="gamepad-2" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold block leading-tight">Online Gaming</span>
                                            <span class="text-[10px] opacity-60 font-medium leading-none">Bermain Game Online</span>
                                        </div>
                                    </button>
                                    <button type="button" onclick="toggleActivity('work', this)"
                                        class="activity-btn border-base-300/60 bg-base-100/50 hover:bg-base-200 border rounded-2xl p-3.5 flex items-center gap-3 transition-all text-left">
                                        <div class="w-8 h-8 rounded-lg bg-base-content/10 flex items-center justify-center shrink-0">
                                            <i data-lucide="laptop" class="w-4 h-4"></i>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold block leading-tight">Kerja &amp; Belajar</span>
                                            <span class="text-[10px] opacity-60 font-medium leading-none">Zoom Call, Upload File</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Result Display Box (Enterprise Invoice Card) -->
                        <div class="flex flex-col gap-4 justify-between">
                            <div class="bg-base-200/50 border border-base-300/20 rounded-2xl p-5 space-y-4 flex-1 flex flex-col justify-center">
                                <div class="flex justify-between items-center text-xs border-b border-base-300/10 pb-3">
                                    <span class="font-medium text-base-content/60">Paket Rekomendasi:</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        <span class="font-extrabold text-primary" id="calc-rec-name">Paket Populer</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs border-b border-base-300/10 pb-3">
                                    <span class="font-medium text-base-content/60">Estimasi Kecepatan:</span>
                                    <span class="font-extrabold text-base-content" id="calc-rec-speed">30 Mbps</span>
                                </div>
                                <div class="flex justify-between items-start text-xs border-b border-base-300/10 pb-3">
                                    <span class="font-medium text-base-content/60 mt-0.5">Aktivitas Ideal:</span>
                                    <span class="font-bold text-base-content/85 text-right max-w-[200px]" id="calc-rec-activity">Streaming Netflix HD, Kerja Remote, Belajar Online</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-medium text-base-content/60">Estimasi Biaya:</span>
                                    <span class="font-extrabold text-base-content" id="calc-rec-cost">Rp 8.333 / hari (Total)</span>
                                </div>
                            </div>
                            <a href="/daftar"
                                class="w-full btn btn-primary rounded-xl font-bold text-xs active:scale-[0.98] transition-transform">
                                DAFTAR PAKET INI
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: No-FUP Flow Visualizer (8/12 width) -->
                <div
                    class="md:col-span-8 glass-card p-5 sm:p-8 rounded-3xl border border-base-300/30 flex flex-col md:flex-row gap-8 items-stretch shadow-sm">
                    <div class="flex flex-col justify-between md:w-1/2 space-y-6">
                        <div class="space-y-2">
                            <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Keuntungan Tanpa FUP</span>
                            <h3 class="text-lg font-bold text-base-content tracking-tight">Koneksi Stabil Tanpa Batasan Kuota</h3>
                            <p class="text-xs text-base-content/65 leading-relaxed">
                                Banyak penyedia internet menerapkan <strong>FUP (Batas Pemakaian Wajar)</strong>. Jika kuota FUP Anda habis, kecepatan diturunkan drastis (sangat lambat).
                            </p>
                            <p class="text-xs text-base-content/65 leading-relaxed border-l-2 border-primary/40 pl-2">
                                <strong>R-NET:</strong> Kecepatan stabil penuh 24 jam sehari, 30 hari sebulan, bebas download dan streaming sepuasnya.
                            </p>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 shrink-0"></span>
                                <span class="font-semibold text-base-content/80 text-xs">R-NET (100% Tanpa Batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-error shrink-0"></span>
                                <span class="font-semibold text-base-content/60 text-xs">Internet Seluler / FUP Terbatas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Flow Animation visual canvas (High Fidelity SVG Streams) -->
                    <div
                        class="bg-base-200/30 border border-base-300/20 rounded-2xl p-6 md:w-1/2 flex flex-col justify-center gap-6 relative overflow-hidden min-h-[160px]">
                        <!-- Track 1: R-NET Unlimited -->
                        <div class="space-y-2">
                            <div
                                class="flex justify-between items-center text-[9px] font-bold text-base-content/40 uppercase tracking-wider">
                                <span>R-NET (100% Tanpa Batas)</span>
                                <span class="text-cyan-500 font-extrabold flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-ping"></span> Lancar</span>
                            </div>
                            <div
                                class="relative h-4 flex items-center bg-base-200/50 border border-base-300/10 rounded-lg overflow-hidden px-2">
                                <svg class="w-full h-2 overflow-visible" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <filter id="glow-cyan" x="-20%" y="-20%" width="140%" height="140%">
                                            <feGaussianBlur stdDeviation="2" result="blur" />
                                            <feComposite in="SourceGraphic" in2="blur" operator="over" />
                                        </filter>
                                    </defs>
                                    <line x1="0" y1="4" x2="100%" y2="4" stroke="#06b6d4" stroke-width="3.5"
                                        stroke-dasharray="12, 16" class="animate-flow-fast" filter="url(#glow-cyan)" />
                                </svg>
                            </div>
                        </div>

                        <!-- Track 2: Cellular with FUP limit -->
                        <div class="space-y-2">
                            <div
                                class="flex justify-between items-center text-[9px] font-bold text-base-content/40 uppercase tracking-wider">
                                <span>Seluler Biasa (FUP Limit)</span>
                                <span class="text-error font-extrabold flex items-center gap-1">Terhambat</span>
                            </div>
                            <div
                                class="relative h-4 flex items-center bg-base-200/50 border border-base-300/10 rounded-lg overflow-hidden px-2">
                                <svg class="w-full h-2" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0" y1="4" x2="100%" y2="4" stroke="#ef4444" stroke-width="3"
                                        stroke-dasharray="4, 25" class="animate-flow-slow" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Realtime Server Ping (4/12 width) -->
                <div
                    class="md:col-span-4 glass-card p-5 sm:p-8 rounded-3xl border border-base-300/30 flex flex-col justify-between shadow-sm">
                    <div class="space-y-2">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Pemantauan Kestabilan</span>
                        <h3 class="text-lg font-bold text-base-content tracking-tight">Status Latensi (Ping)</h3>
                        <p class="text-xs text-base-content/65 leading-relaxed">
                            <strong>Ping</strong> mengukur seberapa cepat koneksi internet merespons. Semakin kecil angkanya (ms), koneksi semakin lancar bebas hambatan.
                        </p>
                        <div class="flex items-center gap-2 bg-success/10 text-success border border-success/20 px-3 py-1 rounded-xl w-fit text-[11px] font-bold mt-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-success animate-ping"></span>
                            Sangat Kencang - Bebas Lag
                        </div>
                    </div>

                    <!-- Dynamic Live Bar Graph -->
                    <div class="flex items-end justify-between h-20 px-1 mt-6 border-b border-base-300/15 pb-2">
                        <div class="w-3 bg-primary/20 h-12 rounded-t transition-all duration-500" id="ping-bar-0"></div>
                        <div class="w-3 bg-primary/30 h-14 rounded-t transition-all duration-500" id="ping-bar-1"></div>
                        <div class="w-3 bg-primary/25 h-13 rounded-t transition-all duration-500" id="ping-bar-2"></div>
                        <div class="w-3 bg-cyan-500/40 h-16 rounded-t transition-all duration-500" id="ping-bar-3">
                        </div>
                        <div class="w-3 bg-primary/20 h-15 rounded-t transition-all duration-500" id="ping-bar-4"></div>
                        <div class="w-3 bg-primary/30 h-14 rounded-t transition-all duration-500" id="ping-bar-5"></div>
                        <div class="w-3 bg-cyan-500/80 h-16 rounded-t transition-all duration-500" id="ping-bar-6">
                        </div>
                        <div class="w-3 bg-primary/40 h-12 rounded-t transition-all duration-500" id="ping-bar-7"></div>
                    </div>

                    <div
                        class="flex justify-between items-center text-[9px] font-bold text-base-content/40 uppercase tracking-widest pt-4">
                        <span>Ping Rata-Rata</span>
                        <span class="text-success font-extrabold flex items-center gap-1 text-xs"><i data-lucide="check"
                                class="w-3.5 h-3.5"></i> <span id="avg-ping-text">2ms</span></span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== SECTION 2: FITUR ==================== --}}
        <section id="fitur" class="py-10">
            <div class="text-center max-w-xl mx-auto mb-16">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="cpu" class="w-3.5 h-3.5"></i> Jaringan Unggulan
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Standar Kualitas Jaringan</h2>
                <p class="text-sm text-base-content/60 mt-2">Menawarkan solusi internet terbaik langsung ke rumah Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div
                    class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/30 shadow-sm hover:shadow-md transition-all hover:-translate-y-1 duration-300 group">
                    <div
                        class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center group-hover:scale-105 duration-300 mb-6 text-primary">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-base-content tracking-tight">Koneksi FTTH</h3>
                    <p class="text-xs text-base-content/65 leading-relaxed mt-2.5">
                        Kabel internet ditarik langsung ke dalam rumah Anda (FTTH) untuk meminimalkan
                        gangguan induksi listrik dan cuaca buruk.
                    </p>
                </div>

                <!-- Fitur 2 -->
                <div
                    class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/30 shadow-sm hover:shadow-md transition-all hover:-translate-y-1 duration-300 group">
                    <div
                        class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center group-hover:scale-105 duration-300 mb-6 text-primary">
                        <i data-lucide="lock" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-base-content tracking-tight">Tanpa FUP</h3>
                    <p class="text-xs text-base-content/65 leading-relaxed mt-2.5">
                        Gunakan internet sepuasnya tanpa batas kuota bulanan. Kecepatan tetap stabil dari hari pertama
                        hingga akhir bulan, bebas khawatir.
                    </p>
                </div>

                <!-- Fitur 3 -->
                <div
                    class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/30 shadow-sm hover:shadow-md transition-all hover:-translate-y-1 duration-300 group">
                    <div
                        class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center group-hover:scale-105 duration-300 mb-6 text-primary">
                        <i data-lucide="heart-handshake" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-base-content tracking-tight">Layanan Lokal 24 Jam</h3>
                    <p class="text-xs text-base-content/65 leading-relaxed mt-2.5">
                        Teknisi lapangan kami siaga di area cakupan lokal untuk menangani gangguan konektivitas dengan
                        respon cepat kurang dari 24 jam.
                    </p>
                </div>
            </div>
        </section>


        {{-- ==================== SECTION: DYNAMIC TERMINAL FAQ ==================== --}}
        <section id="terminal-faq" class="space-y-10 py-10 max-w-4xl mx-auto">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="help-circle" class="w-3.5 h-3.5"></i> Tanya Jawab
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-sm text-base-content/60 mt-2">Temukan jawaban cepat untuk pertanyaan seputar layanan internet R-NET.</p>
            </div>

            <!-- High-Tech Interactive Terminal FAQ Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                <!-- Left: Interactive Commands List -->
                <div class="md:col-span-5 flex flex-row md:flex-col overflow-x-auto md:overflow-x-visible pb-3 md:pb-0 gap-3 scrollbar-none snap-x snap-mandatory">
                    <button onclick="selectFaq(1, this)"
                        class="faq-tab bg-primary/10 text-primary border-primary/40 btn btn-outline justify-start rounded-2xl p-4 w-[280px] md:w-full h-auto text-left gap-3 text-xs font-bold normal-case leading-snug transition-all duration-300 hover:bg-base-200 shrink-0 snap-center">
                        <i data-lucide="zap" class="w-5 h-5 shrink-0"></i>
                        <span>Apakah internet R-NET dibatasi kuota bulanan (FUP)?</span>
                    </button>
                    <button onclick="selectFaq(2, this)"
                        class="faq-tab border-base-300/60 btn btn-outline justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-[280px] md:w-full h-auto text-left gap-3 text-xs font-bold normal-case leading-snug transition-all duration-300 shrink-0 snap-center">
                        <i data-lucide="credit-card" class="w-5 h-5 shrink-0"></i>
                        <span>Berapa biaya pasang baru dan apa saja yang didapat?</span>
                    </button>
                    <button onclick="selectFaq(3, this)"
                        class="faq-tab border-base-300/60 btn btn-outline justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-[280px] md:w-full h-auto text-left gap-3 text-xs font-bold normal-case leading-snug transition-all duration-300 shrink-0 snap-center">
                        <i data-lucide="calendar-clock" class="w-5 h-5 shrink-0"></i>
                        <span>Berapa lama waktu pemasangan setelah mendaftar?</span>
                    </button>
                    <button onclick="selectFaq(4, this)"
                        class="faq-tab border-base-300/60 btn btn-outline justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-[280px] md:w-full h-auto text-left gap-3 text-xs font-bold normal-case leading-snug transition-all duration-300 shrink-0 snap-center">
                        <i data-lucide="map-pin" class="w-5 h-5 shrink-0"></i>
                        <span>Di mana saja cakupan area jangkauan R-NET saat ini?</span>
                    </button>
                </div>

                <!-- Right: Smart Assistant Q&A Panel -->
                <div
                    class="md:col-span-7 glass-card p-6 rounded-3xl border border-base-300/30 shadow-xl relative overflow-hidden min-h-[320px] flex flex-col justify-between">
                    <!-- Assistant Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-base-300/30 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary">
                                    <i data-lucide="smile" class="w-5 h-5"></i>
                                </div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-success border-2 border-base-100"></span>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-sm text-base-content leading-tight">Asisten R-NET</h4>
                                <span class="text-[10px] font-semibold text-success flex items-center gap-1">
                                    Online • Siap membantu Anda
                                </span>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-base-content/40 tracking-wider font-mono">FAQ HELPDESK</span>
                    </div>

                    <!-- Answers content area -->
                    <div class="flex-1 overflow-y-auto space-y-4 pr-1 scrollbar-thin text-base-content"
                        id="faq-terminal-text">
                        <!-- Initial state: Answer 1 rendered statically by default -->
                        <div class="space-y-3 animate-fade-in-up">
                            <div class="flex items-center gap-2">
                                <span class="badge badge-success text-white font-extrabold text-[10px] tracking-wider py-2 px-3">100% UNLIMITED</span>
                                <span class="text-xs text-base-content/50 font-bold">Tanpa Batas Kuota</span>
                            </div>
                            <p class="text-xs text-base-content/85 leading-relaxed font-medium">
                                R-NET berkomitmen untuk menyediakan layanan internet murni tanpa kebijakan batas pemakaian wajar (FUP).
                            </p>
                            <div class="bg-base-200/50 border border-base-300/20 rounded-xl p-3.5 space-y-2">
                                <div class="flex items-start gap-2.5 text-xs text-base-content/75">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-success shrink-0 mt-0.5"></i>
                                    <span><strong>Bebas Download & Streaming:</strong> Tonton video HD dan unduh berkas besar sepuasnya kapan saja.</span>
                                </div>
                                <div class="flex items-start gap-2.5 text-xs text-base-content/75">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-success shrink-0 mt-0.5"></i>
                                    <span><strong>Kecepatan Stabil:</strong> Tidak ada penurunan kecepatan internet secara tiba-tiba di akhir bulan.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Footer / Prompt -->
                    <div class="flex items-center gap-2 mt-4 pt-3 border-t border-base-300/30">
                        <p class="text-[11px] text-base-content/50 font-medium">Ada pertanyaan lain?</p>
                        @if(isset($company) && $company->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}?text=Halo%20R-NET,%20saya%20ingin%20tanya%20tentang..." target="_blank" rel="noopener noreferrer" class="text-[11px] font-bold text-primary hover:underline flex items-center gap-0.5">
                                Hubungi Admin via WhatsApp <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                        @else
                            <a href="https://wa.me/6281373242673?text=Halo%20R-NET,%20saya%20ingin%20tanya%20tentang..." target="_blank" rel="noopener noreferrer" class="text-[11px] font-bold text-primary hover:underline flex items-center gap-0.5">
                                Hubungi Admin via WhatsApp <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- ==================== FOOTER / KONTAK ==================== --}}
    <footer id="kontak" class="bg-base-200 text-base-content border-t border-base-300/40 mt-20">
        <div class="container mx-auto px-5 sm:px-8 lg:px-16 py-12 max-w-7xl">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-12">
                <!-- Left side -->
                <aside class="max-w-xs space-y-4">
                    @if(isset($company) && $company->logo_path)
                        <img src="{{ $company->logo_path }}" alt="{{ $company->nama_perusahaan }}" class="h-8 w-auto object-contain">
                    @else
                        <img src="/logoprimary.svg" alt="R-NET" class="h-8 w-auto">
                    @endif
                    <p class="text-base-content/60 text-xs leading-relaxed">
                        Penyedia layanan internet rakyat terpercaya. Menghadirkan koneksi handal tanpa kuota
                        FUP untuk kedaulatan digital bersama.<br><br>
                        Hak Cipta &copy; {{ date('Y') }} {{ $company->nama_perusahaan ?? 'R-NET' }} — Seluruh hak cipta dilindungi.
                    </p>
                </aside>

                <!-- Right side navigation links in columns -->
                <div class="grid grid-cols-2 sm:flex sm:flex-row gap-8 lg:gap-16">
                    <nav class="flex flex-col gap-2.5 text-xs font-semibold">
                        <h6 class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">Layanan
                        </h6>
                        <a href="#fitur" class="link link-hover text-base-content/75">Fitur Unggulan</a>
                        <a href="#harga" class="link link-hover text-base-content/75">Paket Internet</a>
                        <a href="/daftar" class="link link-hover text-base-content/75">Pendaftaran Baru</a>
                    </nav>
                    <nav class="flex flex-col gap-2.5 text-xs font-semibold">
                        <h6 class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">Perusahaan
                        </h6>
                        <a href="#" class="link link-hover text-base-content/75">Tentang {{ $company->nama_perusahaan ?? 'R-NET' }}</a>
                        @if(isset($company) && $company->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" rel="noopener noreferrer"
                                class="link link-hover text-base-content/75">Hubungi Kami</a>
                        @else
                            <a href="https://wa.me/6281373242673" target="_blank" rel="noopener noreferrer"
                                class="link link-hover text-base-content/75">Hubungi Kami</a>
                        @endif
                    </nav>
                    <nav class="flex flex-col gap-2.5 text-xs font-semibold col-span-2 sm:col-span-1">
                        <h6 class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">Legal</h6>
                        <a href="#" class="link link-hover text-base-content/75">Syarat Ketentuan</a>
                        <a href="#" class="link link-hover text-base-content/75">Kebijakan Privasi</a>
                        <a href="#" class="link link-hover text-base-content/75">Kebijakan Cookie</a>
                    </nav>
                </div>
            </div>
        </div>
    </footer>

    {{-- ==================== JAVASCRIPT ==================== --}}
    <script>
        // ── Theme Toggle ──────────────────────────────────────────
        const html = document.documentElement;
        const checkbox = document.getElementById('theme-checkbox');
        const THEME_KEY = 'rnet-theme';

        function updateHeroBg(theme) {
            // No background image swaps needed anymore as we are using a custom tech-grid background!
        }

        // ── Algoritma Pembalik Warna untuk Kartu Paket ───────────
        function hexToHSL(hex) {
            hex = hex.replace('#', '');
            if (hex.length === 3) hex = hex.split('').map(c => c+c).join('');
            const r = parseInt(hex.substring(0,2), 16) / 255;
            const g = parseInt(hex.substring(2,4), 16) / 255;
            const b = parseInt(hex.substring(4,6), 16) / 255;
            const max = Math.max(r,g,b), min = Math.min(r,g,b);
            let h, s, l = (max+min)/2;
            if (max === min) { h = s = 0; }
            else {
                const d = max - min;
                s = l > 0.5 ? d/(2-max-min) : d/(max+min);
                switch(max) {
                    case r: h = ((g-b)/d + (g<b?6:0))/6; break;
                    case g: h = ((b-r)/d + 2)/6; break;
                    case b: h = ((r-g)/d + 4)/6; break;
                }
            }
            return { h: h*360, s: s*100, l: l*100 };
        }

        function hslToHex(h, s, l) {
            s /= 100; l /= 100;
            const a = s * Math.min(l, 1-l);
            const f = n => { const k = (n+h/30) % 12; return l - a*Math.max(Math.min(k-3,9-k,1),-1); };
            return '#' + [f(0),f(8),f(4)].map(x => Math.round(x*255).toString(16).padStart(2,'0')).join('');
        }

        function invertColor(hex, isDark) {
            if (!hex || hex.length < 4) return hex;
            const hsl = hexToHSL(hex);
            // Invert lightness: dark mode → make light colors dark and vice versa
            hsl.l = 100 - hsl.l;
            // Slight saturation boost for dark mode to maintain vibrancy
            if (isDark) hsl.s = Math.min(100, hsl.s * 1.15);
            return hslToHex(hsl.h, hsl.s, hsl.l);
        }

        function invertPaketCardColors(theme) {
            const isDark = theme === 'dark';
            document.querySelectorAll('[data-theme-card]').forEach(card => {
                const origBg = card.dataset.themeBg;
                const origFont = card.dataset.themeFont;
                const origBorder = card.dataset.themeBorder;
                const origButton = card.dataset.themeButton;

                // Determine if original colors are "light" (meant for light mode)
                const bgHSL = origBg ? hexToHSL(origBg) : null;
                const isOriginallyLight = bgHSL ? bgHSL.l > 50 : true;

                // Only invert if mismatch: dark mode with light colors, or light mode with dark colors
                const needsInversion = isDark === isOriginallyLight;

                if (needsInversion) {
                    if (origBg) card.style.backgroundColor = invertColor(origBg, isDark);
                    if (origFont) {
                        card.style.color = invertColor(origFont, isDark);
                        card.querySelectorAll('[style*="color"]').forEach(el => {
                            if (el.style.color && !el.closest('[data-no-invert]')) {
                                el.style.color = invertColor(origFont, isDark);
                            }
                        });
                    }
                    if (origBorder) {
                        card.style.borderColor = invertColor(origBorder, isDark);
                        card.style.boxShadow = `0 10px 30px -10px ${invertColor(origBorder, isDark)}40`;
                    }
                    if (origButton) {
                        card.querySelectorAll('.btn, .badge').forEach(el => {
                            if (el.style.backgroundColor) el.style.backgroundColor = invertColor(origButton, isDark);
                            if (el.style.borderColor) el.style.borderColor = invertColor(origButton, isDark);
                        });
                        card.querySelectorAll('.rounded-full').forEach(el => {
                            if (el.style.backgroundColor) el.style.backgroundColor = invertColor(origButton, isDark) + '20';
                            if (el.style.color) el.style.color = invertColor(origButton, isDark);
                        });
                    }
                    const footerDiv = card.querySelector('.border-t.border-base-300\\/40, .bg-base-200\\/40');
                    if (footerDiv && origBorder) footerDiv.style.borderColor = invertColor(origBorder, isDark) + '40';
                } else {
                    // Restore original colors
                    if (origBg) card.style.backgroundColor = origBg;
                    if (origFont) {
                        card.style.color = origFont;
                        card.querySelectorAll('[style*="color"]').forEach(el => {
                            if (el.style.color && !el.closest('[data-no-invert]')) {
                                el.style.color = origFont;
                            }
                        });
                    }
                    if (origBorder) {
                        card.style.borderColor = origBorder;
                        card.style.boxShadow = `0 10px 30px -10px ${origBorder}40`;
                    }
                    if (origButton) {
                        card.querySelectorAll('.btn, .badge').forEach(el => {
                            if (el.style.backgroundColor) el.style.backgroundColor = origButton;
                            if (el.style.borderColor) el.style.borderColor = origButton;
                        });
                        card.querySelectorAll('.rounded-full').forEach(el => {
                            if (el.style.backgroundColor) el.style.backgroundColor = origButton + '20';
                            if (el.style.color) el.style.color = origButton;
                        });
                    }
                }
            });
        }

        const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
        html.setAttribute('data-theme', savedTheme);
        checkbox.checked = savedTheme === 'dark';
        updateHeroBg(savedTheme);
        // Apply color inversion on initial load
        invertPaketCardColors(savedTheme);

        checkbox.addEventListener('change', () => {
            const t = checkbox.checked ? 'dark' : 'light';
            html.setAttribute('data-theme', t);
            localStorage.setItem(THEME_KEY, t);
            updateHeroBg(t);
            invertPaketCardColors(t);
            if (typeof updateMapTheme === 'function') {
                updateMapTheme(t);
            }
        });

        // ── Smooth scroll ─────────────────────────────────────────
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const targetId = a.getAttribute('href');
                if (targetId === '#') return;
                e.preventDefault();
                const el = document.querySelector(targetId);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // ── Interactive SVG Node Details ─────────────────────────
        const nodeDescriptions = {
            'sp': "Kanal Sungai Penuh aktif. Menjangkau seluruh kelurahan perkotaan Sungai Penuh dengan backbone FTTH utama R-NET.",
            'kr': "Jangkauan Kabupaten Kerinci aktif. Meliputi area perumahan pedesaan dan agrowisata dengan tiang kabel mandiri.",
            'mr': "Jangkauan Kabupaten Merangin aktif. Ekspansi jaringan kecepatan tinggi untuk mendukung operasional bisnis UMKM lokal setempat."
        };

        function showNodeDetails(nodeKey) {
            const textEl = document.getElementById('node-info-text');
            const popup = document.getElementById('node-info-popup');

            // Pop out animation
            popup.classList.remove('scale-100');
            popup.classList.add('scale-90', 'opacity-0');

            setTimeout(() => {
                textEl.textContent = nodeDescriptions[nodeKey];
                popup.classList.remove('scale-90', 'opacity-0');
                popup.classList.add('scale-100');
            }, 150);
        }



        // ── Live Server Ping Simulator (pauses when tab hidden) ────
        function startLivePingSimulator() {
            const bars = [];
            for (let i = 0; i < 8; i++) {
                const el = document.getElementById(`ping-bar-${i}`);
                if (el) bars.push(el);
            }
            const avgPingText = document.getElementById('avg-ping-text');
            let pingInterval = null;

            function runPing() {
                bars.forEach(bar => {
                    bar.style.height = `${Math.floor(Math.random() * 60) + 20}%`;
                });
                const currentAvg = (1.5 + Math.random() * 1.5).toFixed(1);
                if (avgPingText) avgPingText.textContent = `${currentAvg}ms`;
            }

            function start() { if (!pingInterval) pingInterval = setInterval(runPing, 1200); }
            function stop() { clearInterval(pingInterval); pingInterval = null; }

            document.addEventListener('visibilitychange', () => {
                document.hidden ? stop() : start();
            });
            start();
        }
        startLivePingSimulator();

        // ── Cost Configurator widget ───────────────────────────────
        let currentProfile = 'personal';
        const selectedActivities = {
            browsing: true,
            streaming: true,
            gaming: false,
            work: false
        };

        window.setProfile = function(profileKey, btn) {
            currentProfile = profileKey;
            
            // Update button styles
            document.querySelectorAll('.profile-btn').forEach(b => {
                b.classList.remove('border-primary', 'bg-primary/10', 'text-primary');
                b.classList.add('border-base-300/60', 'bg-base-100/50', 'hover:bg-base-200');
            });
            if (btn) {
                btn.classList.add('border-primary', 'bg-primary/10', 'text-primary');
                btn.classList.remove('border-base-300/60', 'bg-base-100/50', 'hover:bg-base-200');
            }

            calculateRecommendation();
        };

        window.toggleActivity = function(activityKey, btn) {
            selectedActivities[activityKey] = !selectedActivities[activityKey];
            
            if (btn) {
                const iconWrapper = btn.querySelector('.rounded-lg');
                if (selectedActivities[activityKey]) {
                    btn.classList.add('border-primary', 'bg-primary/10', 'text-primary');
                    btn.classList.remove('border-base-300/60', 'bg-base-100/50', 'hover:bg-base-200');
                    if (iconWrapper) {
                        iconWrapper.classList.add('bg-primary/15');
                        iconWrapper.classList.remove('bg-base-content/10');
                    }
                } else {
                    btn.classList.remove('border-primary', 'bg-primary/10', 'text-primary');
                    btn.classList.add('border-base-300/60', 'bg-base-100/50', 'hover:bg-base-200');
                    if (iconWrapper) {
                        iconWrapper.classList.remove('bg-primary/15');
                        iconWrapper.classList.add('bg-base-content/10');
                    }
                }
            }

            calculateRecommendation();
        };

        function calculateRecommendation() {
            let baseSpeed = 0;
            
            if (currentProfile === 'personal') {
                baseSpeed = 10;
            } else if (currentProfile === 'family') {
                baseSpeed = 25;
            } else if (currentProfile === 'business') {
                baseSpeed = 60;
            }

            let extraSpeed = 0;
            if (selectedActivities.browsing) extraSpeed += 5;
            if (selectedActivities.streaming) extraSpeed += 15;
            if (selectedActivities.gaming) extraSpeed += 10;
            if (selectedActivities.work) extraSpeed += 10;

            const totalSpeedNeeded = baseSpeed + extraSpeed;

            let recommended = {};
            if (totalSpeedNeeded <= 20) {
                recommended = { 
                    name: 'Paket Hemat', 
                    cost: 150000, 
                    speed: '10 Mbps',
                    activity: 'Browsing ringan, sosial media, dan chat keluarga.'
                };
            } else if (totalSpeedNeeded <= 50) {
                recommended = { 
                    name: 'Paket Populer', 
                    cost: 250000, 
                    speed: '30 Mbps',
                    activity: 'Streaming video lancar, telekonferensi, dan browsing bersama.'
                };
            } else {
                recommended = { 
                    name: 'Paket Premium', 
                    cost: 400000, 
                    speed: '100 Mbps',
                    activity: 'Koneksi maksimal untuk game berat, streaming 4K, dan bisnis.'
                };
            }

            // Update UI elements
            const recName = document.getElementById('calc-rec-name');
            const recSpeed = document.getElementById('calc-rec-speed');
            const recActivity = document.getElementById('calc-rec-activity');
            const recCost = document.getElementById('calc-rec-cost');

            if (recName) recName.textContent = recommended.name;
            if (recSpeed) recSpeed.textContent = recommended.speed;
            if (recActivity) recActivity.textContent = recommended.activity;
            
            // Format daily cost: (Monthly price / 30 days)
            const dailyCost = Math.round(recommended.cost / 30);
            if (recCost) recCost.textContent = `Rp ${dailyCost.toLocaleString('id-ID')} / hari (Total)`;
        }

        // Initialize calculator values
        calculateRecommendation();

        // ── Interactive FAQ Terminal widget ──────────────────────
        // Menggunakan variabel global yang dideklarasikan di bagian atas berkas
        const faqAnswers = {
            1: `
                <div class="space-y-3 animate-fade-in-up">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-success text-white font-extrabold text-[10px] tracking-wider py-2 px-3">100% UNLIMITED</span>
                        <span class="text-xs text-base-content/50 font-bold">Tanpa Batas Kuota</span>
                    </div>
                    <p class="text-xs text-base-content/85 leading-relaxed font-medium">
                        R-NET berkomitmen untuk menyediakan layanan internet murni tanpa kebijakan batas pemakaian wajar (FUP).
                    </p>
                    <div class="bg-base-200/50 border border-base-300/20 rounded-xl p-3.5 space-y-2">
                        <div class="flex items-start gap-2.5 text-xs text-base-content/75">
                            <i data-lucide="check-circle" class="w-4 h-4 text-success shrink-0 mt-0.5"></i>
                            <span><strong>Bebas Download & Streaming:</strong> Tonton video HD dan unduh berkas besar sepuasnya kapan saja.</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-base-content/75">
                            <i data-lucide="check-circle" class="w-4 h-4 text-success shrink-0 mt-0.5"></i>
                            <span><strong>Kecepatan Stabil:</strong> Tidak ada penurunan kecepatan internet secara tiba-tiba di akhir bulan.</span>
                        </div>
                    </div>
                </div>
            `,
            2: `
                <div class="space-y-3 animate-fade-in-up">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-primary text-white font-extrabold text-[10px] tracking-wider py-2 px-3">BIAYA PASANG BARU</span>
                        <span class="text-xs text-base-content/50 font-bold">Sekali Bayar</span>
                    </div>
                    <p class="text-xs text-base-content/85 leading-relaxed font-medium">
                        Biaya instalasi awal hanya sebesar <strong>Rp {{ $biaya }}</strong> (sekali bayar saat pemasangan selesai).
                    </p>
                    <div class="bg-base-200/50 border border-base-300/20 rounded-xl p-3.5 space-y-2.5">
                        <span class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest block">Kelengkapan Paket Pasang:</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-base-content/70">
                            @foreach($kelengkapanRaw as $item)
                                @if(trim($item))
                                <div class="flex items-center gap-2">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-primary shrink-0"></i>
                                    <span>{{ trim($item) }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            `,
            3: `
                <div class="space-y-3 animate-fade-in-up">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-secondary text-white font-extrabold text-[10px] tracking-wider py-2 px-3">ESTIMASI INSTALASI</span>
                        <span class="text-xs text-base-content/50 font-bold">Proses Cepat & Rapih</span>
                    </div>
                    <p class="text-xs text-base-content/85 leading-relaxed font-medium">
                        Kabel akan ditarik langsung ke rumah Anda dalam jangka waktu <strong>{{ $estimasi }}</strong> setelah pendaftaran disetujui.
                    </p>
                    <div class="bg-base-200/50 border border-base-300/20 rounded-xl p-3.5 space-y-2">
                        @foreach($langkahRaw as $index => $line)
                            @php
                                $parts = explode('|', $line, 2);
                                $title = $parts[0] ?? '';
                                $desc = $parts[1] ?? '';
                            @endphp
                            @if(trim($title))
                            <div class="flex items-start gap-2.5 text-xs text-base-content/75">
                                <div class="w-5 h-5 rounded-full bg-secondary/15 text-secondary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">{{ $index + 1 }}</div>
                                <span><strong>{{ trim($title) }}:</strong> {{ trim($desc) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            `,
            4: `
                <div class="space-y-3 animate-fade-in-up">
                    <div class="flex items-center gap-2">
                        <span class="badge badge-accent text-white font-extrabold text-[10px] tracking-wider py-2 px-3">WILAYAH CAKUPAN</span>
                        <span class="text-xs text-base-content/50 font-bold">Jambi & Sekitarnya</span>
                    </div>
                    <p class="text-xs text-base-content/85 leading-relaxed font-medium">
                        Jaringan fiber optik R-NET saat ini menjangkau wilayah-wilayah berikut:
                    </p>
                    <div class="bg-base-200/50 border border-base-300/20 rounded-xl p-3.5 space-y-2.5">
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2.5 py-1 rounded bg-primary/10 text-primary font-bold text-xs">Kota Sungai Penuh</span>
                            <span class="px-2.5 py-1 rounded bg-primary/10 text-primary font-bold text-xs">Kabupaten Kerinci</span>
                            <span class="px-2.5 py-1 rounded bg-primary/10 text-primary font-bold text-xs">Kabupaten Merangin</span>
                        </div>
                        <p class="text-[11px] text-base-content/60 leading-normal">
                            Jika daerah Anda belum masuk radius peta jangkauan, Anda bisa memilih opsi <strong>"Konsultasi dengan Admin"</strong> pada form pendaftaran untuk pengajuan perluasan area jaringan.
                        </p>
                    </div>
                </div>
            `
        };

        function selectFaq(id, btn) {
            // Remove active classes from all tabs and add border/color to the active one
            document.querySelectorAll('.faq-tab').forEach(el => {
                el.classList.remove('bg-primary/10', 'text-primary', 'border-primary/40');
                el.classList.add('border-base-300/60');
            });
            btn.classList.add('bg-primary/10', 'text-primary', 'border-primary/40');
            btn.classList.remove('border-base-300/60');

            const term = document.getElementById('faq-terminal-text');
            
            // Show typing indicator
            term.innerHTML = `
                <div class="flex items-center gap-2 text-base-content/40 font-mono text-xs animate-pulse py-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-base-content/40 animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-base-content/40 animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-base-content/40 animate-bounce" style="animation-delay: 300ms"></span>
                    <span class="ml-1 text-[11px]">Memuat jawaban...</span>
                </div>
            `;

            if (window.faqTimeout) clearTimeout(window.faqTimeout);

            window.faqTimeout = setTimeout(() => {
                term.innerHTML = faqAnswers[id];
                // Initialize Lucide icons for the dynamic content
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons({
                        attrs: {
                            class: 'lucide'
                        },
                        nameAttr: 'data-lucide'
                    });
                }
            }, 300);
        }

        // ── Peta Jangkauan Interaktif (Leaflet) ───────────────────
        let map = null;
        let mapTileLayer = null;
        const boundaries = {};

        function initMap() {
            const defaultTheme = document.documentElement.getAttribute('data-theme') || 'light';

            // Default coordinates center
            map = L.map('map', {
                center: [-2.0337714, 101.3963373],
                zoom: 11,
                zoomControl: true
            });

            // Initial Tile Layer
            const initialUrl = defaultTheme === 'dark'
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

            mapTileLayer = L.tileLayer(initialUrl, {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            // Fetch and render areas from database
            const activeAreas = @json($areaLayanan);
            const validAreas = activeAreas.filter(area => area.latitude && area.longitude);

            if (validAreas.length > 0) {
                map.setView([validAreas[0].latitude, validAreas[0].longitude], 11);
            }

            validAreas.forEach(area => {
                const lat = parseFloat(area.latitude);
                const lng = parseFloat(area.longitude);
                const radius = parseInt(area.radius) || 1000;

                // Add actual geographic boundary circle (no pin markers)
                const boundary = L.circle([lat, lng], {
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.2,
                    weight: 2,
                    dashArray: '6, 6',
                    radius: radius
                }).addTo(map);

                const popupContent = `
                    <div class="p-1 space-y-1">
                        <h4 class="font-bold text-xs text-primary">${area.nama_area}</h4>
                        <p class="text-[10px] text-base-content/70 leading-normal">Radius Layanan: ${radius} meter</p>
                        <span class="inline-block bg-success/15 text-success text-[8px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider mt-1">Aktif</span>
                    </div>
                `;

                boundary.bindPopup(popupContent);
                boundaries[area.nama_area] = boundary;
            });
        }

        function updateMapTheme(theme) {
            if (!mapTileLayer) return;
            const url = theme === 'dark'
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
            mapTileLayer.setUrl(url);
        }

        function focusArea(name) {
            if (map && boundaries[name]) {
                map.fitBounds(boundaries[name].getBounds(), { padding: [50, 50], maxZoom: 13, animate: true, duration: 1.5 });
                setTimeout(() => {
                    boundaries[name].openPopup();
                }, 1000);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof L !== 'undefined') initMap();
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

    <!-- Floating WhatsApp Action Button -->
    @php
        $waNumber = isset($company) && $company->whatsapp 
            ? preg_replace('/[^0-9]/', '', $company->whatsapp) 
            : '6281373242673';
        $waText = urlencode("Halo R-NET, saya ingin bertanya tentang layanan pasang internet...");
    @endphp
    <div class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end pointer-events-none">
        <div class="mb-2 px-3 py-1.5 bg-base-100 text-base-content border border-base-300 rounded-xl shadow-lg text-[10px] font-bold tracking-wide animate-bounce pointer-events-auto flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
            Chat Admin WhatsApp
        </div>
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" 
           class="pointer-events-auto w-14 h-14 bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-full flex items-center justify-center shadow-2xl transition-all duration-300 hover:scale-110 active:scale-95 group relative">
            <span class="absolute inset-0 rounded-full bg-[#25D366] opacity-40 animate-ping group-hover:animate-none"></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="relative z-10"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </a>
    </div>

</body>

</html>
