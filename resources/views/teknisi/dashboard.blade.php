<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teknisi Dashboard - R-NET</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Leaflet Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Html5-Qrcode library for Webcam scanning -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        #interactive-map {
            height: 250px;
            width: 100%;
            border-radius: 12px;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-base-200 text-base-content min-h-screen pb-12 antialiased">

    <!-- Navbar -->
    <div class="navbar bg-base-100 shadow-sm border-b border-base-300 px-4 py-3 sticky top-0 z-50">
        <div class="flex-1">
            <a class="btn btn-ghost text-lg font-extrabold text-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21 16-4 4-4-4"/><path d="M17 20V4"/><path d="m3 8 4-4 4 4"/><path d="M7 4v16"/></svg>
                R-NET Teknisi
            </a>
        </div>
        <div class="flex-none gap-2">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-10 h-10">
                        <span class="font-bold text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                </div>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-300">
                    <li class="menu-title px-4 py-2 text-xs font-bold text-base-content/50">{{ Auth::user()->name }}</li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="p-0 m-0 w-full">
                            @csrf
                            <button type="submit" class="text-error w-full text-left py-2 px-4 hover:bg-base-200">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container mx-auto px-4 max-w-3xl mt-6 space-y-6">

        @if(session('success'))
        <div class="alert alert-success shadow-md rounded-xl animate-fade-in">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Profile & Welcome -->
        <div class="card bg-base-100 border border-base-300 shadow-sm overflow-hidden">
            <div class="card-body p-6 flex flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold text-lg shrink-0">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-base-content leading-none">Halo, {{ Auth::user()->name }}</h2>
                    <p class="text-xs text-base-content/60 mt-1.5">Teknisi Lapangan Aktif</p>
                </div>
            </div>
            <div class="grid grid-cols-2 divide-x divide-base-300 border-t border-base-300 bg-base-100/50 text-center py-4">
                <div>
                    <span class="block text-2xl font-black text-primary">{{ $activeTasks->count() }}</span>
                    <span class="text-[10px] uppercase font-bold text-base-content/40">Tugas Pemasangan</span>
                </div>
                <div>
                    <span class="block text-2xl font-black text-success">{{ $completedTasks->count() }}</span>
                    <span class="text-[10px] uppercase font-bold text-base-content/40">Instalasi Selesai</span>
                </div>
            </div>
        </div>

        <!-- Section: Active Tasks -->
        <div class="space-y-3">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-base-content/50 px-1 flex items-center gap-1.5">
                <i data-lucide="clock" class="w-4 h-4"></i>
                Tugas Instalasi Aktif
            </h3>

            @if($activeTasks->isEmpty())
            <div class="card bg-base-100 border border-base-300 shadow-sm p-8 text-center flex flex-col items-center justify-center space-y-3">
                <div class="w-16 h-16 rounded-full bg-base-200 flex items-center justify-center text-base-content/30">
                    <i data-lucide="clipboard-x" class="w-8 h-8"></i>
                </div>
                <h4 class="font-bold text-base text-base-content/85">Tidak Ada Tugas Aktif</h4>
                <p class="text-xs text-base-content/50 max-w-xs mx-auto">Saat ini belum ada pendaftaran pelanggan yang divalidasi oleh admin untuk dipasang.</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($activeTasks as $task)
                <div class="card bg-base-100 border border-base-300 shadow-sm hover:border-primary/40 transition-all">
                    <div class="card-body p-5 space-y-4">
                        <!-- Top Row: ID & Package -->
                        <div class="flex justify-between items-start">
                            <span class="font-mono font-bold text-xs text-primary bg-primary/10 px-2.5 py-1 rounded-md border border-primary/20">
                                #{{ $task->id_pendaftaran }}
                            </span>
                            <span class="badge badge-outline badge-sm font-bold text-[10px] py-2 px-2.5">
                                {{ $task->paket ? $task->paket->title_paket : $task->id_paket }}
                            </span>
                        </div>

                        <!-- Customer Details -->
                        <div class="space-y-2">
                            <h4 class="font-bold text-base text-base-content leading-tight">{{ $task->nama }}</h4>
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="tel:{{ $task->nomor_tlpn }}" class="btn btn-xs btn-outline btn-primary text-xs font-medium gap-1 rounded-lg">
                                    <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                                    {{ $task->nomor_tlpn }}
                                </a>
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', str_starts_with($task->nomor_tlpn, '0') ? '62' . substr($task->nomor_tlpn, 1) : $task->nomor_tlpn);
                                @endphp
                                <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($task->nama) }},%20saya%20teknisi%20R-NET%20ingin%20mengonfirmasi%20jadwal%20pemasangan%20internet%20Anda." target="_blank" rel="noopener noreferrer" class="btn btn-xs bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium gap-1 border-none rounded-lg">
                                    <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                    Hubungi WhatsApp
                                </a>
                            </div>
                            <p class="text-xs text-base-content/70 mt-1 leading-relaxed"><strong class="text-base-content/80">Alamat:</strong> {{ $task->alamat }} ({{ $task->wilayah }})</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 border-t border-base-300/60 pt-4">
                            <!-- Show Map Toggle -->
                            <button onclick="openMapModal('{{ $task->latitude }}', '{{ $task->longtitude }}', '{{ $task->nama }}')" class="btn btn-sm btn-ghost border border-base-300 text-xs font-semibold gap-1.5 w-full">
                                <i data-lucide="map-pin" class="w-4 h-4 text-error"></i>
                                Peta Lokasi
                            </button>
                            <!-- Google Maps Direction Link -->
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $task->latitude }},{{ $task->longtitude }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-ghost border border-base-300 text-xs font-semibold gap-1.5 w-full">
                                <i data-lucide="navigation" class="w-4 h-4 text-info"></i>
                                Petunjuk Arah
                            </a>
                            <!-- Document Install Button -->
                            <button onclick="openInstallModal('{{ $task->id_pendaftaran }}', '{{ $task->nama }}')" class="btn btn-sm btn-primary text-xs font-extrabold gap-1.5 w-full text-white">
                                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                                Dokumentasi
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Section: Completed Tasks -->
        <div class="space-y-3">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-base-content/50 px-1 flex items-center gap-1.5">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-success"></i>
                Instalasi Selesai Anda
            </h3>

            @if($completedTasks->isEmpty())
            <div class="card bg-base-100/50 border border-dashed border-base-300 p-6 text-center text-xs text-base-content/40 font-medium">
                Belum ada instalasi yang diselesaikan hari ini.
            </div>
            @else
            <div class="card bg-base-100 border border-base-300 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table table-zebra table-sm w-full">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>PON S/N</th>
                                <th>WiFi SSID & Pass</th>
                                <th class="text-right">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedTasks as $completed)
                            <tr class="text-xs">
                                <td class="font-semibold">{{ $completed->nama }}</td>
                                <td class="font-mono text-[10px]">{{ $completed->pon_sn }}</td>
                                <td>
                                    <div class="font-medium text-base-content">SSID: {{ $completed->wifi_name }}</div>
                                    <div class="text-[10px] text-base-content/50">Pass: {{ $completed->wifi_password }}</div>
                                </td>
                                <td class="text-right whitespace-nowrap text-[10px] text-base-content/60">
                                    {{ $completed->installed_at ? \Carbon\Carbon::parse($completed->installed_at)->format('d M y') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>

    <!-- MODAL: Leaflet Map Preview -->
    <dialog id="map_preview_modal" class="modal">
        <div class="modal-box p-5 max-w-md">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 id="map-modal-title" class="font-bold text-sm mb-3">Peta Lokasi</h3>
            
            <div class="relative overflow-hidden w-full h-[250px] rounded-xl border border-base-300 shadow-inner z-0">
                <div id="interactive-map"></div>
            </div>
            
            <div class="modal-action mt-4 justify-between items-center">
                <span class="text-[10px] text-base-content/40 font-mono">Geser/perbesar peta untuk melihat rincian jalur</span>
                <a id="map-modal-direct-btn" href="#" target="_blank" class="btn btn-sm btn-primary text-xs font-bold text-white">Buka Google Maps</a>
            </div>
        </div>
    </dialog>

    <!-- MODAL: Barcode Scanner Webcam -->
    <dialog id="barcode_scanner_modal" class="modal z-[60]">
        <div class="modal-box p-4 max-w-sm">
            <h3 class="font-bold text-base mb-3 flex items-center gap-1.5">
                <i data-lucide="qr-code" class="w-5 h-5 text-primary"></i>
                Scan Barcode Perangkat
            </h3>
            
            <!-- Scanning Container -->
            <div class="relative w-full aspect-square bg-black rounded-xl overflow-hidden border border-base-300 flex items-center justify-center">
                <div id="reader" class="w-full h-full"></div>
            </div>
            
            <div class="modal-action mt-4 justify-between">
                <span class="text-xs text-base-content/50 font-medium self-center">Arahkan kamera ke barcode S/N ONT</span>
                <button onclick="stopScanning()" class="btn btn-sm btn-ghost border border-base-300">Tutup</button>
            </div>
        </div>
    </dialog>

    <!-- MODAL: Form Dokumentasi Instalasi -->
    <dialog id="install_documentation_modal" class="modal">
        <div class="modal-box max-w-md">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-base mb-1">Dokumentasi Pemasangan Baru</h3>
            <p id="install-modal-cust" class="text-xs text-base-content/50 mb-6 font-semibold">Pelanggan: -</p>
            
            <form id="install_form" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- PON S/N -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wide text-base-content/75">GPON Modem Serial Number (PON S/N)</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="pon_sn" id="input_pon_sn" class="input input-bordered grow font-mono text-sm uppercase" placeholder="Contoh: ZTEGCxxxxxxx" required />
                        <button type="button" onclick="startScanning('input_pon_sn')" class="btn btn-primary btn-square text-white" title="Scan Barcode via Kamera">
                            <i data-lucide="scan-barcode" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <span class="text-[10px] text-base-content/40 mt-1">Gunakan pemindai barcode kamera untuk memindai PON S/N secara otomatis atau ketik manual.</span>
                </div>

                <!-- WiFi SSID -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wide text-base-content/75">Nama WiFi (SSID)</span>
                    </label>
                    <input type="text" name="wifi_name" id="input_wifi_name" class="input input-bordered w-full font-sans text-sm" placeholder="Contoh: R-NET @ Budi" required />
                </div>

                <!-- WiFi Password -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wide text-base-content/75">Password WiFi</span>
                    </label>
                    <input type="text" name="wifi_password" class="input input-bordered w-full font-mono text-sm" placeholder="Contoh: budi12345" required />
                </div>

                <!-- Foto Bukti Pemasangan -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-bold text-xs uppercase tracking-wide text-base-content/75">Foto Bukti Instalasi</span>
                    </label>
                    <input type="file" name="bukti_foto" class="file-input file-input-bordered file-input-primary w-full text-sm" accept="image/png, image/jpeg, image/jpg" required />
                    <span class="text-[10px] text-base-content/40 mt-1">Unggah foto bukti pemasangan perangkat di rumah pelanggan (Maks. 2MB).</span>
                </div>

                <!-- Action Button -->
                <div class="modal-action border-t border-base-200 pt-4 mt-6">
                    <button type="submit" class="btn btn-success text-white w-full font-bold gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Simpan Dokumentasi & Aktifkan
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Map & Scanner Controller Logic -->
    <script>
        let map;
        let marker;
        let html5QrCode;

        // Open Map Modal and plot leaflet coordinates
        function openMapModal(lat, lng, name) {
            const modal = document.getElementById('map_preview_modal');
            document.getElementById('map-modal-title').textContent = `Peta Lokasi: ${name}`;
            document.getElementById('map-modal-direct-btn').href = `https://maps.google.com/?q=${lat},${lng}`;
            
            modal.showModal();
            
            setTimeout(() => {
                // Initialize map if it doesn't exist
                if (!map) {
                    map = L.map('interactive-map').setView([parseFloat(lat), parseFloat(lng)], 14);
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                        maxZoom: 20
                    }).addTo(map);
                } else {
                    map.setView([parseFloat(lat), parseFloat(lng)], 14);
                }
                
                // Add or reposition marker
                if (marker) {
                    marker.setLatLng([parseFloat(lat), parseFloat(lng)]);
                } else {
                    marker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(map);
                }
                
                // Force leaflet to re-verify size constraints
                map.invalidateSize();
            }, 250);
        }

        // Open Install Documentation modal
        function openInstallModal(id, name) {
            const modal = document.getElementById('install_documentation_modal');
            document.getElementById('install-modal-cust').textContent = `Pelanggan: ${name} (#${id})`;
            document.getElementById('install_form').action = `/teknisi/install/${id}`;
            document.getElementById('input_wifi_name').value = `R-NET @ ${name}`;
            modal.showModal();
        }

        // Webcam Barcode & QR code scanning engine
        function startScanning(inputId) {
            document.getElementById('barcode_scanner_modal').showModal();
            
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 15, qrbox: { width: 250, height: 250 } };
            
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    document.getElementById(inputId).value = decodedText.trim().toUpperCase();
                    stopScanning();
                    // Play scanner audio feedback
                    try {
                        const audio = new Audio("data:audio/wav;base64,UklGRigAAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQQAAAAAAAAGAA==");
                        audio.play();
                    } catch (e) {}
                },
                (errorMessage) => {
                    // Failures happen on every frame without a match, ignore them.
                }
            ).catch((err) => {
                console.error("Gagal memulai kamera: ", err);
                alert("Gagal mengakses kamera. Silakan masukkan nomor serial secara manual.");
                document.getElementById('barcode_scanner_modal').close();
            });
        }

        function stopScanning() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    document.getElementById('barcode_scanner_modal').close();
                }).catch((err) => {
                    console.error("Gagal menghentikan kamera: ", err);
                    document.getElementById('barcode_scanner_modal').close();
                });
            } else {
                document.getElementById('barcode_scanner_modal').close();
            }
        }

        // Initialize Lucide icons on document ready
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

</body>

</html>
