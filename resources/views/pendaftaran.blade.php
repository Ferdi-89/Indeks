<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar R-NET - Internet Rakyat</title>
    <meta name="description"
        content="Daftarkan layanan internet R-NET di lokasi Anda. Fiber optik berkecepatan tinggi untuk rumah Anda.">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f1f5f9] font-sans pb-20 antialiased">

    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 md:px-8 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Modal Konfirmasi Pendaftaran Berhasil --}}
    @if (session('sukses') || session('success'))
        <div id="success-overlay"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
            style="animation: fadeIn 0.3s ease-out;">

            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10 max-w-md w-[90%] text-center relative"
                style="animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);">

                {{-- Checkmark Circle --}}
                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6"
                    style="animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mb-2">Pendaftaran Berhasil!</h2>
                <p class="text-slate-500 text-sm leading-relaxed mb-2">
                    Terima kasih telah mendaftar layanan <span class="font-semibold text-slate-700">R-NET</span>.
                </p>
                <p class="text-slate-500 text-sm leading-relaxed mb-8">
                    Tim teknisi kami akan segera menghubungi Anda untuk proses instalasi.
                    Mohon pastikan nomor telepon Anda aktif.
                </p>

                <div class="flex flex-col gap-3">
                    <a href="/"
                        class="w-full bg-[#1e40af] text-white font-bold py-3 px-6 rounded-lg hover:bg-[#1e3a8a] transition shadow text-sm text-center">
                        Kembali ke Beranda
                    </a>
                    <button onclick="document.getElementById('success-overlay').remove()"
                        class="w-full text-slate-500 font-semibold py-2.5 px-6 rounded-lg hover:bg-slate-100 transition text-sm">
                        Daftar Lagi
                    </button>
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


    <main class="max-w-7xl mx-auto px-4 md:px-8 pt-6 md:pt-10 grid lg:grid-cols-12 gap-6 md:gap-10">

        <!-- Left Column (Info Panel) -->
        <div class="lg:col-span-4 space-y-4 md:space-y-6">

            <div class="space-y-2">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight leading-tight">
                    Daftar Layanan
                </h1>
            </div>

            <div class="space-y-3 text-[15px] md:text-base text-slate-600 leading-relaxed max-w-[22rem]">
                <p>Isi formulir pendaftaran di samping untuk mulai menggunakan layanan internet berkecepatan tinggi dari
                    R-NET (Internet Rakyat).</p>
                <p>Dapatkan pengalaman berselancar tanpa batas dengan dukungan fiber optik mutakhir kami yang menjangkau
                    rumah Anda.</p>
            </div>

            <div href="#alamat"
                class="bg-white p-4 text-slate-700 text-sm shadow-sm border border-slate-200 rounded-xl mt-6">
                <p class="font-semibold mb-1 text-slate-900">Petunjuk Lokasi Peta:</p>
                <p class="opacity-90 leading-relaxed text-xs md:text-sm">Geser peta untuk mencari lokasi Anda yang
                    paling tepat, lalu tekan tombol "Konfirmasi Alamat".</p>
            </div>
        </div>

        <!-- Right Column (The Form) -->
        <div class="lg:col-span-8 space-y-6 mb-10">

            <div class="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf

                    <!-- Informasi Pribadi Section -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800">Informasi Pribadi</h3>
                        </div>

                        <div class="space-y-5 md:pl-2">
                            <div class="space-y-1.5">
                                <label class="text-sm font-semibold text-slate-700 flex items-center">
                                    Nama Lengkap<span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda"
                                    value="{{ old('nama') }}" required
                                    class="w-full px-4 py-3 rounded-lg transition text-sm outline-none {{ $errors->has('nama') ? 'border-2 border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-200 bg-red-50 text-red-900 placeholder-red-400' : 'bg-[#f8fafc] border border-slate-200 focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-slate-800' }}">
                                @error('nama') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-semibold text-slate-700 flex items-center">
                                    Nomor Telepon<span class="text-red-500 ml-1">*</span>
                                </label>
                                <div
                                    class="flex w-full rounded-lg overflow-hidden transition {{ $errors->has('nomor_tlpn') ? 'border-2 border-red-500 bg-red-50 focus-within:ring-2 focus-within:ring-red-200' : 'border border-slate-200 bg-[#f8fafc] focus-within:ring-1 focus-within:bg-white focus-within:ring-blue-500 focus-within:border-blue-500' }}">
                                    <span
                                        class="flex items-center justify-center px-3 border-r text-sm font-semibold shadow-inner {{ $errors->has('nomor_tlpn') ? 'bg-red-100 border-red-200 text-red-700' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                                        +62
                                    </span>
                                    <input type="tel" name="nomor_tlpn" placeholder="812-3456-7890"
                                        value="{{ old('nomor_tlpn') }}" required minlength="8"
                                        class="w-full px-3 py-3 outline-none text-sm bg-transparent {{ $errors->has('nomor_tlpn') ? 'text-red-900 placeholder-red-400' : 'text-slate-800' }}">
                                </div>
                                @error('nomor_tlpn') <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Paket Section -->
                    <div class="space-y-5 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                                <i data-lucide="package" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800">Pilihan Paket</h3>
                        </div>

                        <div class="space-y-2 md:pl-2">
                            <label class="text-sm font-semibold text-slate-700 flex items-center">
                                Paket Internet<span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="hidden" name="id_paket" id="selected-paket"
                                value="{{ old('id_paket', request('paket')) }}" required>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach ($pakets as $paket)
                                                            <button type="button" data-paket-id="{{ $paket['id_paket'] }}"
                                                                onclick="selectPaket(this)" class="paket-card group relative flex flex-col items-center text-center p-4 rounded-xl border-2 transition-all duration-200 cursor-pointer
                                                                                                                                                                                                                                                {{ old('id_paket', request('paket')) == $paket['id_paket']
                                    ? 'border-[#1e40af] bg-[#eef2ff] ring-1 ring-[#1e40af]/30'
                                    : 'border-slate-200 bg-[#f8fafc] hover:border-slate-300 hover:bg-white' }}">

                                                                {{-- Check indicator --}}
                                                                <div class="absolute top-2.5 right-2.5 w-5 h-5 rounded-full flex items-center justify-center transition-all duration-200
                                                                                                                                                                                                                                                {{ old('id_paket', request('paket')) == $paket['id_paket']
                                    ? 'bg-[#1e40af] text-white scale-100'
                                    : 'border-2 border-slate-300 scale-90' }}">
                                                                    <svg class="w-3 h-3 {{ old('id_paket', request('paket')) == $paket['id_paket'] ? '' : 'hidden' }}"
                                                                        fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                                                        </path>
                                                                    </svg>
                                                                </div>

                                                                <p class="text-sm font-bold text-slate-800 mt-1">{{ $paket['title_paket'] }}</p>
                                                                <p class="text-[#1e40af] font-extrabold text-lg leading-tight mt-1.5">
                                                                    Rp {{ number_format($paket['harga_paket'], 0, ',', '.') }}
                                                                </p>
                                                                <p class="text-[11px] text-slate-500 font-medium">/bulan</p>
                                                            </button>
                                @endforeach
                            </div>
                            @error('id_paket') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Informasi Alamat Section -->
                    <div class="space-y-5 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800">Informasi Alamat</h3>
                        </div>

                        <div class="space-y-5 md:pl-2">
                            <div class="space-y-1.5 flex flex-col">
                                <label class="text-sm font-semibold text-slate-700 flex items-center">
                                    Tandai Titik Lokasi Pemasangan (Peta)<span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="w-full">
                                    <div
                                        class="rounded-xl overflow-hidden border border-slate-200 shadow-sm z-0 w-full mb-2">
                                        <div class="relative h-[20rem] md:h-[24rem] w-full z-0 block">
                                            <div id="map" class="h-full w-full"></div>
                                            <!-- Fixed Center Pin overlay -->
                                            <div
                                                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-full z-[400] drop-shadow-md pointer-events-none flex flex-col items-center">
                                                <div id="map-loading-indicator"
                                                    class="hidden absolute -top-8 bg-black/70 text-white text-[10px] px-2.5 py-1 rounded-md font-medium whitespace-nowrap mb-1 shadow">
                                                    Mencari alamat...
                                                </div>
                                                <div id="map-pin-icon"
                                                    class="transition-transform duration-200 ease-in-out translate-y-0">
                                                    <svg width="42" height="42" viewBox="0 0 24 24" fill="#ef4444"
                                                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                        <circle cx="12" cy="10" r="3" fill="white"></circle>
                                                    </svg>
                                                </div>
                                                <div id="map-pin-shadow"
                                                    class="w-2.5 h-1 bg-black/30 rounded-full mt-1 blur-[1px] transition-opacity duration-200 opacity-100">
                                                </div>
                                            </div>
                                            <!-- Use GPS Button -->
                                            <button id="btn-gps" title="Gunakan Lokasi Saat Ini (GPS)" type="button"
                                                class="absolute bottom-4 right-4 z-[400] bg-white p-3 rounded-full shadow-lg border border-slate-100 text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition">
                                                <i data-lucide="navigation" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                        <!-- Footer Konfirmasi (Selalu Vertikal) -->
                                        <div
                                            class="bg-white p-4 md:p-5 z-10 shrink-0 flex flex-col gap-4 relative border-t border-slate-200">
                                            <div class="flex items-start gap-3 w-full min-w-0">
                                                <i data-lucide="map-pin"
                                                    class="text-red-500 w-5 h-5 shrink-0 mt-0.5"></i>
                                                <div class="flex-1 min-w-0">
                                                    <p
                                                        class="text-[11px] md:text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">
                                                        Alamat Terpilih</p>
                                                    <p id="temp-address-display"
                                                        class="text-sm font-medium text-slate-800 line-clamp-2 leading-snug">
                                                        Geser peta untuk menentukan area
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Validasi Status diletakkan di luar flexbox icon agar sejajar rapi dengan batas kiri kontainer -->
                                            <div id="wilayah-validation-status"
                                                class="mt-1 text-xs font-semibold hidden flex items-center gap-1.5 w-full">
                                            </div>
                                            <button id="btn-confirm-address" type="button" disabled
                                                class="w-full bg-[#1e40af] text-white py-3 px-6 rounded-lg font-bold text-sm hover:bg-[#1e3a8a] transition disabled:opacity-60 disabled:cursor-not-allowed shadow-sm text-center">
                                                Konfirmasi Alamat
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="latitude" id="lat"
                                        value="{{ old('latitude', -2.0337714) }}">
                                    <input type="hidden" name="longtitude" id="long"
                                        value="{{ old('longtitude', 101.3963373) }}">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-semibold text-slate-700 flex items-center">
                                    Wilayah Layanan Internet<span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="select-wilayah" name="wilayah" required
                                    class="w-full px-4 py-3 rounded-lg transition text-sm outline-none {{ $errors->has('wilayah') ? 'border-2 border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-200 bg-red-50 text-red-900' : 'bg-[#f8fafc] border border-slate-200 focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-slate-800' }}">
                                    <option value="" disabled {{ old('wilayah') ? '' : 'selected' }}>Pilih Wilayah Anda
                                    </option>
                                    @foreach($areaLayanan as $area)
                                        <option value="{{ $area->nama_area }}" {{ old('wilayah') == $area->nama_area ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                                    @endforeach
                                    <option value="konsultasi" class="text-blue-600 font-semibold">💬 Wilayah Anda tidak
                                        ada? Konsultasi dengan Admin</option>
                                </select>
                                @error('wilayah') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div id="alamat" class="space-y-1.5">
                                <label class="text-sm font-semibold text-slate-700 flex items-center">
                                    Alamat Lengkap<span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="alamat-input" name="alamat" rows="3" required
                                    class="w-full px-4 py-3 rounded-lg transition resize-none text-sm outline-none {{ $errors->has('alamat') ? 'border-2 border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-200 bg-red-50 text-red-900 placeholder-red-400' : 'bg-[#f8fafc] border border-slate-200 focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-slate-800' }}"
                                    placeholder="Contoh: Jl. Panglima Sudirman No. 12, RT 01/RW 02, Kelurahan Melati, Kode Pos 15810">{{ old('alamat') }}</textarea>
                                @error('alamat') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                <p class="text-[11px] text-slate-500 leading-relaxed mt-2 italic">
                                    Jika Anda mengubah teks ini dengan alamat/kota yang spesifik, peta di atas otomatis
                                    akan bergeser ke lokasi tersebut.
                                </p>
                            </div>
                        </div>
                    </div>



                    <!-- Foto Properti Section -->
                    <div class="space-y-5 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                                <i data-lucide="home" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800">Foto Properti</h3>
                        </div>

                        <div class="space-y-1.5 md:pl-2">
                            <label class="text-sm font-semibold text-slate-700 flex items-center">
                                Upload Foto Rumah<span class="text-red-500 ml-1">*</span>
                            </label>

                            <div
                                class="relative border rounded-xl transition overflow-hidden {{ $errors->has('path_gambar') ? 'border-2 border-red-500 bg-red-50 hover:border-red-500' : 'border-slate-200 bg-[#f8fafc] hover:border-blue-400' }}">
                                <!-- Preview area (hidden until file is chosen) -->
                                <div id="preview-container"
                                    class="hidden items-center p-4 border-b border-slate-200 bg-white">
                                    <img id="image-preview" src="#" alt="Preview"
                                        class="w-20 h-20 object-cover rounded shadow border border-slate-200">
                                    <div class="flex-1 ml-4">
                                        <p class="text-sm font-semibold text-slate-800">Gambar berhasil dipilih</p>
                                        <p class="text-xs text-slate-500 mt-1">Gunakan tombol di bawah untuk mengganti.
                                        </p>
                                    </div>
                                </div>

                                <label for="file-input"
                                    class="flex flex-col items-center justify-center p-6 md:p-8 cursor-pointer hover:bg-slate-50 transition">
                                    <div
                                        class="bg-[#eef2ff] p-3 rounded-xl mb-4 text-[#1e40af] shadow-sm font-semibold">
                                        <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 mb-1" id="upload-label">
                                        Klik untuk upload foto rumah
                                    </p>
                                    <p class="text-xs text-slate-500 font-medium">PNG, JPG maksimal 1 MB</p>
                                </label>

                                <input type="file" id="file-input" name="path_gambar" accept=".png,.jpg,.jpeg"
                                    class="hidden" required>
                            </div>
                            @error('path_gambar') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            <p class="text-xs text-slate-500 leading-relaxed mt-2">
                                Upload foto tampak depan rumah yang jelas untuk membantu teknisi menemukan lokasi
                                properti Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="pt-8">
                        <button type="submit" id="submit-btn"
                            class="w-full bg-[#1e40af] text-white font-bold px-8 py-3.5 rounded-lg hover:bg-[#1e3a8a] transition shadow text-sm flex items-center justify-center">
                            Kirim Pendaftaran
                        </button>
                        <p class="text-[11px] text-center text-slate-500 font-medium mt-4">
                            Dengan mengirim formulir ini, Anda setuju dengan <br class="hidden sm:block">
                            <span class="text-blue-600 hover:underline cursor-pointer">Syarat Layanan</span> dan
                            <span class="text-blue-600 hover:underline cursor-pointer">Kebijakan Privasi</span> kami.
                        </p>
                    </div>

                </form>
            </div>

            <!-- Contact Support Container directly below the form card -->
            <div
                class="bg-white border border-slate-200 rounded-2xl p-5 md:p-6 shadow-sm flex flex-col sm:flex-row gap-5 items-start sm:items-center mt-6">
                <div class="bg-[#eef2ff] p-3 md:p-4 rounded-xl text-[#1e40af] shrink-0">
                    <i data-lucide="headphones" class="w-6 h-6 md:w-8 md:h-8"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-base">Butuh Bantuan?</h4>
                    <p class="text-sm text-slate-500 mt-1 mb-3">Tim layanan pelanggan kami tersedia 24/7 untuk membantu
                        proses instalasi Anda.</p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 text-sm font-semibold">
                        <a href="tel:+6281373242873"
                            class="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition">
                            <i data-lucide="phone" class="w-4 h-4 text-blue-600"></i>
                            0813-7324-2873
                        </a>
                        <a href="#" class="flex items-center gap-2 text-green-600 hover:text-green-700 transition">
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                            Dukungan WhatsApp
                        </a>
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

        // ── Paket Card Selector ───────────────────────────────────────────
        function selectPaket(el) {
            var id = el.getAttribute('data-paket-id');
            document.getElementById('selected-paket').value = id;

            document.querySelectorAll('.paket-card').forEach(function (card) {
                var indicator = card.querySelector('div');
                var checkSvg = card.querySelector('svg');

                if (card.getAttribute('data-paket-id') === id) {
                    card.className = card.className
                        .replace('border-slate-200', 'border-[#1e40af]')
                        .replace('bg-[#f8fafc]', 'bg-[#eef2ff]')
                        .replace('hover:border-slate-300', '')
                        .replace('hover:bg-white', '');
                    card.classList.add('ring-1', 'ring-[#1e40af]/30');
                    indicator.className = indicator.className
                        .replace('border-2', '').replace('border-slate-300', '')
                        .replace('scale-90', 'scale-100');
                    indicator.classList.add('bg-[#1e40af]', 'text-white');
                    checkSvg.classList.remove('hidden');
                } else {
                    card.className = card.className
                        .replace('border-[#1e40af]', 'border-slate-200')
                        .replace('bg-[#eef2ff]', 'bg-[#f8fafc]');
                    card.classList.remove('ring-1', 'ring-[#1e40af]/30');
                    card.classList.add('hover:border-slate-300', 'hover:bg-white');
                    indicator.classList.remove('bg-[#1e40af]', 'text-white');
                    indicator.className = indicator.className
                        .replace('scale-100', 'scale-90');
                    indicator.classList.add('border-2', 'border-slate-300');
                    checkSvg.classList.add('hidden');
                }
            });
        }

        // ── Leaflet Map ────────────────────────────────────────────────────
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

            if (!tempAddr || tempAddr.includes("Geser peta") || tempAddr.includes("Mencari")) {
                validationEl.classList.add('hidden');
                return;
            }

            // Dapatkan seluruh wilayah terdaftar dari opsi dropdown
            var registeredRegions = Array.from(selectWilayah.options)
                .map(o => o.value)
                .filter(val => val && val !== 'konsultasi');

            // Normalisasi alamat untuk pencocokan
            var normalizedAddr = tempAddr.toLowerCase();

            // Deteksi apakah alamat masuk ke salah satu wilayah terdaftar
            var detectedRegion = null;
            for (var i = 0; i < registeredRegions.length; i++) {
                var r = registeredRegions[i];
                var rKeyword = r.toLowerCase()
                    .replace('kota', '')
                    .replace('kabupaten', '')
                    .replace('kab.', '')
                    .replace('kecamatan', '')
                    .replace('kec.', '')
                    .trim();

                if (normalizedAddr.includes(rKeyword)) {
                    detectedRegion = r;
                    break;
                }
            }

            validationEl.classList.remove('hidden');

            // Hapus kelas warna tombol konfirmasi agar bisa diset dinamis
            btnConfirm.classList.remove('bg-slate-400', 'bg-amber-600', 'hover:bg-amber-700', 'bg-[#1e40af]', 'hover:bg-[#1e3a8a]', 'opacity-60', 'cursor-not-allowed');

            // Kasus 1: Wilayah Tidak Terdaftar
            if (!detectedRegion) {
                // Kunci tombol konfirmasi alamat
                btnConfirm.disabled = true;
                btnConfirm.classList.add('bg-slate-400', 'opacity-60', 'cursor-not-allowed');
                btnConfirm.textContent = "Wilayah Tidak Terjangkau";
                delete btnConfirm.dataset.pendingRegion;

                // Kunci select wilayah layanan dan reset nilainya
                selectWilayah.disabled = true;
                selectWilayah.value = "";

                validationEl.className = "mt-2 text-xs font-semibold text-rose-600 flex flex-col gap-2.5 bg-rose-50 p-3.5 rounded-lg border border-rose-100";
                validationEl.innerHTML = `
                    <div class="flex items-start gap-2">
                        <i data-lucide="x-circle" class="w-4.5 h-4.5 shrink-0 mt-0.5 text-rose-500"></i>
                        <div>
                            <span class="block text-rose-800 font-bold mb-0.5">Lokasi Berada di Luar Wilayah Layanan R-NET</span>
                            <span class="block text-slate-600 font-medium leading-normal mb-1">Maaf, titik koordinat yang Anda tandai di peta berada di luar jangkauan wilayah layanan internet resmi kami saat ini.</span>
                        </div>
                    </div>
                    <a href="https://wa.me/6281373242873?text=Halo%20Admin%20R-NET,%20titik%20peta%20koordinat%20pemasangan%20saya%20terdeteksi%20di%20luar%20wilayah%20layanan.%20Apakah%20bisa%20dibantu%20cek%20lokasi%20saya%20berikut%3A%20${encodeURIComponent(tempAddr)}" target="_blank" class="flex items-center justify-center gap-1.5 w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-4 rounded-lg text-xs transition duration-150 shadow-sm text-center">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        Konsultasi Mengenai Lokasi (Hubungi Admin)
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
                btnConfirm.classList.add('bg-amber-600', 'hover:bg-amber-700');
                btnConfirm.textContent = "Konfirmasi Alamat & Pilih Wilayah";
                btnConfirm.dataset.pendingRegion = detectedRegion;

                validationEl.className = "mt-2 text-xs font-semibold text-amber-600 flex flex-col gap-2 bg-amber-50 p-3 rounded-lg border border-amber-100 animate-pulse";
                validationEl.innerHTML = `
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span>Terdeteksi di "${detectedRegion}". Klik tombol konfirmasi di samping untuk menyetujui alamat dan memilih wilayah ini secara otomatis.</span>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            // Kasus 3: Lokasi terdeteksi cocok dengan pilihan wilayah
            if (selectedVal === detectedRegion) {
                btnConfirm.classList.add('bg-[#1e40af]', 'hover:bg-[#1e3a8a]');
                btnConfirm.textContent = "Konfirmasi Alamat";
                delete btnConfirm.dataset.pendingRegion;

                validationEl.className = "mt-2 text-xs font-semibold text-emerald-600 flex items-center gap-1.5 bg-emerald-50 p-2.5 rounded-lg border border-emerald-100";
                validationEl.innerHTML = `
                    <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                    <span>Lokasi sesuai dengan wilayah jangkauan "${selectedVal}"</span>
                `;
            } else {
                // Kasus 4: Alamat terdaftar tetapi salah memilih wilayah
                btnConfirm.classList.add('bg-amber-600', 'hover:bg-amber-700');
                btnConfirm.textContent = "Konfirmasi Alamat & Sesuaikan Wilayah";
                btnConfirm.dataset.pendingRegion = detectedRegion;

                validationEl.className = "mt-2 text-xs font-semibold text-amber-600 flex flex-col gap-2 bg-amber-50 p-3 rounded-lg border border-amber-100";
                validationEl.innerHTML = `
                    <div class="flex items-start gap-1.5">
                        <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 mt-0.5"></i>
                        <div>
                            <span>Lokasi terdeteksi di "${detectedRegion}", tetapi Anda memilih "${selectedVal}". Klik konfirmasi di samping untuk menyesuaikan secara otomatis.</span>
                        </div>
                    </div>
                `;
            }

            // Re-render icons
            lucide.createIcons();
        }

        // Mapping koordinat pusat untuk masing-masing wilayah layanan
        var REGION_CENTERS = {
            'Kota Sungai Penuh': [-2.0594, 101.3789],
            'Kabupaten Kerinci': [-2.1158, 101.4485],
            'Kabupaten Merangin': [-2.1661, 102.2612]
        };

        // Listener untuk select wilayah
        document.getElementById('select-wilayah').addEventListener('change', function () {
            if (this.value === 'konsultasi') {
                window.open('https://wa.me/6281373242873?text=Halo%20Admin%20R-NET,%20saya%20ingin%20berkonsultasi%20mengenai%20wilayah%20layanan%20internet%20di%20lokasi%20saya.', '_blank');
                this.value = ""; // Reset kembali pilihan
            } else {
                var center = REGION_CENTERS[this.value];
                if (center) {
                    map.flyTo(center, 14); // Geser peta ke pusat wilayah yang dipilih secara dinamis!
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

            // Tampilkan feedback mengambang hijau nan mewah
            var successBanner = document.createElement('div');
            successBanner.className = "fixed bottom-5 right-5 z-[9999] bg-emerald-600 text-white font-bold px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-2 animate-bounce";
            successBanner.innerHTML = `<i data-lucide="check-circle" class="w-5 h-5"></i> <span>Alamat & Wilayah berhasil dikonfirmasi!</span>`;
            document.body.appendChild(successBanner);
            lucide.createIcons();
            setTimeout(() => {
                successBanner.classList.add('transition-opacity', 'duration-500', 'opacity-0');
                setTimeout(() => successBanner.remove(), 500);
            }, 3000);
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
                        marker.setLatLng([parseFloat(lat), parseFloat(lon)]);
                        syncLatLng({ lat: parseFloat(lat), lng: parseFloat(lon) });
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

            if (selectedVal && tempAddr && !tempAddr.includes("Geser peta") && !tempAddr.includes("Mencari")) {
                var normalizedAddr = tempAddr.toLowerCase();
                var keyword = selectedVal.toLowerCase()
                    .replace('kota', '')
                    .replace('kabupaten', '')
                    .replace('kab.', '')
                    .replace('kecamatan', '')
                    .replace('kec.', '')
                    .trim();

                var isMatched = normalizedAddr.includes(keyword);
                if (!isMatched) {
                    var confirmSubmit = confirm(`Perhatian: Lokasi yang Anda tandai di peta sepertinya berada di luar wilayah layanan "${selectedVal}" yang Anda pilih.\n\nApakah Anda yakin lokasi pemasangan sudah benar dan ingin melanjutkan pendaftaran?`);
                    if (!confirmSubmit) {
                        e.preventDefault();
                        return;
                    }
                }
            }

            var btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.textContent = 'Memproses Data...';
            btn.classList.add('opacity-70');
        });
    </script>
</body>

</html>
