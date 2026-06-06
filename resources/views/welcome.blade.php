<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="R-NET - Penyedia layanan internet cepat, stabil, tanpa FUP. Nikmati koneksi unlimited dengan harga terjangkau untuk rumah dan keluarga Anda.">
    <title>R-NET - Internet Cepat & Stabil</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="font-sans bg-base-100 text-base-content antialiased">

    {{-- Modal Konfirmasi Pendaftaran Berhasil --}}
    @if (session('sukses') || session('success'))
        <div id="success-overlay"
            class="fixed inset-0 z-[9999] overflow-y-auto bg-black/50 backdrop-blur-sm animate-fade-in">

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-base-100 rounded-2xl shadow-2xl p-8 md:p-10 max-w-md w-full text-center relative border border-base-300/60"
                    style="animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;">

                    {{-- Checkmark Circle --}}
                    <div class="mx-auto w-20 h-20 bg-success/10 rounded-full flex items-center justify-center mb-6"
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
    <nav class="navbar bg-base-100/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-base-300/40">
        <div class="navbar-start">
            {{-- Mobile hamburger --}}
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden" title="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 border border-base-300/60">
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#speed-comparison">Kecepatan</a></li>
                    <li><a href="#harga">Harga</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
            {{-- Brand --}}
            <div class="flex items-center px-2">
                <a href="/">
                    <img src="/logoprimary.svg" alt="R-NET Logo" class="h-8 w-auto">
                </a>
            </div>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 gap-1 text-sm font-semibold">
                <li><a href="#fitur" class="rounded-lg hover:bg-primary/10 hover:text-primary">Fitur</a></li>
                <li><a href="#speed-comparison" class="rounded-lg hover:bg-primary/10 hover:text-primary">Kecepatan</a></li>
                <li><a href="#harga" class="rounded-lg hover:bg-primary/10 hover:text-primary">Harga</a></li>
                <li><a href="#faq" class="rounded-lg hover:bg-primary/10 hover:text-primary">FAQ</a></li>
                <li><a href="#kontak" class="rounded-lg hover:bg-primary/10 hover:text-primary">Kontak</a></li>
            </ul>
        </div>

        <div class="navbar-end gap-2 pr-2">
            {{-- Theme Toggle --}}
            <label id="theme-toggle" class="btn btn-ghost btn-circle swap swap-rotate" title="Ganti tema">
                <input type="checkbox" id="theme-checkbox" />
                <svg class="swap-off h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>
                <svg class="swap-on h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>
            </label>

            <a href="/daftar" id="btn-daftar-nav"
                class="btn btn-primary btn-sm rounded-md border-primary/50 font-semibold px-4 transition-transform active:scale-95">
                Daftar
            </a>
        </div>
    </nav>

    {{-- ==================== MARQUEE PENGUMUMAN ==================== --}}
    <div id="marquee-bar" class="bg-primary overflow-hidden h-9 flex items-center border-b border-primary/30">
        <div class="marquee-track text-white text-sm font-medium gap-16" id="marquee-content">
            @foreach ($pengumuman as $ann)
                <span class="shrink-0">{{ $ann }}</span>
            @endforeach
            @foreach ($pengumuman as $ann)
                <span class="shrink-0">{{ $ann }}</span>
            @endforeach
            @foreach ($pengumuman as $ann)
                <span class="shrink-0">{{ $ann }}</span>
            @endforeach
            @foreach ($pengumuman as $ann)
                <span class="shrink-0">{{ $ann }}</span>
            @endforeach
            @foreach ($pengumuman as $ann)
                <span class="shrink-0">{{ $ann }}</span>
            @endforeach
        </div>
    </div>

    <main>
        {{-- ==================== SECTION 1: HERO ==================== --}}
        <header class="hero min-h-[85vh] relative overflow-hidden" id="hero-section">
            <div class="hero-content text-center px-4 py-20 z-10 w-full">
                <div class="max-w-3xl mx-auto animate-slide-up">
                    {{-- Logo Hero with premium dynamic float animation --}}
                    <div class="flex justify-center mb-8 animate-float">
                        <img src="/logobasewhite.svg" alt="R-NET" class="h-20 sm:h-28 md:h-36 lg:h-44 w-auto hero-logo-light drop-shadow-md">
                        <img src="/logobaseblack.svg" alt="R-NET" class="h-20 sm:h-28 md:h-36 lg:h-44 w-auto hero-logo-dark drop-shadow-md">
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 tracking-tight">
                        Internet <span class="bg-gradient-to-r from-primary to-cyan-500 bg-clip-text text-transparent">Cepat</span> &amp;<br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-primary to-cyan-500 bg-clip-text text-transparent">Stabil</span> Tanpa Batas
                    </h1>
                    <p class="text-sm sm:text-base md:text-lg text-base-content/70 leading-relaxed mb-10 max-w-xl mx-auto">
                        R-NET menghadirkan koneksi internet berkualitas tinggi berbasis serat optik tanpa FUP,
                        unlimited kuota untuk kehidupan digital yang lebih produktif dan lancar.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="/daftar" id="btn-daftar-hero"
                            class="btn btn-primary sm:btn-lg rounded-2xl font-bold px-8 shadow-lg shadow-primary/25 hover:shadow-primary/45 transition-all duration-300 w-full sm:w-auto active:scale-95">
                            Daftar Sekarang
                        </a>
                        <a href="#harga" id="btn-pelajari"
                            class="btn btn-outline btn-primary sm:btn-lg rounded-2xl font-bold px-8 transition-all duration-300 w-full sm:w-auto active:scale-95 bg-base-100/40 backdrop-blur-sm">
                            Pilihan Paket
                        </a>
                    </div>

                    {{-- Stats Grid in a Premium Glassmorphic Card --}}
                    <div class="mt-16 glass-card rounded-2xl overflow-hidden divide-y sm:divide-y-0 sm:divide-x divide-base-300/40 max-w-md mx-auto shadow-xl flex flex-col sm:flex-row">
                        <div class="flex-1 text-center py-4 px-3">
                            <div class="text-3xl font-black bg-gradient-to-br from-primary to-cyan-500 bg-clip-text text-transparent">500+</div>
                            <div class="text-xs text-base-content/60 font-semibold mt-1">Pelanggan Aktif</div>
                        </div>
                        <div class="flex-1 text-center py-4 px-3">
                            <div class="text-3xl font-black bg-gradient-to-br from-primary to-cyan-500 bg-clip-text text-transparent">24/7</div>
                            <div class="text-xs text-base-content/60 font-semibold mt-1">Layanan Bantuan</div>
                        </div>
                        <div class="flex-1 text-center py-4 px-3">
                            <div class="text-3xl font-black bg-gradient-to-br from-primary to-cyan-500 bg-clip-text text-transparent">99.9%</div>
                            <div class="text-xs text-base-content/60 font-semibold mt-1">Uptime Jaringan</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dynamic ambient background elements -->
            <div class="absolute top-1/4 left-1/10 w-72 h-72 rounded-full bg-primary/10 blur-3xl -z-10 pointer-events-none"></div>
            <div class="absolute bottom-1/4 right-1/10 w-96 h-96 rounded-full bg-cyan-400/10 blur-3xl -z-10 pointer-events-none"></div>
        </header>

        {{-- ==================== SECTION 2: FITUR ==================== --}}
        <section id="fitur" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-16 max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-primary/20">
                    Keunggulan Kami
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Mengapa Memilih R-NET?</h2>
                <p class="text-base-content/60 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    Fitur unggulan serat optik modern yang dirancang khusus untuk memenuhi kebutuhan internet keluarga Indonesia secara maksimal.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Fitur 1 --}}
                <div class="card bg-base-100 border border-base-300/60 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="card-body items-center text-center gap-5 p-8">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/40 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-sm">
                            <i data-lucide="zap" class="w-8 h-8 text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="card-title justify-center text-lg font-bold">Cepat & Responsif</h3>
                            <p class="text-base-content/60 text-sm mt-3 leading-relaxed">
                                Jaringan serat optik gigabit murni memberikan latensi sangat rendah, ideal untuk video call, gaming, dan streaming 4K tanpa buffer.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fitur 2 --}}
                <div class="card bg-base-100 border border-base-300/60 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="card-body items-center text-center gap-5 p-8">
                        <div class="w-16 h-16 rounded-2xl bg-green-50 dark:bg-green-950/40 border border-green-100 dark:border-green-900/40 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-sm">
                            <i data-lucide="shield-check" class="w-8 h-8 text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="card-title justify-center text-lg font-bold">Aman & Terpercaya</h3>
                            <p class="text-base-content/60 text-sm mt-3 leading-relaxed">
                                Keamanan enkripsi jaringan modern yang terlindungi 24 jam penuh untuk menjamin kerahasiaan data dan aktivitas browsing keluarga Anda.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fitur 3 --}}
                <div class="card bg-base-100 border border-base-300/60 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group sm:col-span-2 lg:col-span-1">
                    <div class="card-body items-center text-center gap-5 p-8">
                        <div class="w-16 h-16 rounded-2xl bg-purple-50 dark:bg-purple-950/40 border border-purple-100 dark:border-purple-900/40 flex items-center justify-center transition-transform group-hover:scale-110 duration-300 shadow-sm">
                            <i data-lucide="sparkles" class="w-8 h-8 text-purple-500"></i>
                        </div>
                        <div>
                            <h3 class="card-title justify-center text-lg font-bold">Mudah & Tanpa FUP</h3>
                            <p class="text-base-content/60 text-sm mt-3 leading-relaxed">
                                Pendaftaran instan secara online, instalasi praktis, dan kebebasan akses tanpa batasan kuota murni (Tanpa Kebijakan FUP).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== SECTION: KECEPATAN (SPEED SIMULATOR) ==================== --}}
        <section id="speed-comparison" class="py-20 sm:py-24 px-5 sm:px-8 lg:px-16 bg-base-200/40 border-t border-b border-base-300/40">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-primary/20">
                        Visualisasi Kecepatan
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Seberapa Cepat R-NET?</h2>
                    <p class="text-base-content/60 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                        Bandingkan kecepatan transfer data R-NET secara real-time dengan alternatif teknologi internet lainnya.
                    </p>
                </div>

                <div class="bg-base-100 rounded-3xl p-6 md:p-10 border border-base-300/60 shadow-xl">
                    <!-- Speed Bars -->
                    <div class="space-y-8">
                        <!-- R-NET -->
                        <div class="space-y-2.5">
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="flex items-center gap-2 text-primary">
                                    <i data-lucide="rocket" class="w-5 h-5"></i> R-NET (Fiber Optik)
                                </span>
                                <span class="font-extrabold text-primary">100 Mbps (Stabil)</span>
                            </div>
                            <div class="w-full bg-base-200 dark:bg-base-300 h-5 rounded-full overflow-hidden border border-base-300/20">
                                <div class="bg-gradient-to-r from-primary to-cyan-500 h-full rounded-full w-full speed-bar-fill shadow-[0_0_12px_rgba(25,119,191,0.4)]" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- 4G LTE -->
                        <div class="space-y-2.5">
                            <div class="flex justify-between items-center text-sm font-semibold">
                                <span class="flex items-center gap-2 text-warning">
                                    <i data-lucide="smartphone" class="w-5 h-5"></i> Paket Data 4G Seluler
                                </span>
                                <span class="text-warning">15 Mbps (Berubah-ubah)</span>
                            </div>
                            <div class="w-full bg-base-200 dark:bg-base-300 h-5 rounded-full overflow-hidden">
                                <div class="bg-warning h-full rounded-full speed-bar-fill" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- ADSL -->
                        <div class="space-y-2.5">
                            <div class="flex justify-between items-center text-sm font-semibold text-base-content/70">
                                <span class="flex items-center gap-2">
                                    <i data-lucide="cable" class="w-5 h-5"></i> ADSL Kabel Tembaga
                                </span>
                                <span>5 Mbps (Sangat Lambat)</span>
                            </div>
                            <div class="w-full bg-base-200 dark:bg-base-300 h-5 rounded-full overflow-hidden">
                                <div class="bg-base-content/30 h-full rounded-full speed-bar-fill" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Simulator Button / Box -->
                    <div class="mt-10 border-t border-base-300/40 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="text-left w-full md:w-auto">
                            <p class="text-xs text-base-content/50 uppercase font-bold tracking-widest">Metrik Perbandingan</p>
                            <p class="text-lg font-extrabold text-base-content mt-1">Mengunduh File Berukuran 1 GB</p>
                        </div>
                        <button onclick="startDownloadSimulation()" class="btn btn-primary w-full md:w-auto font-bold rounded-2xl shadow-lg shadow-primary/20 px-8 transition-transform active:scale-95">
                            Mulai Simulasi
                        </button>
                    </div>

                    <div id="simulation-results" class="hidden mt-8 grid grid-cols-3 gap-3 md:gap-6 border-t border-base-300/40 pt-8">
                        <div class="text-center p-4 bg-base-200/50 rounded-2xl border border-base-300/50">
                            <div class="text-[10px] md:text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">R-NET Time</div>
                            <div class="text-base sm:text-lg md:text-2xl font-black text-primary" id="time-rnet">1.3 mnt</div>
                        </div>
                        <div class="text-center p-4 bg-base-200/50 rounded-2xl border border-base-300/50">
                            <div class="text-[10px] md:text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">4G LTE Time</div>
                            <div class="text-base sm:text-lg md:text-2xl font-bold text-warning" id="time-4g">9.3 mnt</div>
                        </div>
                        <div class="text-center p-4 bg-base-200/50 rounded-2xl border border-base-300/50">
                            <div class="text-[10px] md:text-xs text-base-content/50 font-bold uppercase tracking-wider mb-1">ADSL Time</div>
                            <div class="text-base sm:text-lg md:text-2xl font-bold text-base-content/60" id="time-adsl">28 mnt</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== SECTION 3: HARGA ==================== --}}
        <section id="harga" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-16 bg-base-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-primary/20">
                        Paket Langganan
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Pilih Paket Anda</h2>
                    <p class="text-base-content/60 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Pilihan kecepatan internet yang fleksibel dan terjangkau, disesuaikan dengan skala kebutuhan rumah Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto lg:items-stretch">
                    @foreach($pakets as $index => $paket)
                        @php
                            $isPopular = ($index == 1);
                        @endphp
                        <div id="card-paket-{{ $paket->id_paket }}"
                            class="card transition-all duration-300 {{ $isPopular ? 'bg-primary text-primary-content border border-primary/10 relative lg:-mt-4 lg:mb-4 premium-glow-active shadow-xl' : 'bg-base-100 border border-base-300/60 hover:border-primary/50 shadow-md hover:-translate-y-1.5' }}">

                            @if($isPopular)
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                                    <div class="badge bg-warning text-warning-content font-bold px-4 py-3 rounded-full border border-warning/30 text-[10px] tracking-widest uppercase shadow">
                                        TERPOPULER
                                    </div>
                                </div>
                            @endif

                            <div class="card-body text-center gap-5 p-8 {{ $isPopular ? 'pt-12' : '' }}">
                                <div class="w-14 h-14 rounded-2xl {{ $isPopular ? 'bg-white/15 border border-white/20' : 'bg-blue-50 border border-blue-100 dark:bg-blue-950/40 dark:border-blue-900/40' }} flex items-center justify-center mx-auto shadow-inner">
                                    <i data-lucide="home" class="w-7 h-7 {{ $isPopular ? 'text-white' : 'text-blue-500' }}"></i>
                                </div>
                                
                                <div>
                                    <h3 class="text-xl font-extrabold">{{ $paket->title_paket }}</h3>
                                </div>
                                
                                <div class="flex items-end justify-center gap-1">
                                    <span class="text-5xl font-black {{ $isPopular ? '' : 'text-primary' }}">{{ number_format($paket->harga_paket / 1000, 0) }}K</span>
                                    <span class="mb-1.5 text-xs {{ $isPopular ? 'text-white/70' : 'text-base-content/50' }} font-bold">/bulan</span>
                                </div>
                                
                                <div class="{{ $isPopular ? 'border-t border-white/20' : 'border-t border-base-300/50' }} my-2"></div>
                                
                                <ul class="text-left space-y-3 text-sm">
                                    <li class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $isPopular ? 'bg-white/15 border border-white/25' : 'border border-success/40 bg-success/10' }}">
                                            <i data-lucide="check" class="w-3.5 h-3.5 {{ $isPopular ? 'text-white' : 'text-success' }}"></i>
                                        </div>
                                        <span>Internet Cepat &amp; Stabil</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $isPopular ? 'bg-white/15 border border-white/25' : 'border border-success/40 bg-success/10' }}">
                                            <i data-lucide="check" class="w-3.5 h-3.5 {{ $isPopular ? 'text-white' : 'text-success' }}"></i>
                                        </div>
                                        <span class="font-semibold">Tanpa Batas Kuota FUP</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $isPopular ? 'bg-white/15 border border-white/25' : 'border border-success/40 bg-success/10' }}">
                                            <i data-lucide="check" class="w-3.5 h-3.5 {{ $isPopular ? 'text-white' : 'text-success' }}"></i>
                                        </div>
                                        <span>Dukungan teknisi 24 Jam</span>
                                    </li>
                                </ul>
                                
                                <div class="card-actions justify-center mt-auto pt-6">
                                    <a href="/daftar?paket={{ $paket->id_paket }}"
                                        class="btn rounded-xl w-full font-bold transition-all duration-300 {{ $isPopular ? 'bg-white text-primary hover:bg-base-100 border border-white/60 hover:border-white' : 'btn-outline btn-primary' }} active:scale-95 shadow">
                                        Pilih Paket
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="flex items-center justify-center gap-2 bg-yellow-400 text-amber-950 px-5 py-2 rounded-full text-xs sm:text-sm font-bold mx-auto w-fit border border-yellow-500 mt-12 shadow-md">
                    <i data-lucide="info" class="w-4 h-4"></i> BIAYA PEMASANGAN HANYA 350K
                </p>
            </div>
        </section>

        {{-- ==================== SECTION: TESTIMONIALS ==================== --}}
        <section id="testimoni" class="py-20 sm:py-24 bg-base-200/30 border-t border-b border-base-300/40">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-16">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-primary/20">
                        Testimoni Pelanggan
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Apa Kata Mereka?</h2>
                    <p class="text-base-content/60 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                        Ulasan tulus dari pelanggan setia kami yang telah menikmati koneksi serat optik berkualitas R-NET.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Testi 1 -->
                    <div class="card bg-base-100 border border-base-300/50 shadow-sm p-6 md:p-8 space-y-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-0.5 text-warning">
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                        </div>
                        <p class="text-sm text-base-content/80 italic leading-relaxed">
                            "R-NET mantap sekali. Buat WFH seharian dan anak-anak belajar online lancar jaya. Harganya sangat merakyat untuk kualitas fiber optik."
                        </p>
                        <div class="flex items-center gap-3 pt-2">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                BS
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-base-content">Budi Santoso</h4>
                                <p class="text-[10px] text-base-content/50 font-medium">Pelanggan Rumah Tangga</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testi 2 -->
                    <div class="card bg-base-100 border border-base-300/50 shadow-sm p-6 md:p-8 space-y-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-0.5 text-warning">
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                        </div>
                        <p class="text-sm text-base-content/80 italic leading-relaxed">
                            "Sangat merekomendasikan paket populer 30 Mbps. Unlimited murni tanpa batas FUP, download game besar jadi tidak khawatir lagi."
                        </p>
                        <div class="flex items-center gap-3 pt-2">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                HP
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-base-content">Hendra Pratama</h4>
                                <p class="text-[10px] text-base-content/50 font-medium">Gamer &amp; Konten Kreator</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testi 3 -->
                    <div class="card bg-base-100 border border-base-300/50 shadow-sm p-6 md:p-8 space-y-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-0.5 text-warning">
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-warning text-warning"></i>
                        </div>
                        <p class="text-sm text-base-content/80 italic leading-relaxed">
                            "Pelayanan teknisinya super cepat. Ada kendala WiFi langsung dibantu tangani hari itu juga. Internetnya pun stabil walau cuaca buruk."
                        </p>
                        <div class="flex items-center gap-3 pt-2">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                YS
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-base-content">Yanti Sartika</h4>
                                <p class="text-[10px] text-base-content/50 font-medium">Pemilik UMKM Toko Kelontong</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== SECTION 4: FAQ ==================== --}}
        <section id="faq" class="py-20 sm:py-28 px-5 sm:px-8 lg:px-16 max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-primary/20">
                    Tanya Jawab
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Pertanyaan Umum (FAQ)</h2>
                <p class="text-base-content/60 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                    Jawaban ringkas dan cepat untuk segala kekhawatiran Anda sebelum berlangganan internet R-NET.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="collapse collapse-plus bg-base-200/40 border border-base-300/60 rounded-2xl faq-accordion-item">
                    <input type="checkbox" name="faq-accordion" aria-label="Faq collapse 1" /> 
                    <div class="collapse-title text-base font-bold text-base-content pr-12 py-4">
                        Apakah internet R-NET benar-benar tanpa batas kuota FUP?
                    </div>
                    <div class="collapse-content text-sm text-base-content/70 pb-6 pr-6 leading-relaxed">
                        <p>Ya, benar! R-NET menyediakan internet rakyat murni tanpa batasan kuota (No FUP). Anda bisa melakukan download, upload, video streaming, dan bermain game sepuasnya tanpa khawatir batas kecepatan berkurang.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="collapse collapse-plus bg-base-200/40 border border-base-300/60 rounded-2xl faq-accordion-item">
                    <input type="checkbox" name="faq-accordion" aria-label="Faq collapse 2" /> 
                    <div class="collapse-title text-base font-bold text-base-content pr-12 py-4">
                        Berapa total biaya pasang baru?
                    </div>
                    <div class="collapse-content text-sm text-base-content/70 pb-6 pr-6 leading-relaxed">
                        <p>Biaya pemasangan baru (instalasi baru) adalah Rp 350.000 sekali bayar. Biaya ini sudah mencakup penarikan kabel serat optik ke rumah Anda, peminjaman perangkat modem WiFi (ONT) modern, dan setup konfigurasi.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="collapse collapse-plus bg-base-200/40 border border-base-300/60 rounded-2xl faq-accordion-item">
                    <input type="checkbox" name="faq-accordion" aria-label="Faq collapse 3" /> 
                    <div class="collapse-title text-base font-bold text-base-content pr-12 py-4">
                        Berapa lama proses verifikasi dan instalasi?
                    </div>
                    <div class="collapse-content text-sm text-base-content/70 pb-6 pr-6 leading-relaxed">
                        <p>Setelah formulir pendaftaran Anda dikirimkan, tim verifikasi kami akan meninjau titik koordinat lokasi rumah Anda. Proses penarikan kabel dan instalasi WiFi biasanya diselesaikan dalam waktu 1 hingga 3 hari kerja.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="collapse collapse-plus bg-base-200/40 border border-base-300/60 rounded-2xl faq-accordion-item">
                    <input type="checkbox" name="faq-accordion" aria-label="Faq collapse 4" /> 
                    <div class="collapse-title text-base font-bold text-base-content pr-12 py-4">
                        Bagaimana jika wilayah saya belum ada di pilihan jangkauan?
                    </div>
                    <div class="collapse-content text-sm text-base-content/70 pb-6 pr-6 leading-relaxed">
                        <p>Jika wilayah Anda belum terjangkau dalam daftar jangkauan utama, Anda dapat tetap mendaftar dan memilih opsi jangkauan "Konsultasi dengan Admin". Kami akan mencatat lokasi Anda untuk prioritas ekspansi area berikutnya.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- ==================== FOOTER / KONTAK ==================== --}}
    <footer id="kontak" class="bg-neutral text-neutral-content border-t border-neutral-focus">
        <div class="container mx-auto px-5 sm:px-8 lg:px-16 py-12">
            {{-- Footer Row Utama: Logo + Nav --}}
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-12">

                {{-- Kolom Kiri: Logo + Deskripsi --}}
                <aside class="max-w-xs space-y-4">
                    <div>
                        <img src="/logowhite.svg" alt="R-NET" class="h-10 w-auto">
                    </div>
                    <p class="text-neutral-content/70 text-sm leading-relaxed">
                        Memberikan solusi layanan internet serat optik rakyat terbaik di daerah Anda.<br>
                        Hak Cipta &copy; {{ date('Y') }} R-NET — Seluruh hak cipta dilindungi.
                    </p>
                </aside>

                {{-- Kolom Kanan: Nav Links --}}
                <div class="grid grid-cols-2 sm:flex sm:flex-row gap-8 lg:gap-16">
                    <nav class="flex flex-col gap-2.5">
                        <h6 class="footer-title opacity-90 text-white font-bold tracking-wider">Layanan</h6>
                        <a href="#fitur" class="link link-hover text-neutral-content/75 text-sm">Fitur Kami</a>
                        <a href="#harga" class="link link-hover text-neutral-content/75 text-sm">Paket Harga</a>
                        <a href="/daftar" class="link link-hover text-neutral-content/75 text-sm">Daftar Pelanggan</a>
                    </nav>
                    <nav class="flex flex-col gap-2.5">
                        <h6 class="footer-title opacity-90 text-white font-bold tracking-wider">Perusahaan</h6>
                        <a href="#" class="link link-hover text-neutral-content/75 text-sm">Tentang Kami</a>
                        <a href="https://wa.me/6281373242673" id="link-whatsapp-footer" target="_blank"
                            rel="noopener noreferrer" class="link link-hover text-neutral-content/75 text-sm">Kontak</a>
                    </nav>
                    <nav class="flex flex-col gap-2.5 col-span-2 sm:col-span-1">
                        <h6 class="footer-title opacity-90 text-white font-bold tracking-wider">Legal</h6>
                        <a href="#" class="link link-hover text-neutral-content/75 text-sm">Syarat Ketentuan</a>
                        <a href="#" class="link link-hover text-neutral-content/75 text-sm">Kebijakan Privasi</a>
                        <a href="#" class="link link-hover text-neutral-content/75 text-sm">Kebijakan Cookie</a>
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

        // Set hero background image berdasarkan theme aktif
        function updateHeroBg(theme) {
            const hero = document.getElementById('hero-section');
            if (!hero) return;
            hero.style.backgroundImage = theme === 'dark'
                ? "url('/backgroundherodarkmode.webp')"
                : "url('/backgroundherolightmode.webp')";
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
        });

        // ── Smooth scroll (native CSS preferred, JS fallback) ────
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const targetId = a.getAttribute('href');
                if (targetId === '#') return;
                e.preventDefault();
                const el = document.querySelector(targetId);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // ── Newsletter subscribe button (safety check) ───────────────────────────
        const btnBerlangganan = document.getElementById('btn-berlangganan');
        if (btnBerlangganan) {
            btnBerlangganan.addEventListener('click', () => {
                const emailInput = document.getElementById('input-email-newsletter');
                const email = emailInput.value.trim();
                if (!email || !email.includes('@')) {
                    emailInput.classList.add('input-error');
                    emailInput.focus();
                    return;
                }
                emailInput.classList.remove('input-error');
                emailInput.value = '';
                // Show a simple toast/alert
                const toast = document.createElement('div');
                toast.className = 'toast toast-top toast-center z-[9999]';
                toast.innerHTML = `<div class="alert alert-success text-sm font-semibold"><span>✅ Terima kasih! Anda telah berlangganan.</span></div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3500);
            });
        }

        // ── Speed Comparison Simulation & Intersection Observer ────────────────────────
        function startDownloadSimulation() {
            const bars = document.querySelectorAll('#speed-comparison .speed-bar-fill');
            if (bars.length >= 3) {
                bars[0].style.width = '100%';
                bars[1].style.width = '15%';
                bars[2].style.width = '5%';
            }

            const results = document.getElementById('simulation-results');
            if (results) {
                results.classList.remove('hidden');
                results.classList.add('animate-fade-in');
            }
        }

        // Trigger speedbars automatically when scrolled into view
        const speedObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bars = document.querySelectorAll('#speed-comparison .speed-bar-fill');
                    if (bars.length >= 3 && bars[0].style.width === '0%') {
                        bars[0].style.width = '100%';
                        bars[1].style.width = '15%';
                        bars[2].style.width = '5%';
                    }
                }
            });
        }, { threshold: 0.15 });

        const speedSection = document.getElementById('speed-comparison');
        if (speedSection) {
            speedObserver.observe(speedSection);
        }

        // ── Init Lucide Icons ──────────────────────────────────────────────
        lucide.createIcons();
    </script>
</body>

</html>
