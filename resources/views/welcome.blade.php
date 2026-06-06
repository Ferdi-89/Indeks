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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="font-sans bg-base-100 text-base-content antialiased">

    {{-- Modal Konfirmasi Pendaftaran Berhasil --}}
    @if (session('sukses') || session('success'))
        <div id="success-overlay"
            class="fixed inset-0 z-[9999] overflow-y-auto bg-black/50 backdrop-blur-sm"
            style="animation: fadeIn 0.3s ease-out;">

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-base-100 rounded-2xl shadow-2xl p-8 md:p-10 max-w-md w-full text-center relative border border-base-300"
                    style="animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);">

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
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

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
    <nav class="navbar bg-base-100 shadow-sm sticky top-0 z-50 border-b border-base-300">
        <div class="navbar-start">
            {{-- Mobile hamburger --}}
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 border border-base-300">
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#harga">Harga</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
            {{-- Brand --}}
            <div class="flex items-center px-2">
                <a href="/">
                    <img src="/logoprimary.svg" alt="R-NET Logo" class="h-9 w-auto">
                </a>
            </div>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 gap-1 text-sm font-semibold">
                <li><a href="#fitur" class="rounded-lg hover:bg-primary/10 hover:text-primary">Fitur</a></li>
                <li><a href="#harga" class="rounded-lg hover:bg-primary/10 hover:text-primary">Harga</a></li>
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
                class="btn btn-primary btn-sm rounded-md border-primary/50 font-semibold">
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
        <header class="hero min-h-[80vh] " id="hero-section">
            <div class="hero-content text-center px-4 py-16">
                <div class="max-w-2xl">
                    {{-- Logo Hero (light = white, dark = black) --}}
                    <div class="flex justify-center mb-6">
                        <img src="/logobasewhite.svg" alt="R-NET" class="h-45 w-auto hero-logo-light">
                        <img src="/logobaseblack.svg" alt="R-NET" class="h-45 w-auto hero-logo-dark">
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
                        Internet <span class="text-primary">Cepat</span> &<br>
                        <span class="text-primary">Stabil</span> Tanpa Batas
                    </h1>
                    <p class="text-base sm:text-lg text-base-content/70 leading-relaxed mb-8 max-w-xl mx-auto">
                        R-NET menghadirkan koneksi internet berkualitas tinggi tanpa FUP,
                        unlimited quota, untuk kehidupan digital yang lebih produktif dan menyenangkan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="/daftar" id="btn-daftar-hero"
                            class="btn btn-primary btn-lg rounded-2xl font-bold px-8">
                            Daftar Sekarang
                        </a>
                        <a href="#harga" id="btn-pelajari"
                            class="btn btn-outline btn-primary btn-lg rounded-2xl font-bold px-8">
                            Pilihan Paket
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div
                        class="flex justify-center mt-12 border border-base-300 rounded-2xl overflow-hidden divide-x divide-base-300 max-w-sm mx-auto bg-base-100">
                        <div class="flex-1 text-center py-3 px-2">
                            <div class="text-2xl font-bold text-primary">500+</div>
                            <div class="text-xs text-base-content/60 font-medium mt-0.5">Pelanggan</div>
                        </div>
                        <div class="flex-1 text-center py-3 px-2">
                            <div class="text-2xl font-bold text-primary">24/7</div>
                            <div class="text-xs text-base-content/60 font-medium mt-0.5">Dukungan</div>
                        </div>
                        <div class="flex-1 text-center py-3 px-2">
                            <div class="text-2xl font-bold text-primary">99%</div>
                            <div class="text-xs text-base-content/60 font-medium mt-0.5">Uptime</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ==================== SECTION 2: FITUR ==================== --}}
        <section id="fitur" class="py-16 sm:py-24 px-5 sm:px-8 lg:px-16 max-w-7xl mx-auto">
            <div class="text-center mb-12 sm:mb-16">
                <div
                    class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-primary/20">
                    Keunggulan Kami
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Mengapa Memilih R-NET?</h2>
                <p class="text-base-content/60 text-sm sm:text-base max-w-2xl mx-auto">
                    Fitur unggulan yang dirancang khusus untuk memenuhi kebutuhan internet rumahan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Fitur 1 --}}
                <div
                    class="card bg-base-100 border border-base-300 hover:border-primary/40 transition-colors duration-200">
                    <div class="card-body items-center text-center gap-4 p-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="card-title justify-center text-lg font-bold">Cepat & Responsif</h3>
                            <p class="text-base-content/60 text-sm mt-2">Dibangun dengan teknologi fiber optik modern
                                untuk memastikan performa koneksi maksimal tanpa gangguan.</p>
                        </div>
                    </div>
                </div>

                {{-- Fitur 2 --}}
                <div
                    class="card bg-base-100 border border-base-300 hover:border-primary/40 transition-colors duration-200">
                    <div class="card-body items-center text-center gap-4 p-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-green-50 border border-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="card-title justify-center text-lg font-bold">Aman & Terpercaya</h3>
                            <p class="text-base-content/60 text-sm mt-2">Jaringan kami terlindungi dan stabil. Keamanan
                                koneksi Anda adalah prioritas utama kami.</p>
                        </div>
                    </div>
                </div>

                {{-- Fitur 3 --}}
                <div
                    class="card bg-base-100 border border-base-300 hover:border-primary/40 transition-colors duration-200 sm:col-span-2 lg:col-span-1">
                    <div class="card-body items-center text-center gap-4 p-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="card-title justify-center text-lg font-bold">Mudah Digunakan</h3>
                            <p class="text-base-content/60 text-sm mt-2">Proses pendaftaran cepat dan instalasi mudah.
                                Nikmati internet tanpa kerumitan teknis apapun.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== SECTION 3: HARGA ==================== --}}
        <section id="harga"
            class="py-16 sm:py-24 bg-gradient-to-r px-5 sm:px-8 lg:px-16 bg-base-200 border-t border-base-300">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12 sm:mb-16">
                    <div
                        class="inline-flex items-center gap-2 bg-primary/10 element-adaptive px-4 py-1.5 rounded-full text-sm font-semibold mb-4 border border-white">
                        Pilihan Paket
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-4">Pilih Paket Anda</h2>
                    <p class="text-base-content/60 text-sm sm:text-base max-w-2xl mx-auto">
                        Fleksibel sesuai dengan skala kebutuhan internet rumah Anda.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto lg:items-stretch">
                    @foreach($pakets as $index => $paket)
                        @php
                            $isPopular = ($index == 1);
                        @endphp
                        <div id="card-paket-{{ $paket->id_paket }}"
                            class="card transition-colors duration-200 {{ $isPopular ? 'bg-primary text-primary-content border border-primary/10 relative lg:-mt-4 lg:mb-4' : 'bg-base-100 border border-base-200 hover:border-primary/100' }}">

                            @if($isPopular)
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                                    <div
                                        class="badge bg-warning text-warning-content font-bold px-4 py-3 rounded-full border border-warning/30 text-xs tracking-wide">
                                        TERPOPULER
                                    </div>
                                </div>
                            @endif

                            <div class="card-body text-center gap-4 p-6 {{ $isPopular ? 'pt-10' : '' }}">
                                <div
                                    class="w-12 h-12 rounded-xl {{ $isPopular ? 'bg-white/15 border border-white/20' : 'bg-blue-50 border border-blue-100' }} flex items-center justify-center mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 {{ $isPopular ? 'text-white' : 'text-blue-500' }}" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">{{ $paket->title_paket }}</h3>
                                </div>
                                <div class="flex items-end justify-center gap-1">
                                    <span
                                        class="text-4xl font-extrabold {{ $isPopular ? '' : 'text-primary' }}">{{ number_format($paket->harga_paket / 1000, 0) }}K</span>
                                    <span
                                        class="mb-1 text-sm {{ $isPopular ? 'text-white/70' : 'text-base-content/50' }}">/bulan</span>
                                </div>
                                <div class="{{ $isPopular ? 'border-t border-white/20' : 'divider' }} my-0"></div>
                                <ul class="text-left space-y-2.5 text-sm">
                                    <li class="flex items-center gap-2.5">
                                        <div
                                            class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $isPopular ? 'bg-white/15 border border-white/25' : 'border border-success/40 bg-success/10' }}">
                                            <svg class="w-3 h-3 {{ $isPopular ? 'text-white' : 'text-success' }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span>Internet Cepat & Stabil</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <div
                                            class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $isPopular ? 'bg-white/15 border border-white/25' : 'border border-success/40 bg-success/10' }}">
                                            <svg class="w-3 h-3 {{ $isPopular ? 'text-white' : 'text-success' }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span>No FUP (Fair Usage Policy)</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <div
                                            class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 {{ $isPopular ? 'bg-white/15 border border-white/25' : 'border border-success/40 bg-success/10' }}">
                                            <svg class="w-3 h-3 {{ $isPopular ? 'text-white' : 'text-success' }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span>Unlimited Quota</span>
                                    </li>
                                </ul>
                                <div class="card-actions justify-center mt-auto pt-4">
                                    <a href="/daftar?paket={{ $paket->id_paket }}"
                                        class="btn rounded-xl w-full font-bold {{ $isPopular ? 'bg-white text-primary hover:bg-base-100 border border-white/60' : 'btn-outline btn-primary' }}">Pilih
                                        Paket</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <p
                    class="flex items-center justify-center gap-2 bg-yellow-400 text-amber-950 px-5 py-2 rounded-full text-sm font-bold mx-auto w-fit border border-yellow-500 mt-10 shadow-sm">
                    BIAYA PEMASANGAN HANYA 350k
                </p>
            </div>
        </section>


    </main>

    {{-- ==================== FOOTER / KONTAK ==================== --}}
    <footer id="kontak" class="bg-neutral text-neutral-content">
        <div class="container mx-auto px-5 sm:px-8 lg:px-16 py-10">
            {{-- Footer Row Utama: Logo + Nav --}}
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-10">

                {{-- Kolom Kiri: Logo + Deskripsi --}}
                <aside class="max-w-xs">
                    <div class="mb-3">
                        <img src="/logowhite.svg" alt="R-NET" class="h-10 w-auto">
                    </div>
                    <p class="text-neutral-content/70 text-sm leading-relaxed">
                        Memberikan solusi internet terbaik.<br>
                        Hak Cipta &copy; {{ date('Y') }} R-NET — Seluruh hak cipta dilindungi.
                    </p>
                </aside>

                {{-- Kolom Kanan: Nav Links --}}
                <div class="flex flex-row flex-wrap gap-10 lg:gap-16">
                    <nav class="flex flex-col gap-2">
                        <h6 class="footer-title">Layanan</h6>
                        <a href="#fitur" class="link link-hover">Fitur Kami</a>
                        <a href="#harga" class="link link-hover">Paket Harga</a>
                        <a href="/daftar" class="link link-hover">Daftar Pelanggan</a>
                    </nav>
                    <nav class="flex flex-col gap-2">
                        <h6 class="footer-title">Perusahaan</h6>
                        <a href="#" class="link link-hover">Tentang Kami</a>
                        <a href="https://wa.me/6281373242673" id="link-whatsapp-footer" target="_blank"
                            rel="noopener noreferrer" class="link link-hover">Kontak</a>
                    </nav>
                    <nav class="flex flex-col gap-2">
                        <h6 class="footer-title">Legal</h6>
                        <a href="#" class="link link-hover">Syarat Penggunaan</a>
                        <a href="#" class="link link-hover">Kebijakan Privasi</a>
                        <a href="#" class="link link-hover">Kebijakan Cookie</a>
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
        // (dilakukan via JS agar tidak diproses/di-transform oleh Vite)
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
                e.preventDefault();
                const el = document.querySelector(a.getAttribute('href'));
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // ── Newsletter subscribe button ───────────────────────────
        document.getElementById('btn-berlangganan').addEventListener('click', () => {
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
        // ── Init Lucide Icons ──────────────────────────────────────────────
        lucide.createIcons();
    </script>
</body>

</html>
