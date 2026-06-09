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
                    <img src="/logoprimary.svg" alt="R-NET Logo" class="h-7 w-auto">
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
                    <a href="#cek-status"
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
                        <li><a href="#cek-status">Cek Status</a></li>
                        <li><a href="#terminal-faq">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

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

    <main class="max-w-7xl mx-auto px-1 py-8 space-y-24">

        {{-- ==================== SECTION 1: HERO ==================== --}}
        <header id="hero-section"
            class="grid lg:grid-cols-12 gap-12 items-center py-12 px-6 md:px-12 rounded-3xl border border-base-300/20 shadow-xl min-h-[70vh]">
            <!-- Left Info column -->
            <div class="lg:col-span-7 space-y-8 text-left animate-slide-up">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="wifi" class="w-3.5 h-3.5"></i>Internet Cepat & Terjangkau
                </div>

                <h1 class="text-4xl sm:text-6xl font-black leading-tight tracking-tight text-base-content">
                    Koneksi Tanpa Batas.<br>
                    <span
                        class="bg-gradient-to-r from-primary via-cyan-500 to-blue-500 bg-clip-text text-transparent">Stabil
                        dan Cepat</span>
                </h1>

                <p class="text-sm sm:text-base text-base-content/70 leading-relaxed max-w-xl">
                    R-NET adalah penyedia internet kabel untuk rumah tangga, UMKM, dan komunitas. Kami
                    merancang layanan tanpa batasan FUP agar internet cepat merata di seluruh kalangan masyarakat.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <a href="/daftar"
                        class="btn btn-primary btn-lg rounded-2xl font-bold px-8 shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all text-sm">
                        Daftar Sekarang
                    </a>
                    <a href="#harga"
                        class="btn btn-outline btn-primary btn-lg rounded-2xl font-bold px-8 hover:scale-105 active:scale-95 transition-all text-sm">
                        Lihat Paket Langganan
                    </a>
                </div>

                <!-- Small Trust Indicator -->
                <div class="flex items-center gap-4 pt-6 border-t border-base-300/30">
                    <div class="flex -space-x-3">
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
                    <p class="text-xs font-semibold text-base-content/60">Didukung penuh oleh 500+ pelanggan aktif
                        daerah</p>
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
                    @endphp
                    <div id="card-paket-{{ $paket->id_paket }}"
                        class="glass-card rounded-3xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between {{ $isPopular ? 'border-primary border-2 premium-glow-active' : 'border border-base-300/60' }}">

                        <div class="p-6 md:p-8 space-y-6 flex-1 flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-primary uppercase tracking-widest">Jaringan
                                        FTTH</span>
                                    @if($isPopular)
                                        <span
                                            class="badge badge-warning text-[10px] font-black uppercase tracking-wider py-2">Terpopuler</span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-extrabold text-base-content">{{ $paket->title_paket }}</h3>
                            </div>

                            <div class="flex items-end justify-start gap-1 py-4">
                                <span
                                    class="text-5xl font-black text-base-content">{{ number_format($paket->harga_paket / 1000, 0) }}K</span>
                                <span class="text-xs text-base-content/50 font-bold mb-1.5">/bulan</span>
                            </div>

                            <div class="border-t border-base-300/40 my-1"></div>

                            <ul class="space-y-3.5 text-xs text-base-content/85 font-medium flex-1 pt-2">
                                <li class="flex items-center gap-3">
                                    <span
                                        class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </span>
                                    <span>Kuota 100% Unlimited Murni</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span
                                        class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </span>
                                    <span>Bebas Lag &amp; Throttling FUP</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span
                                        class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </span>
                                    <span>Modem WiFi ONT Dipinjamkan Gratis</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Button Card -->
                        <div class="p-6 bg-base-200/40 border-t border-base-300/40">
                            <a href="/daftar?paket={{ $paket->id_paket }}"
                                class="btn w-full rounded-xl font-bold text-xs active:scale-95 transition-transform {{ $isPopular ? 'btn-primary shadow-lg shadow-primary/20' : 'btn-outline btn-primary' }}">
                                PILIH PAKET
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <p
                class="flex items-center justify-center gap-2 bg-yellow-400 text-amber-950 px-5 py-2 rounded-full text-xs font-bold mx-auto w-fit border border-yellow-500 shadow-md">
                <i data-lucide="info" class="w-4 h-4"></i> BIAYA PENARIKAN KABEL &amp; INSTALASI MODEM HANYA 350K
            </p>
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Map display area (8/12 width) -->
                <div
                    class="lg:col-span-8 glass-card p-4 rounded-3xl border border-base-300/30 shadow-sm overflow-hidden min-h-[400px] relative">
                    <div id="map" class="w-full h-full min-h-[380px] rounded-2xl z-10"></div>
                </div>

                <!-- Info and active area list (4/12 width) -->
                <div
                    class="lg:col-span-4 glass-card p-8 rounded-3xl border border-base-300/30 flex flex-col justify-between shadow-sm">
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Daftar
                                Wilayah</span>
                            <h3 class="text-lg font-bold text-base-content tracking-tight">Area yang Didukung</h3>
                            <p class="text-xs text-base-content/60 leading-relaxed">Data wilayah aktif diambil langsung
                                secara real-time dari database layanan kami.</p>
                        </div>

                        <!-- Dynamic list of areas from database -->
                        <div class="space-y-3 max-h-[220px] overflow-y-auto pr-1">
                            @forelse($areaLayanan as $area)
                                <button onclick="focusArea('{{ $area->nama_area }}')"
                                    class="w-full text-left p-3.5 rounded-xl border border-base-300/20 hover:border-primary/40 bg-base-200/20 hover:bg-primary/5 transition-all duration-300 flex items-center justify-between group">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-2 h-2 rounded-full bg-success group-hover:scale-125 transition-transform">
                                        </div>
                                        <span class="text-xs font-bold text-base-content">{{ $area->nama_area }}</span>
                                    </div>
                                    <i data-lucide="chevron-right"
                                        class="w-4 h-4 text-base-content/30 group-hover:text-primary transition-colors"></i>
                                </button>
                            @empty
                                <div class="text-center py-6 text-xs text-base-content/40">
                                    Belum ada area layanan aktif terdaftar.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Bottom Info Card -->
                    <div class="bg-primary/5 border border-primary/10 rounded-2xl p-4 mt-6">
                        <div class="flex gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-primary shrink-0"></i>
                            <div class="space-y-1">
                                <h4 class="text-xs font-bold text-base-content">Ajukan Wilayah Baru?</h4>
                                <p class="text-[10px] text-base-content/60 leading-relaxed">Wilayah Anda belum
                                    terjangkau? Kirim pengajuan ekspansi jaringan saat melakukan pendaftaran.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- ==================== BENTO INTERACTIVE DASHBOARD ==================== --}}
        <section class="space-y-10">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="sliders" class="w-3.5 h-3.5"></i> Panel Kontrol
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Konsol Jaringan Interaktif</h2>
                <p class="text-sm text-base-content/60 mt-2">Pantau latensi, simulasikan bandwidth, dan kalkulasikan
                    skalabilitas infrastruktur R-NET.</p>
            </div>

            <!-- The Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

                <!-- Card 2: Interactive Cost Calculator (12/12 width) -->
                <div id="kalkulator"
                    class="md:col-span-12 glass-card p-8 rounded-3xl border border-base-300/30 flex flex-col justify-between shadow-sm">
                    <div class="space-y-1 mb-6">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Kalkulator
                            Interaktif</span>
                        <h3 class="text-lg font-bold text-base-content tracking-tight">Kalkulator Kebutuhan &
                            Rekomendasi Paket</h3>
                        <p class="text-xs text-base-content/60 leading-relaxed">Sesuaikan jumlah perangkat aktif untuk
                            menemukan rekomendasi paket yang paling efisien.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <!-- Left Side: Range slider input -->
                        <div class="space-y-6">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-xs font-bold text-base-content">
                                    <span>Jumlah Perangkat aktif secara bersamaan</span>
                                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-lg text-xs font-bold"
                                        id="calc-devices-val">5</span>
                                </div>
                                <input type="range" min="1" max="20" value="5" class="range range-primary range-sm"
                                    id="calc-devices" oninput="updateCalc()" />
                                <div class="flex justify-between text-[9px] font-bold text-base-content/30">
                                    <span>1 Perangkat</span>
                                    <span>20 Perangkat</span>
                                </div>
                            </div>

                            <div class="text-xs text-base-content/60 leading-relaxed border-l-2 border-primary/30 pl-3">
                                <p>Rekomendasi dihitung berdasarkan estimasi bandwidth yang dibutuhkan setiap perangkat
                                    untuk aktivitas standar seperti streaming HD, telekonferensi, dan browsing harian.
                                </p>
                            </div>
                        </div>

                        <!-- Right Side: Result Display Box (Enterprise Invoice Card) -->
                        <div class="flex flex-col gap-4">
                            <div class="bg-base-200/50 border border-base-300/20 rounded-2xl p-5 space-y-4">
                                <div class="flex justify-between items-center text-xs border-b border-base-300/10 pb-3">
                                    <span class="font-medium text-base-content/60">Paket Rekomendasi:</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        <span class="font-extrabold text-primary" id="calc-rec-name">Paket
                                            Populer</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs border-b border-base-300/10 pb-3">
                                    <span class="font-medium text-base-content/60">Estimasi Bandwidth:</span>
                                    <span class="font-extrabold text-base-content" id="calc-rec-speed">30 Mbps</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-medium text-base-content/60">Estimasi Biaya Harian:</span>
                                    <span class="font-extrabold text-base-content" id="calc-rec-cost">Rp 1.666 / hari /
                                        perangkat</span>
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
                    class="md:col-span-8 glass-card p-8 rounded-3xl border border-base-300/30 flex flex-col md:flex-row gap-8 items-stretch shadow-sm">
                    <div class="flex flex-col justify-between md:w-1/2 space-y-6">
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Visualisasi
                                Aliran Data</span>
                            <h3 class="text-lg font-bold text-base-content tracking-tight">Kestabilan vs Batas FUP</h3>
                            <p class="text-xs text-base-content/60 leading-relaxed">
                                Jaringan seluler membatasi kecepatan secara drastis setelah kuota habis.
                                Jalur internet R-NET dirancang tanpa batasan FUP, menjaga data tetap mengalir lancar.
                            </p>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 shrink-0"></span>
                                <span class="font-semibold text-base-content/80 text-xs">R-NET (Kecepatan
                                    Konstan)</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-error shrink-0"></span>
                                <span class="font-semibold text-base-content/60 text-xs">Internet Seluler / FUP
                                    Throttled</span>
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
                                <svg class="w-full h-2" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0" y1="4" x2="100%" y2="4" stroke="#06b6d4" stroke-width="3"
                                        stroke-dasharray="12, 16" class="animate-flow-fast" />
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
                    class="md:col-span-4 glass-card p-8 rounded-3xl border border-base-300/30 flex flex-col justify-between shadow-sm">
                    <div class="space-y-1">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-primary">Pemantauan</span>
                        <h3 class="text-lg font-bold text-base-content tracking-tight">Status Latensi</h3>
                        <p class="text-xs text-base-content/60">Pengukuran ping ke server lokal secara langsung.</p>
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


        {{-- ==================== SECTION: CEK STATUS INSTALASI ==================== --}}
        <section id="cek-status" class="space-y-10 py-10 max-w-4xl mx-auto scroll-mt-20">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i> Pelacakan Pemasangan
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Cek Status Instalasi</h2>
                <p class="text-sm text-base-content/60 mt-2">Masukkan 5-karakter ID Pendaftaran Anda untuk memantau proses instalasi WiFi R-NET secara real-time.</p>
            </div>

            <div class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/30 shadow-lg space-y-6">
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
                        <a href="https://wa.me/6281373242673?text=Halo%20Admin%20R-NET,%20saya%20ingin%20bertanya%20mengenai%20status%20pendaftaran%20saya%20dengan%20ID%20" 
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
        </section>

        {{-- ==================== SECTION: DYNAMIC TERMINAL FAQ ==================== --}}
        <section id="terminal-faq" class="space-y-10 py-10 max-w-4xl mx-auto">
            <div class="text-center max-w-xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    <i data-lucide="help-circle" class="w-3.5 h-3.5"></i> FAQ Terminal
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Konsol Tanya Jawab</h2>
                <p class="text-sm text-base-content/60 mt-2">Gunakan command line interaktif di bawah untuk meninjau
                    informasi teknis R-NET.</p>
            </div>

            <!-- High-Tech Interactive Terminal FAQ Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                <!-- Left: Interactive Commands List -->
                <div class="md:col-span-5 flex flex-col justify-start gap-3">
                    <button onclick="selectFaq(1, this)"
                        class="faq-tab tab-active btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --check-fup
                    </button>
                    <button onclick="selectFaq(2, this)"
                        class="faq-tab btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --setup-fee
                    </button>
                    <button onclick="selectFaq(3, this)"
                        class="faq-tab btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --deploy-timeline
                    </button>
                    <button onclick="selectFaq(4, this)"
                        class="faq-tab btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --coverage-query
                    </button>
                </div>

                <!-- Right: Simulated Unix Terminal -->
                <div
                    class="md:col-span-7 bg-[#050811] text-emerald-400 p-5 rounded-3xl border border-base-300/30 shadow-2xl relative overflow-hidden min-h-[200px] flex flex-col justify-between">
                    <!-- Terminal Top Dots -->
                    <div class="flex items-center gap-1.5 pb-3 border-b border-emerald-500/20 mb-3 text-emerald-500/40">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500/60"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/60"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500/60"></span>
                        <span
                            class="text-[9px] font-bold uppercase tracking-wider ml-2 font-mono">rnet-terminal-console</span>
                    </div>

                    <!-- Terminal Output content -->
                    <div class="flex-1 terminal-window font-mono text-xs leading-relaxed whitespace-pre-wrap select-all pr-4 scrollbar-thin"
                        id="faq-terminal-text">
                        > rnet --check-fup
                        [STATUS] UNLIMITED MURNI ACTIVE
                        [INFO] R-NET berkomitmen menyediakan layanan internet tanpa FUP (Fair Usage Policy). Tidak ada
                        batasan kuota, tidak ada penurunan kecepatan secara tiba-tiba di akhir bulan. Anda bebas
                        mengunduh dan streaming sepuasnya.
                    </div>

                    <!-- Blinking Cursor -->
                    <div
                        class="flex items-center mt-3 pt-2 border-t border-emerald-500/20 text-emerald-500/40 font-mono text-[10px]">
                        <span>visitor@rnet:~# <span class="animate-pulse">_</span></span>
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
                    <img src="/logoprimary.svg" alt="R-NET" class="h-8 w-auto">
                    <p class="text-base-content/60 text-xs leading-relaxed">
                        Penyedia layanan internet rakyat terpercaya. Menghadirkan koneksi handal tanpa kuota
                        FUP untuk kedaulatan digital bersama.<br><br>
                        Hak Cipta &copy; {{ date('Y') }} R-NET — Seluruh hak cipta dilindungi.
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
                        <a href="#" class="link link-hover text-base-content/75">Tentang R-NET</a>
                        <a href="https://wa.me/6281373242673" target="_blank" rel="noopener noreferrer"
                            class="link link-hover text-base-content/75">Hubungi Kami</a>
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

        const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
        html.setAttribute('data-theme', savedTheme);
        checkbox.checked = savedTheme === 'dark';
        updateHeroBg(savedTheme);

        checkbox.addEventListener('change', () => {
            const t = checkbox.checked ? 'dark' : 'light';
            html.setAttribute('data-theme', t);
            localStorage.setItem(THEME_KEY, t);
            updateHeroBg(t);
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

        // ── Cost Calculator widget ───────────────────────────────
        function updateCalc() {
            const devices = parseInt(document.getElementById('calc-devices').value);
            const deviceVal = document.getElementById('calc-devices-val');
            const recName = document.getElementById('calc-rec-name');
            const recCost = document.getElementById('calc-rec-cost');
            const recSpeed = document.getElementById('calc-rec-speed');

            deviceVal.textContent = devices;

            let recommended = {};
            if (devices <= 3) {
                recommended = { name: 'Paket Hemat', cost: 150000, speed: '10 Mbps' };
            } else if (devices <= 8) {
                recommended = { name: 'Paket Populer', cost: 250000, speed: '30 Mbps' };
            } else {
                recommended = { name: 'Paket Premium', cost: 400000, speed: '100 Mbps' };
            }

            recName.textContent = recommended.name;
            recSpeed.textContent = recommended.speed;

            // Calculate daily cost per device: (Monthly price / 30 days) / number of devices
            const dailyCostPerDevice = Math.round((recommended.cost / 30) / devices);
            recCost.textContent = `Rp ${dailyCostPerDevice.toLocaleString('id-ID')} / hari / perangkat`;
        }

        // Initialize calculator values
        updateCalc();

        // ── Interactive FAQ Terminal widget ──────────────────────
        const faqAnswers = {
            1: "> rnet --check-fup\n\n[STATUS] UNLIMITED MURNI ACTIVE\n[INFO] R-NET berkomitmen menyediakan layanan internet tanpa FUP (Fair Usage Policy). Tidak ada batasan kuota, tidak ada penurunan kecepatan secara tiba-tiba di akhir bulan. Anda bebas mengunduh dan streaming sepuasnya.",
            2: "> rnet --setup-fee\n\n[INSTALLATION] ACTIVE\n[COST] Rp 350.000 (Sekali bayar)\n[INCLUDES]\n - Kabel FTTH Mandiri\n - Perangkat ONT Dual-Band WiFi Router\n - Setup konfigurasi & aktivasi jaringan siap pakai",
            3: "> rnet --deploy-timeline\n\n[ESTIMATE] 1-3 Hari Kerja\n[DETAILS] Setelah pengisian form pendaftaran berhasil, tim lapangan kami akan melakukan survey area dan menjadwalkan instalasi perangkat WiFi ke rumah Anda secara cepat.",
            4: "> rnet --coverage-query\n\n[COVERAGE] KOTA SUNGAI PENUH, KABUPATEN KERINCI, KABUPATEN MERANGIN\n[NOTE] Jika wilayah Anda belum terdaftar, Anda dapat memilih opsi 'Konsultasi dengan Admin' pada form pendaftaran untuk pengajuan ekspansi jaringan."
        };

        function selectFaq(id, btn) {
            // Remove active classes
            document.querySelectorAll('.faq-tab').forEach(el => el.classList.remove('bg-primary/10', 'text-primary'));
            btn.classList.add('bg-primary/10', 'text-primary');

            const term = document.getElementById('faq-terminal-text');
            term.textContent = '';

            const text = faqAnswers[id];
            let index = 0;

            if (window.faqTypeInterval) clearInterval(window.faqTypeInterval);

            window.faqTypeInterval = setInterval(() => {
                if (index < text.length) {
                    term.textContent += text[index];
                    index++;
                } else {
                    clearInterval(window.faqTypeInterval);
                }
            }, 8);
        }

        // ── Peta Jangkauan Interaktif (Leaflet) ───────────────────
        let map = null;
        let mapTileLayer = null;
        const markers = {};

        function getCoords(name) {
            const cleanName = name.toLowerCase();
            if (cleanName.includes('sungai penuh')) {
                return { lat: -2.0620, lng: 101.3780, radius: 8000, desc: 'Pusat operasional utama R-NET dengan infrastruktur kabel mandiri.' };
            } else if (cleanName.includes('kerinci')) {
                return { lat: -1.9740, lng: 101.4050, radius: 25000, desc: 'Jaringan meluas ke area perumahan agrowisata dan pedesaan.' };
            } else if (cleanName.includes('merangin') || cleanName.includes('bangko')) {
                return { lat: -2.1550, lng: 102.1280, radius: 20000, desc: 'Ekspansi jaringan berkecepatan tinggi untuk mendukung operasional UMKM lokal setempat.' };
            }
            // Fallback default coordinate around Jambi
            return { lat: -1.6130, lng: 103.6130, radius: 10000, desc: 'Wilayah layanan baru aktif.' };
        }

        const boundaries = {};

        function initMap() {
            const defaultTheme = document.documentElement.getAttribute('data-theme') || 'light';

            // Jambi center coordinates
            map = L.map('map', {
                center: [-2.0620, 101.3780],
                zoom: 8,
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

            activeAreas.forEach(area => {
                const coords = getCoords(area.nama_area);

                // Add actual geographic boundary circle
                const boundary = L.circle([coords.lat, coords.lng], {
                    color: '#1977BF',
                    fillColor: '#06b6d4',
                    fillOpacity: 0.18,
                    weight: 2,
                    dashArray: '6, 6',
                    radius: coords.radius
                }).addTo(map);

                // Add center pin marker
                const marker = L.circleMarker([coords.lat, coords.lng], {
                    color: '#1977BF',
                    fillColor: '#ffffff',
                    fillOpacity: 1,
                    weight: 3,
                    radius: 7
                }).addTo(map);

                const popupContent = `
                    <div class="p-1 space-y-1">
                        <h4 class="font-bold text-xs text-primary">${area.nama_area}</h4>
                        <p class="text-[10px] text-base-content/70 leading-normal">${coords.desc}</p>
                        <span class="inline-block bg-success/15 text-success text-[8px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider mt-1">Aktif</span>
                    </div>
                `;

                boundary.bindPopup(popupContent);
                marker.bindPopup(popupContent);

                markers[area.nama_area] = marker;
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
                // Smoothly zoom/fit to the boundary circle's geographic bounds
                map.fitBounds(boundaries[name].getBounds(), { padding: [50, 50], maxZoom: 11, animate: true, duration: 1.5 });
                setTimeout(() => {
                    boundaries[name].openPopup();
                }, 1000);
            }
        }

        // Initialize Map + Lucide Icons after DOM ready (scripts are deferred)
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof L !== 'undefined') initMap();
            if (typeof lucide !== 'undefined') lucide.createIcons();
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
                waBtn.href = `https://wa.me/6281373242673?text=Halo%20Admin%20R-NET,%20saya%20ingin%20bertanya%20mengenai%20status%20pendaftaran%20saya%20dengan%20ID%20${data.id_pendaftaran}`;
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
