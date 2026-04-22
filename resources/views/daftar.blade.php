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

            <div class="bg-white p-4 text-slate-700 text-sm shadow-sm border border-slate-200 rounded-xl mt-6">
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
                                    class="w-full px-4 py-3 bg-[#f8fafc] border border-slate-200 rounded-lg transition focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-sm outline-none">
                                @error('nama') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="text-sm font-semibold text-slate-700 flex items-center">
                                        Nomor Telepon<span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div
                                        class="flex w-full bg-[#f8fafc] border border-slate-200 rounded-lg overflow-hidden focus-within:ring-1 focus-within:bg-white focus-within:ring-blue-500 focus-within:border-blue-500 transition">
                                        <span
                                            class="flex items-center justify-center px-3 bg-slate-50 border-r border-slate-200 text-sm text-slate-500 font-semibold shadow-inner">
                                            +62
                                        </span>
                                        <input type="tel" name="nomor_tlpn" placeholder="812-3456-7890"
                                            value="{{ old('nomor_tlpn') }}" required minlength="8"
                                            class="w-full px-3 py-3 outline-none text-sm bg-transparent">
                                    </div>
                                    @error('nomor_tlpn') <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-sm font-semibold text-slate-700 flex items-center">
                                        Email Utama<span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="email" name="email" placeholder="email@anda.com"
                                        value="{{ old('email') }}" maxlength="100" required
                                        class="w-full px-4 py-3 bg-[#f8fafc] border border-slate-200 rounded-lg transition focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-sm outline-none">
                                    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
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
                                    Koordinat Lokasi<span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="w-full">
                                    <div id="map"
                                        class="h-72 rounded-lg border border-slate-200 shadow-inner overflow-hidden">
                                    </div>
                                    <input type="hidden" name="latitude" id="lat" value="{{ old('latitude', -6.2) }}">
                                    <input type="hidden" name="longtitude" id="long"
                                        value="{{ old('longtitude', 106.8) }}">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-semibold text-slate-700 flex items-center">
                                    Alamat Lengkap<span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea id="alamat-input" name="alamat" rows="3" required
                                    class="w-full px-4 py-3 bg-[#f8fafc] border border-slate-200 rounded-lg transition focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 resize-none text-sm outline-none"
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
                                class="relative border border-slate-200 rounded-xl transition hover:border-blue-400 bg-[#f8fafc] overflow-hidden">
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
                            class="w-full bg-[#1e40af] text-white font-bold px-8 py-3.5 rounded-lg hover:bg-[#1e3a8a] transition shadow text-sm disabled:opacity-70 flex items-center justify-center">
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

        // ── Leaflet Map ────────────────────────────────────────────────────
        var defaultLat = parseFloat(document.getElementById('lat').value) || -6.2;
        var defaultLong = parseFloat(document.getElementById('long').value) || 106.8;

        var map = L.map('map').setView([defaultLat, defaultLong], 13);
        var marker = L.marker([defaultLat, defaultLong], { draggable: false }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        function syncLatLng(latlng) {
            document.getElementById('lat').value = latlng.lat;
            document.getElementById('long').value = latlng.lng;
        }

        // Handler to set address specifically requested from the map interaction
        var isMapSelected = false;
        function handleSetAddressMap(addr, isFromMap) {
            if (isFromMap) {
                isMapSelected = true;
                document.getElementById('alamat-input').value = addr;

                // Release the flag after a buffer to allow future manual typings
                setTimeout(function () {
                    isMapSelected = false;
                }, 5000); // Wait 5 seconds to stop jumpy backwards API fetches
            }
        }

        // Click on map to move marker + reverse-geocode → handleSetAddressMap
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            syncLatLng(e.latlng);

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`, {
                headers: { 'Accept-Language': 'id-ID,id;q=0.9' }
            })
                .then(function (r) {
                    if (!r.ok) throw new Error(`HTTP error! status: ${r.status}`);
                    return r.json();
                })
                .then(function (data) {
                    if (data && data.display_name) {
                        handleSetAddressMap(data.display_name, true);
                    }
                })
                .catch(function (err) {
                    console.warn("Geocode lookup gracefully aborted (rate limit/network issue):", err);
                });
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

        // ── Image Preview ──────────────────────────────────────────────────
        var fileInput = document.getElementById('file-input');
        var previewContainer = document.getElementById('preview-container');
        var previewImage = document.getElementById('image-preview');
        var uploadLabel = document.getElementById('upload-label');

        fileInput.addEventListener('change', function () {
            var file = fileInput.files[0];
            if (!file) return;

            // 1 MB guard
            if (file.size > 1048576) {
                alert('Ukuran file maksimal 1 MB.');
                fileInput.value = '';
                return;
            }

            previewImage.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('flex');
            uploadLabel.textContent = 'Klik untuk mengganti gambar';
        });

        // ── Submit loading state ───────────────────────────────────────────
        document.querySelector('form').addEventListener('submit', function () {
            var btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.textContent = 'Memproses Data...';
            btn.classList.add('opacity-70');
        });
    </script>
</body>

</html>