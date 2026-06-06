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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
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
    <div class="px-4 py-4 sticky top-0 z-50 max-w-7xl mx-auto w-full">
        <nav class="navbar bg-base-100/70 backdrop-blur-xl shadow-lg border border-base-300/30 rounded-2xl px-4 md:px-6">
            <div class="navbar-start">
                {{-- Mobile Hamburger --}}
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden" title="Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-xl bg-base-100/95 border border-base-300/40 rounded-box w-52">
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#speedtest">Speed Test</a></li>
                        <li><a href="#kalkulator">Kalkulator</a></li>
                        <li><a href="#harga">Paket</a></li>
                        <li><a href="#terminal-faq">FAQ</a></li>
                    </ul>
                </div>
                {{-- Brand --}}
                <a href="/" class="flex items-center gap-2 pl-2">
                    <img src="/logoprimary.svg" alt="R-NET Logo" class="h-8 w-auto">
                </a>
            </div>

            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1 gap-1 text-[13px] font-bold uppercase tracking-wider text-base-content/75">
                    <li><a href="#fitur" class="rounded-xl hover:bg-primary/10 hover:text-primary px-4">Fitur</a></li>
                    <li><a href="#speedtest" class="rounded-xl hover:bg-primary/10 hover:text-primary px-4">Speed Test</a></li>
                    <li><a href="#kalkulator" class="rounded-xl hover:bg-primary/10 hover:text-primary px-4">Kalkulator</a></li>
                    <li><a href="#harga" class="rounded-xl hover:bg-primary/10 hover:text-primary px-4">Paket</a></li>
                    <li><a href="#terminal-faq" class="rounded-xl hover:bg-primary/10 hover:text-primary px-4">FAQ</a></li>
                </ul>
            </div>

            <div class="navbar-end gap-3 pr-2">
                {{-- Theme Switcher --}}
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
                    class="btn btn-primary btn-sm rounded-xl font-bold px-5 hover:scale-105 active:scale-95 transition-all">
                    Daftar
                </a>
            </div>
        </nav>
    </div>

    {{-- ==================== MARQUEE PENGUMUMAN ==================== --}}
    <div id="marquee-bar" class="bg-primary/10 border-b border-primary/20 overflow-hidden h-9 flex items-center">
        <div class="marquee-track text-primary text-xs font-bold gap-16" id="marquee-content">
            @foreach ($pengumuman as $ann)
                <span class="shrink-0 flex items-center gap-2">⚡ {{ $ann }}</span>
            @endforeach
            @foreach ($pengumuman as $ann)
                <span class="shrink-0 flex items-center gap-2">⚡ {{ $ann }}</span>
            @endforeach
            @foreach ($pengumuman as $ann)
                <span class="shrink-0 flex items-center gap-2">⚡ {{ $ann }}</span>
            @endforeach
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-8 space-y-24">

        {{-- ==================== SECTION 1: HERO ==================== --}}
        <header class="grid lg:grid-cols-12 gap-12 items-center py-8 min-h-[70vh]">
            <!-- Left Info column -->
            <div class="lg:col-span-7 space-y-8 text-left animate-slide-up">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    📶 Fiber Optik Murni 100%
                </div>
                
                <h1 class="text-4xl sm:text-6xl font-black leading-tight tracking-tight text-base-content">
                    Koneksi Tanpa Batas.<br>
                    <span class="bg-gradient-to-r from-primary via-cyan-500 to-blue-500 bg-clip-text text-transparent">Rakyat Berdaulat Digital.</span>
                </h1>
                
                <p class="text-sm sm:text-base text-base-content/70 leading-relaxed max-w-xl">
                    R-NET adalah penyedia internet kabel serat optik untuk rumah tangga, UMKM, dan komunitas. Kami merancang layanan tanpa batasan FUP agar internet cepat merata di seluruh kalangan masyarakat.
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
                        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center border-2 border-base-100 text-[10px] font-bold">U1</div>
                        <div class="w-8 h-8 rounded-full bg-cyan-400/20 flex items-center justify-center border-2 border-base-100 text-[10px] font-bold">U2</div>
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center border-2 border-base-100 text-[10px] font-bold">U3</div>
                    </div>
                    <p class="text-xs font-semibold text-base-content/60">Didukung penuh oleh 500+ pelanggan aktif daerah</p>
                </div>
            </div>

            <!-- Right Interactive SVG Node Canvas Column -->
            <div class="lg:col-span-5 flex justify-center items-center">
                <div class="glass-card p-6 rounded-3xl border border-base-300/40 shadow-2xl relative w-full max-w-md aspect-square flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-cyan-500/5 pointer-events-none"></div>
                    
                    <!-- SVG Interactive Network Node Map -->
                    <svg viewBox="0 0 400 400" class="w-full h-full z-10">
                        <!-- Connecting Lines (dynamic dasharray) -->
                        <line x1="200" y1="200" x2="90" y2="100" stroke="#1977BF" stroke-width="1.5" stroke-dasharray="5 5" opacity="0.6" />
                        <line x1="200" y1="200" x2="310" y2="100" stroke="#1977BF" stroke-width="1.5" stroke-dasharray="5 5" opacity="0.6" />
                        <line x1="200" y1="200" x2="200" y2="320" stroke="#1977BF" stroke-width="1.5" stroke-dasharray="5 5" opacity="0.6" />
                        
                        <!-- Pulsing Light Packets (CSS animated paths) -->
                        <circle r="4" fill="#00c8ff">
                            <animateMotion dur="2.5s" repeatCount="indefinite" path="M 200,200 L 90,100" />
                        </circle>
                        <circle r="4" fill="#00c8ff">
                            <animateMotion dur="3s" repeatCount="indefinite" path="M 200,200 L 310,100" />
                        </circle>
                        <circle r="4" fill="#00c8ff">
                            <animateMotion dur="2.2s" repeatCount="indefinite" path="M 200,200 L 200,320" />
                        </circle>

                        <!-- Central R-NET Hub Node -->
                        <circle cx="200" cy="200" r="28" fill="#1977BF" opacity="0.1" />
                        <circle cx="200" cy="200" r="16" fill="#1977BF" />
                        <circle cx="200" cy="200" r="6" fill="#ffffff" class="animate-pulse-dote" />
                        <text x="200" y="240" font-family="'Poppins', sans-serif" font-size="11" font-weight="800" fill="#1977BF" text-anchor="middle">R-NET HUB</text>

                        <!-- Outer Node 1: Sungai Penuh -->
                        <g class="cursor-pointer group/node" onclick="showNodeDetails('sp')">
                            <circle cx="90" cy="100" r="22" fill="#0a0e17" stroke="#1d2438" stroke-width="2" class="group-hover/node:stroke-primary transition-all duration-300" />
                            <circle cx="90" cy="100" r="6" fill="#1977BF" class="group-hover/node:fill-cyan-400 transition-all duration-300" />
                            <text x="90" y="140" font-family="'Poppins', sans-serif" font-size="10" font-weight="700" fill="currentColor" text-anchor="middle">SUNGAI PENUH</text>
                        </g>

                        <!-- Outer Node 2: Kerinci -->
                        <g class="cursor-pointer group/node" onclick="showNodeDetails('kr')">
                            <circle cx="310" cy="100" r="22" fill="#0a0e17" stroke="#1d2438" stroke-width="2" class="group-hover/node:stroke-primary transition-all duration-300" />
                            <circle cx="310" cy="100" r="6" fill="#1977BF" class="group-hover/node:fill-cyan-400 transition-all duration-300" />
                            <text x="310" y="140" font-family="'Poppins', sans-serif" font-size="10" font-weight="700" fill="currentColor" text-anchor="middle">KERINCI</text>
                        </g>

                        <!-- Outer Node 3: Merangin -->
                        <g class="cursor-pointer group/node" onclick="showNodeDetails('mr')">
                            <circle cx="200" cy="320" r="22" fill="#0a0e17" stroke="#1d2438" stroke-width="2" class="group-hover/node:stroke-primary transition-all duration-300" />
                            <circle cx="200" cy="320" r="6" fill="#1977BF" class="group-hover/node:fill-cyan-400 transition-all duration-300" />
                            <text x="200" y="360" font-family="'Poppins', sans-serif" font-size="10" font-weight="700" fill="currentColor" text-anchor="middle">MERANGIN</text>
                        </g>
                    </svg>

                    <!-- Interactive text card inside the canvas -->
                    <div id="node-info-popup" class="absolute bottom-4 left-4 right-4 bg-base-100/90 backdrop-blur-md p-3.5 rounded-2xl border border-base-300/60 shadow-lg text-xs leading-relaxed transition-all transform scale-100">
                        <p class="font-bold text-primary flex items-center gap-1"><i data-lucide="network" class="w-3.5 h-3.5"></i> Hub Jaringan Aktif</p>
                        <p class="text-base-content/70 mt-1 font-medium" id="node-info-text">Klik salah satu node wilayah di atas untuk melihat detail jangkauan operasional R-NET.</p>
                    </div>
                </div>
            </div>
        </header>


        {{-- ==================== BENTO INTERACTIVE DASHBOARD ==================== --}}
        <section class="space-y-10">
            <div class="text-center max-w-xl mx-auto">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    🎛️ Control Panel
                </div>
                <h2 class="text-3xl font-extrabold mt-3">R-NET Interactive Bento</h2>
                <p class="text-sm text-base-content/60 mt-2">Uji kecepatan, kalkulasi kebutuhan perangkat, dan cek jangkauan secara langsung.</p>
            </div>

            <!-- The Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                
                <!-- Card 1: Interactive Speedometer Widget (6/12 width) -->
                <div id="speedtest" class="md:col-span-6 glass-card p-6 rounded-3xl shadow-lg border border-base-300/40 flex flex-col justify-between">
                    <div class="space-y-2">
                        <span class="badge badge-primary font-bold text-[10px] tracking-wider uppercase">Live Widget</span>
                        <h3 class="text-lg font-bold">Simulator Uji Kecepatan</h3>
                        <p class="text-xs text-base-content/60 leading-relaxed">Coba simulasi kecepatan fiber optik R-NET langsung dari panel ini.</p>
                    </div>

                    <!-- Speed Dial Visual -->
                    <div class="flex flex-col items-center justify-center py-6 relative">
                        <svg class="w-36 h-36 transform -rotate-90">
                            <!-- Background Track -->
                            <circle cx="72" cy="72" r="45" stroke="currentColor" stroke-width="8" fill="transparent" class="text-base-300/30" />
                            <!-- Active Dial -->
                            <circle id="speedtest-dial" cx="72" cy="72" r="45" stroke="#1977BF" stroke-width="8" fill="transparent" 
                                    stroke-dasharray="283" stroke-dashoffset="283" />
                        </svg>
                        
                        <!-- Floating Speed Numbers -->
                        <div class="absolute flex flex-col items-center justify-center">
                            <span class="text-3xl font-black text-primary" id="speedtest-val">0.0</span>
                            <span class="text-[9px] font-bold text-base-content/50 tracking-wider uppercase">Mbps</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t border-base-300/30 pt-4 text-center">
                        <div>
                            <span class="block text-[10px] font-semibold text-base-content/50 uppercase tracking-wider">Ping Latensi</span>
                            <span class="text-base font-extrabold text-base-content" id="speedtest-ping">--</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-semibold text-base-content/50 uppercase tracking-wider">Jaringan</span>
                            <span class="text-sm font-extrabold text-success flex items-center justify-center gap-1"><i data-lucide="shield-check" class="w-4 h-4"></i> Aman</span>
                        </div>
                    </div>

                    <button onclick="runSpeedTest()" id="speedtest-btn" class="w-full btn btn-primary mt-6 rounded-xl font-bold active:scale-95 transition-transform text-xs shadow-md shadow-primary/20">
                        MULAI PENGUJIAN
                    </button>
                </div>

                <!-- Card 2: Interactive Cost Calculator (6/12 width) -->
                <div id="kalkulator" class="md:col-span-6 glass-card p-6 rounded-3xl shadow-lg border border-base-300/40 flex flex-col justify-between">
                    <div class="space-y-2">
                        <span class="badge badge-primary font-bold text-[10px] tracking-wider uppercase">Calculator</span>
                        <h3 class="text-lg font-bold">Kalkulator Kebutuhan Rumah</h3>
                        <p class="text-xs text-base-content/60 leading-relaxed">Geser jumlah perangkat di rumah Anda untuk mendapatkan rekomendasi paket yang paling hemat.</p>
                    </div>

                    <div class="py-6 space-y-6">
                        <!-- Range slider input -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs font-bold text-base-content">
                                <span>Jumlah Perangkat (HP/Laptop/TV)</span>
                                <span class="badge badge-neutral text-xs font-bold" id="calc-devices-val">5</span>
                            </div>
                            <input type="range" min="1" max="20" value="5" class="range range-primary range-sm" id="calc-devices" oninput="updateCalc()" />
                            <div class="flex justify-between text-[9px] font-bold text-base-content/30">
                                <span>1 Device</span>
                                <span>20 Devices</span>
                            </div>
                        </div>

                        <!-- Result Display Box -->
                        <div class="bg-base-200/50 border border-base-300/60 rounded-2xl p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-base-content/60">Paket Rekomendasi:</span>
                                <span class="badge badge-primary font-extrabold" id="calc-rec-name">Paket Populer</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-base-content/60">Kecepatan Ideal:</span>
                                <span class="font-extrabold text-sm text-base-content" id="calc-rec-speed">30 Mbps</span>
                            </div>
                            <div class="border-t border-base-300/40 my-1"></div>
                            <div class="flex flex-col items-center py-1">
                                <span class="text-[10px] font-semibold text-base-content/50 uppercase tracking-widest">Rasio Biaya Per Perangkat</span>
                                <span class="text-base font-black text-primary mt-1" id="calc-rec-cost">Rp 1.666 / hari / perangkat</span>
                            </div>
                        </div>
                    </div>

                    <a href="/daftar" class="w-full btn btn-outline btn-primary rounded-xl font-bold text-xs active:scale-95 transition-transform">
                        DAFTAR PAKET INI
                    </a>
                </div>

                <!-- Card 3: No-FUP Flow Visualizer (8/12 width) -->
                <div class="md:col-span-8 glass-card p-6 rounded-3xl shadow-lg border border-base-300/40 flex flex-col md:flex-row gap-6 items-stretch">
                    <div class="flex flex-col justify-between md:w-1/2">
                        <div class="space-y-2">
                            <span class="badge badge-primary font-bold text-[10px] tracking-wider uppercase">Visualizer</span>
                            <h3 class="text-lg font-bold">Stabilitas Data vs Kuota FUP</h3>
                            <p class="text-xs text-base-content/60 leading-relaxed">Penyedia internet seluler/paket data membatasi kecepatan saat kuota harian habis. R-NET fiber optik menjaga jalur data Anda tetap mengalir tanpa FUP.</p>
                        </div>
                        <div class="pt-4 space-y-2 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-cyan-400 shrink-0"></span>
                                <span class="font-semibold">R-NET: Aliran Tanpa Hambatan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-error shrink-0"></span>
                                <span class="font-semibold text-base-content/75">Internet Biasa: Dibatasi/Lag</span>
                            </div>
                        </div>
                    </div>

                    <!-- Flow Animation visual canvas -->
                    <div class="bg-base-200/50 border border-base-300/50 rounded-2xl p-4 md:w-1/2 flex items-center justify-center relative overflow-hidden min-h-[140px]">
                        <div class="absolute inset-x-0 top-1/4 h-2 bg-error/15 rounded">
                            <div class="h-full bg-error rounded animate-pulse" style="width: 35%"></div>
                        </div>
                        <div class="absolute inset-x-0 bottom-1/4 h-3 bg-cyan-500/15 rounded">
                            <div class="h-full bg-cyan-500 rounded animate-pulse" style="width: 100%"></div>
                        </div>
                        
                        <span class="absolute top-1 right-4 text-[9px] font-bold text-error uppercase">FUP Throttling (Cellular)</span>
                        <span class="absolute bottom-1 right-4 text-[9px] font-bold text-cyan-500 uppercase">100% Unlimited Fiber Optic</span>
                    </div>
                </div>

                <!-- Card 4: Realtime Server Ping (4/12 width) -->
                <div class="md:col-span-4 glass-card p-6 rounded-3xl shadow-lg border border-base-300/40 flex flex-col justify-between">
                    <div class="space-y-2">
                        <span class="badge badge-primary font-bold text-[10px] tracking-wider uppercase">Network Uptime</span>
                        <h3 class="text-lg font-bold">Server Ping</h3>
                        <p class="text-xs text-base-content/60">Grafik stabilitas koneksi data R-NET secara real-time.</p>
                    </div>

                    <!-- Mock Live Bar Graph -->
                    <div class="flex items-end justify-between h-20 px-2 mt-4">
                        <div class="w-3 bg-primary/70 h-12 rounded-t transition-all duration-300"></div>
                        <div class="w-3 bg-primary/80 h-14 rounded-t transition-all duration-300"></div>
                        <div class="w-3 bg-primary/75 h-13 rounded-t transition-all duration-300"></div>
                        <div class="w-3 bg-cyan-400 h-16 rounded-t transition-all duration-300"></div>
                        <div class="w-3 bg-primary h-15 rounded-t transition-all duration-300"></div>
                        <div class="w-3 bg-primary/90 h-14 rounded-t transition-all duration-300"></div>
                        <div class="w-3 bg-cyan-500 h-16 rounded-t transition-all duration-300"></div>
                    </div>

                    <div class="flex justify-between items-center text-[10px] font-bold text-base-content/50 uppercase tracking-widest pt-4 border-t border-base-300/30">
                        <span>Ping Rata-Rata</span>
                        <span class="text-success font-extrabold flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> 2ms</span>
                    </div>
                </div>
            </div>
        </section>


        {{-- ==================== SECTION 2: FITUR ==================== --}}
        <section id="fitur" class="py-10">
            <div class="text-center max-w-xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    💡 Teknologi Unggulan
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Standar Kualitas Jaringan</h2>
                <p class="text-sm text-base-content/60 mt-2">Menawarkan solusi internet terbaik langsung ke rumah Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/40 shadow-md hover:shadow-xl transition-all hover:-translate-y-1 duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900/40 flex items-center justify-center group-hover:scale-110 duration-300 shadow-sm mb-6 text-blue-500">
                        <i data-lucide="zap" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Fiber Optik FTTH</h3>
                    <p class="text-xs text-base-content/60 leading-relaxed mt-3">
                        Kabel fiber optik ditarik langsung ke dalam rumah Anda (Fiber To The Home) untuk meminimalkan gangguan induksi listrik dan cuaca buruk.
                    </p>
                </div>

                <!-- Fitur 2 -->
                <div class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/40 shadow-md hover:shadow-xl transition-all hover:-translate-y-1 duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 dark:bg-green-950/40 border border-green-100 dark:border-green-900/40 flex items-center justify-center group-hover:scale-110 duration-300 shadow-sm mb-6 text-green-500">
                        <i data-lucide="lock" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Tanpa FUP</h3>
                    <p class="text-xs text-base-content/60 leading-relaxed mt-3">
                        Gunakan internet sepuasnya tanpa batas kuota bulanan. Kecepatan tetap stabil dari hari pertama hingga akhir bulan, bebas khawatir.
                    </p>
                </div>

                <!-- Fitur 3 -->
                <div class="glass-card p-6 md:p-8 rounded-3xl border border-base-300/40 shadow-md hover:shadow-xl transition-all hover:-translate-y-1 duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-950/40 border border-purple-100 dark:border-purple-900/40 flex items-center justify-center group-hover:scale-110 duration-300 shadow-sm mb-6 text-purple-500">
                        <i data-lucide="heart-handshake" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Layanan Lokal 24 Jam</h3>
                    <p class="text-xs text-base-content/60 leading-relaxed mt-3">
                        Teknisi lapangan kami siaga di area cakupan lokal untuk menangani gangguan konektivitas dengan respon cepat kurang dari 24 jam.
                    </p>
                </div>
            </div>
        </section>


        {{-- ==================== SECTION 3: HARGA ==================== --}}
        <section id="harga" class="space-y-12">
            <div class="text-center max-w-xl mx-auto">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    💰 Skema Harga
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Paket Kecepatan Internet</h2>
                <p class="text-sm text-base-content/60 mt-2">Sesuaikan pilihan paket internet R-NET dengan kebutuhan digital Anda.</p>
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
                                    <span class="text-xs font-bold text-primary uppercase tracking-widest">Jaringan FTTH</span>
                                    @if($isPopular)
                                        <span class="badge badge-warning text-[10px] font-black uppercase tracking-wider py-2">Terpopuler</span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-extrabold text-base-content">{{ $paket->title_paket }}</h3>
                            </div>

                            <div class="flex items-end justify-start gap-1 py-4">
                                <span class="text-5xl font-black text-base-content">{{ number_format($paket->harga_paket / 1000, 0) }}K</span>
                                <span class="text-xs text-base-content/50 font-bold mb-1.5">/bulan</span>
                            </div>

                            <div class="border-t border-base-300/40 my-1"></div>

                            <ul class="space-y-3.5 text-xs text-base-content/85 font-medium flex-1 pt-2">
                                <li class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </span>
                                    <span>Kuota 100% Unlimited Murni</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </span>
                                    <span>Bebas Lag &amp; Throttling FUP</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0">
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

            <p class="flex items-center justify-center gap-2 bg-yellow-400 text-amber-950 px-5 py-2 rounded-full text-xs font-bold mx-auto w-fit border border-yellow-500 shadow-md">
                <i data-lucide="info" class="w-4 h-4"></i> BIAYA PENARIKAN KABEL &amp; INSTALASI MODEM HANYA 350K
            </p>
        </section>


        {{-- ==================== SECTION: DYNAMIC TERMINAL FAQ ==================== --}}
        <section id="terminal-faq" class="space-y-10 py-10 max-w-4xl mx-auto">
            <div class="text-center max-w-xl mx-auto">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold border border-primary/20 uppercase tracking-widest">
                    💬 FAQ Terminal
                </div>
                <h2 class="text-3xl font-extrabold mt-3">Konsol Tanya Jawab</h2>
                <p class="text-sm text-base-content/60 mt-2">Gunakan command line interaktif di bawah untuk meninjau informasi teknis R-NET.</p>
            </div>

            <!-- High-Tech Interactive Terminal FAQ Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                <!-- Left: Interactive Commands List -->
                <div class="md:col-span-5 flex flex-col justify-start gap-3">
                    <button onclick="selectFaq(1, this)" class="faq-tab tab-active btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --check-fup
                    </button>
                    <button onclick="selectFaq(2, this)" class="faq-tab btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --setup-fee
                    </button>
                    <button onclick="selectFaq(3, this)" class="faq-tab btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --deploy-timeline
                    </button>
                    <button onclick="selectFaq(4, this)" class="faq-tab btn btn-outline border-base-300/60 justify-start rounded-2xl bg-base-100/50 hover:bg-base-200 p-4 w-full h-auto text-left gap-3 text-xs font-bold">
                        <i data-lucide="terminal" class="w-4.5 h-4.5 text-primary shrink-0"></i> rnet --coverage-query
                    </button>
                </div>

                <!-- Right: Simulated Unix Terminal -->
                <div class="md:col-span-7 bg-[#050811] text-emerald-400 p-5 rounded-3xl border border-base-300/30 shadow-2xl relative overflow-hidden min-h-[200px] flex flex-col justify-between">
                    <!-- Terminal Top Dots -->
                    <div class="flex items-center gap-1.5 pb-3 border-b border-emerald-500/20 mb-3 text-emerald-500/40">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500/60"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/60"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500/60"></span>
                        <span class="text-[9px] font-bold uppercase tracking-wider ml-2 font-mono">rnet-terminal-console</span>
                    </div>

                    <!-- Terminal Output content -->
                    <div class="flex-1 terminal-window font-mono text-xs leading-relaxed whitespace-pre-wrap select-all pr-4 scrollbar-thin" id="faq-terminal-text">
                        > rnet --check-fup
                        [STATUS] UNLIMITED MURNI ACTIVE
                        [INFO] R-NET berkomitmen menyediakan layanan internet tanpa FUP (Fair Usage Policy). Tidak ada batasan kuota, tidak ada penurunan kecepatan secara tiba-tiba di akhir bulan. Anda bebas mengunduh dan streaming sepuasnya.
                    </div>

                    <!-- Blinking Cursor -->
                    <div class="flex items-center mt-3 pt-2 border-t border-emerald-500/20 text-emerald-500/40 font-mono text-[10px]">
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
                        Penyedia layanan internet serat optik rakyat terpercaya. Menghadirkan koneksi handal tanpa kuota FUP untuk kedaulatan digital bersama.<br><br>
                        Hak Cipta &copy; {{ date('Y') }} R-NET — Seluruh hak cipta dilindungi.
                    </p>
                </aside>

                <!-- Right side navigation links in columns -->
                <div class="grid grid-cols-2 sm:flex sm:flex-row gap-8 lg:gap-16">
                    <nav class="flex flex-col gap-2.5 text-xs font-semibold">
                        <h6 class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">Layanan</h6>
                        <a href="#fitur" class="link link-hover text-base-content/75">Fitur Unggulan</a>
                        <a href="#harga" class="link link-hover text-base-content/75">Paket Internet</a>
                        <a href="/daftar" class="link link-hover text-base-content/75">Pendaftaran Baru</a>
                    </nav>
                    <nav class="flex flex-col gap-2.5 text-xs font-semibold">
                        <h6 class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">Perusahaan</h6>
                        <a href="#" class="link link-hover text-base-content/75">Tentang R-NET</a>
                        <a href="https://wa.me/6281373242673" target="_blank" rel="noopener noreferrer" class="link link-hover text-base-content/75">Hubungi Kami</a>
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
            'sp': "Kanal Sungai Penuh aktif. Menjangkau seluruh kelurahan perkotaan Sungai Penuh dengan jaringan fiber optik backbone FTTH utama R-NET.",
            'kr': "Jangkauan Kabupaten Kerinci aktif. Meliputi area perumahan pedesaan dan agrowisata dengan tiang kabel fiber optik mandiri.",
            'mr': "Jangkauan Kabupaten Merangin aktif. Ekspansi jaringan optik kecepatan tinggi untuk mendukung operasional bisnis UMKM lokal setempat."
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

        // ── Speedtest simulator widget ────────────────────────────
        let isTesting = false;
        function runSpeedTest() {
            if (isTesting) return;
            isTesting = true;
            
            const btn = document.getElementById('speedtest-btn');
            const dial = document.getElementById('speedtest-dial');
            const speedVal = document.getElementById('speedtest-val');
            const pingVal = document.getElementById('speedtest-ping');
            
            btn.disabled = true;
            btn.textContent = 'MENGUJI...';
            pingVal.textContent = '--';
            
            // Set circle variables (circumference = 2 * PI * r = 2 * 3.14159 * 45 = 282.74 approx)
            const circ = 283;
            dial.style.strokeDashoffset = circ;

            setTimeout(() => {
                pingVal.textContent = '2 ms';
                
                let current = 0;
                const target = 100.0;
                
                const interval = setInterval(() => {
                    if (current >= target) {
                        clearInterval(interval);
                        speedVal.textContent = '100.0';
                        dial.style.strokeDashoffset = 0;
                        btn.disabled = false;
                        btn.textContent = 'UJI ULANG';
                        isTesting = false;
                    } else {
                        current += (target - current) * 0.15 + 0.2;
                        if (current > target) current = target;
                        
                        speedVal.textContent = current.toFixed(1);
                        dial.style.strokeDashoffset = circ - (current / target) * circ;
                    }
                }, 30);
            }, 800);
        }

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
            2: "> rnet --setup-fee\n\n[INSTALLATION] ACTIVE\n[COST] Rp 350.000 (Sekali bayar)\n[INCLUDES]\n - Kabel Fiber Optik FTTH Mandiri\n - Perangkat ONT Dual-Band WiFi Router\n - Setup konfigurasi & aktivasi jaringan siap pakai",
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

        // ── Init Lucide Icons ──────────────────────────────────────────────
        lucide.createIcons();
    </script>
</body>

</html>
