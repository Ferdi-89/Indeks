<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar R-NET - Internet Rakyat</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
    </style>
</head>

<body class="min-h-screen bg-[#f1f5f9] antialiased pb-20">

    <!-- Navbar Premium -->


    <main class="max-w-7xl mx-auto px-6 md:px-12 pt-12 md:pt-20 grid lg:grid-cols-12 gap-12 md:gap-16">

        <!-- Left Column -->
        <div class="lg:col-span-5 space-y-8">
            <a href="/"
                class="flex items-center gap-2 text-blue-600 font-semibold text-sm hover:underline hover:translate-x-[-4px] transition-transform">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>

            <div class="space-y-4">
                <p class="text-xs font-bold text-blue-600 tracking-wider uppercase">Mulai Sekarang</p>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.1]">
                    Daftar Layanan
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Isi formulir pendaftaran untuk mulai menggunakan layanan internet berkecepatan tinggi dari R-NET.
                </p>
            </div>

            <div class="bg-white p-6 text-slate-700 text-sm shadow-sm border border-slate-200 rounded-2xl">
                <p class="font-bold mb-2 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-blue-600"></i> Penting:
                </p>
                <p class="opacity-90 leading-relaxed">Pastikan koordinat lokasi pada form diisi dengan akurat agar
                    teknisi dapat mengetahui titik pasti kediaman Anda.</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-slate-200">
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-10">
                    @csrf

                    <!-- Informasi Pribadi -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-xl text-slate-800">Informasi Pribadi</h3>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Nama Lengkap<span
                                        class="text-red-500 ml-1">*</span></label>
                                <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda"
                                    value="{{ old('nama') }}" required
                                    class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none text-sm">
                                @error('nama') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Nomor Telepon<span
                                            class="text-red-500 ml-1">*</span></label>
                                    <div
                                        class="flex border border-slate-200 rounded-xl overflow-hidden focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition">
                                        <span
                                            class="flex items-center px-4 bg-slate-100 border-r border-slate-200 text-sm text-slate-500 font-bold">+62</span>
                                        <input type="tel" name="nomor_telp" placeholder="812-3456-7890"
                                            value="{{ old('nomor_telp') }}" required
                                            class="w-full px-4 py-3.5 outline-none text-sm bg-slate-50 focus:bg-white transition">
                                    </div>
                                    @error('nomor_telp') <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Email Utama<span
                                            class="text-red-500 ml-1">*</span></label>
                                    <input type="email" name="email" placeholder="email@anda.com"
                                        value="{{ old('email') }}" required
                                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none text-sm font-medium">
                                    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Alamat -->
                    <div class="space-y-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-xl text-slate-800">Informasi Alamat</h3>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Koordinat Lokasi<span
                                        class="text-red-500 ml-1">*</span></label>
                                <div id="map"
                                    class="h-72 rounded-2xl border border-slate-200 shadow-inner overflow-hidden"></div>
                                <input type="hidden" name="latitude" id="lat" value="{{ old('latitude', -6.2) }}">
                                <input type="hidden" name="longitude" id="long" value="{{ old('longitude', 106.8) }}">
                                <p class="text-[11px] text-slate-400 mt-2 italic">Geser pin merah pada peta ke lokasi
                                    rumah Anda secara tepat.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Properti -->
                    <div class="space-y-6 pt-6 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl">
                                <i data-lucide="home" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-xl text-slate-800">Foto Properti</h3>
                        </div>

                        <div class="space-y-4">
                            <label class="text-sm font-bold text-slate-700">Upload Foto Rumah / KTP<span
                                    class="text-red-500 ml-1">*</span></label>

                            <div
                                class="relative group border-2 border-dashed border-slate-200 p-8 rounded-2xl bg-slate-50 hover:bg-slate-100 hover:border-blue-400 transition-all cursor-pointer text-center">
                                <input type="file" name="path_gambar" id="file-input"
                                    class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                                <div class="space-y-3" id="upload-placeholder">
                                    <div
                                        class="mx-auto w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-blue-600">
                                        <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                    </div>
                                    <div class="text-sm font-bold text-slate-700">Klik untuk upload foto</div>
                                    <div class="text-xs text-slate-400">PNG, JPG, JPEG (Max. 2MB)</div>
                                </div>
                                <div id="preview-container" class="hidden space-y-3">
                                    <img id="image-preview" src="#" alt="Preview"
                                        class="mx-auto h-32 object-cover rounded-lg shadow-md border border-white">
                                    <p class="text-xs font-bold text-blue-600">Klik untuk mengganti foto</p>
                                </div>
                            </div>
                            @error('path_gambar') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-[#1e40af] text-white font-extrabold px-8 py-4 rounded-2xl hover:bg-[#1e3a8a] transition shadow-xl shadow-blue-900/10 transform hover:-translate-y-1 active:translate-y-0">
                            Kirim Pendaftaran
                        </button>
                        <p class="text-[11px] text-center text-slate-400 font-medium mt-6 leading-relaxed">
                            Dengan mengirim formulir ini, Anda setuju dengan <br>
                            <span class="text-blue-600 font-bold hover:underline cursor-pointer">Syarat Layanan</span>
                            dan <span class="text-blue-600 font-bold hover:underline cursor-pointer">Kebijakan
                                Privasi</span> kami.
                        </p>
                    </div>
                </form>
            </div>

            <!-- Support Box -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center gap-6">
                <div class="bg-blue-50 p-4 rounded-2xl text-blue-600 shrink-0">
                    <i data-lucide="headphones" class="w-8 h-8"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-800 text-lg">Butuh Bantuan?</h4>
                    <p class="text-sm text-slate-500 mt-1 mb-4 font-medium">Tim layanan kami tersedia 24/7 untuk
                        membantu Anda.</p>
                    <div class="flex flex-wrap gap-6 text-sm font-bold">
                        <a href="tel:+6281373242873"
                            class="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition">
                            <i data-lucide="phone" class="w-4 h-4 text-blue-600 fill-current"></i> 0813-7324-2873
                        </a>
                        <a href="#" class="flex items-center gap-2 text-green-600 hover:text-green-700 transition">
                            <i data-lucide="message-square" class="w-4 h-4 fill-current"></i> Dukungan WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Peta / Map
        var map = L.map('map').setView([-6.2, 106.8], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([-6.2, 106.8], { draggable: true }).addTo(map);
        marker.on('dragend', function (event) {
            var position = marker.getLatLng();
            document.getElementById('lat').value = position.lat;
            document.getElementById('long').value = position.lng;
        });

        // Image Preview
        const fileInput = document.getElementById('file-input');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('image-preview');

        fileInput.onchange = evt => {
            const [file] = fileInput.files;
            if (file) {
                previewImage.src = URL.createObjectURL(file);
                placeholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>