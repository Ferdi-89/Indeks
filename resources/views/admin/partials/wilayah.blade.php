<!-- Wilayah / Area Layanan Partial -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Wilayah Layanan</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola area layanan operasional perusahaan</p>
    </div>
    <button onclick="openTambahAreaModal()" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Area
    </button>
</div>

<div class="bg-base-100 rounded-xl shadow-sm border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200 text-base-content">
                    <th>ID</th>
                    <th>Nama Wilayah / Area</th>
                    <th>Koordinat Pusat</th>
                    <th>Radius Jangkauan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areaLayanan as $area)
                <tr>
                    <td class="font-mono text-sm">{{ $area->id }}</td>
                    <td class="font-medium">{{ $area->nama_area }}</td>
                    <td class="font-mono text-xs">
                        @if($area->latitude && $area->longitude)
                            {{ number_format($area->latitude, 6) }}, {{ number_format($area->longitude, 6) }}
                        @else
                            <span class="text-base-content/40">- Belum diatur -</span>
                        @endif
                    </td>
                    <td>
                        @if($area->radius)
                            {{ number_format($area->radius) }} meter
                        @else
                            <span class="text-base-content/40">- Belum diatur -</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $area->is_active ? 'badge-success' : 'badge-error' }} badge-sm">
                            {{ $area->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <!-- Toggle Hide Button -->
                            <form action="{{ route('admin.area.toggle_hide', $area->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-square btn-ghost {{ $area->is_active ? 'text-success' : 'text-base-content/50' }}" title="{{ $area->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                    @if($area->is_active)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                            </form>
                            <!-- Edit Button -->
                            <button onclick="openEditAreaModal({{ $area->id }}, {{ $area->latitude ?? -2.0337714 }}, {{ $area->longitude ?? 101.3963373 }}, {{ $area->radius ?? 1000 }})" class="btn btn-sm btn-square btn-ghost text-warning" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('admin.area.destroy', $area->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-square btn-ghost text-error" onclick="return confirm('Hapus area {{ $area->nama_area }}?')" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-base-content/50">Belum ada wilayah layanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Area Layanan -->
<dialog id="modal_tambah_area" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
        <h3 class="font-bold text-lg mb-4">Tambah Wilayah Layanan</h3>
        <form action="{{ route('admin.area.store') }}" method="POST">
            @csrf
            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-medium">Nama Area / Wilayah</span></label>
                <input type="text" name="nama_area" class="input input-bordered w-full" placeholder="cth: Kel. Cikaret, Kec. Bogor Selatan" required autofocus>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-xs">Latitude</span></label>
                    <input type="number" step="any" name="latitude" id="tambah_latitude" class="input input-bordered w-full text-sm bg-base-200" required readonly>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-xs">Longitude</span></label>
                    <input type="number" step="any" name="longitude" id="tambah_longitude" class="input input-bordered w-full text-sm bg-base-200" required readonly>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-xs">Radius Jangkauan (meter)</span></label>
                    <input type="number" name="radius" id="tambah_radius" class="input input-bordered w-full text-sm" oninput="updateTambahCircle()" required>
                </div>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-medium">Klik Peta untuk Memilih Pusat Wilayah Layanan</span></label>
                <div id="map_tambah" class="w-full h-64 rounded-lg border border-base-300 z-0"></div>
            </div>

            <div class="modal-action">
                <button type="button" onclick="document.getElementById('modal_tambah_area').close()" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Area</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@foreach($areaLayanan as $area)
<!-- Modal Edit Area Layanan -->
<dialog id="modal_edit_area_{{ $area->id }}" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
        <h3 class="font-bold text-lg mb-4">Edit Wilayah Layanan</h3>
        <form action="{{ route('admin.area.update', $area->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-medium">Nama Area / Wilayah</span></label>
                <input type="text" name="nama_area" class="input input-bordered w-full" value="{{ $area->nama_area }}" required>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-xs">Latitude</span></label>
                    <input type="number" step="any" name="latitude" id="edit_latitude_{{ $area->id }}" class="input input-bordered w-full text-sm bg-base-200" value="{{ $area->latitude }}" required readonly>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-xs">Longitude</span></label>
                    <input type="number" step="any" name="longitude" id="edit_longitude_{{ $area->id }}" class="input input-bordered w-full text-sm bg-base-200" value="{{ $area->longitude }}" required readonly>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-xs">Radius Jangkauan (meter)</span></label>
                    <input type="number" name="radius" id="edit_radius_{{ $area->id }}" class="input input-bordered w-full text-sm" value="{{ $area->radius ?? 1000 }}" oninput="updateEditCircle({{ $area->id }})" required>
                </div>
            </div>

            <div class="form-control mb-4">
                <label class="label"><span class="label-text font-medium">Klik Peta untuk Mengubah Pusat Wilayah Layanan</span></label>
                <div id="map_edit_{{ $area->id }}" class="w-full h-64 rounded-lg border border-base-300 z-0"></div>
            </div>

            <input type="hidden" name="is_active" value="{{ $area->is_active ? 1 : 0 }}">
            <div class="modal-action">
                <button type="button" onclick="document.getElementById('modal_edit_area_{{ $area->id }}').close()" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>
@endforeach

<script>
    (function() {
        const LEAFLET_CSS = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        const LEAFLET_JS  = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';

        let mapTambah = null;
        let markerTambah = null;
        let circleTambah = null;
        const editMaps = {};

        window.openTambahAreaModal = function() {
            const modal = document.getElementById('modal_tambah_area');
            modal.showModal();

            // Lazy-load Leaflet and initialize map
            loadStyle(LEAFLET_CSS);
            loadScript(LEAFLET_JS, () => {
                setTimeout(() => {
                    const defaultLat = -2.0337714;
                    const defaultLng = 101.3963373;
                    const defaultRadius = 1000;

                    // Set initial inputs
                    document.getElementById('tambah_latitude').value = defaultLat;
                    document.getElementById('tambah_longitude').value = defaultLng;
                    document.getElementById('tambah_radius').value = defaultRadius;

                    if (!mapTambah) {
                        mapTambah = L.map('map_tambah').setView([defaultLat, defaultLng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(mapTambah);

                        markerTambah = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(mapTambah);
                        circleTambah = L.circle([defaultLat, defaultLng], {
                            radius: defaultRadius,
                            color: '#2563eb',
                            fillColor: '#3b82f6',
                            fillOpacity: 0.2
                        }).addTo(mapTambah);

                        // Update inputs on marker drag
                        markerTambah.on('dragend', function(e) {
                            const position = markerTambah.getLatLng();
                            document.getElementById('tambah_latitude').value = position.lat.toFixed(7);
                            document.getElementById('tambah_longitude').value = position.lng.toFixed(7);
                            circleTambah.setLatLng(position);
                        });

                        // Update on map click
                        mapTambah.on('click', function(e) {
                            markerTambah.setLatLng(e.latlng);
                            circleTambah.setLatLng(e.latlng);
                            document.getElementById('tambah_latitude').value = e.latlng.lat.toFixed(7);
                            document.getElementById('tambah_longitude').value = e.latlng.lng.toFixed(7);
                        });
                    } else {
                        mapTambah.setView([defaultLat, defaultLng], 13);
                        markerTambah.setLatLng([defaultLat, defaultLng]);
                        circleTambah.setLatLng([defaultLat, defaultLng]);
                        circleTambah.setRadius(defaultRadius);
                    }
                    mapTambah.invalidateSize();
                }, 200);
            });
        };

        window.updateTambahCircle = function() {
            const radius = parseInt(document.getElementById('tambah_radius').value) || 1000;
            if (circleTambah) {
                circleTambah.setRadius(radius);
            }
        };

        window.openEditAreaModal = function(id, lat, lng, radius) {
            const modal = document.getElementById('modal_edit_area_' + id);
            modal.showModal();

            loadStyle(LEAFLET_CSS);
            loadScript(LEAFLET_JS, () => {
                setTimeout(() => {
                    const defaultLat = lat || -2.0337714;
                    const defaultLng = lng || 101.3963373;
                    const defaultRadius = radius || 1000;

                    // Set inputs
                    document.getElementById('edit_latitude_' + id).value = defaultLat;
                    document.getElementById('edit_longitude_' + id).value = defaultLng;
                    document.getElementById('edit_radius_' + id).value = defaultRadius;

                    if (!editMaps[id]) {
                        const map = L.map('map_edit_' + id).setView([defaultLat, defaultLng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);

                        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
                        const circle = L.circle([defaultLat, defaultLng], {
                            radius: defaultRadius,
                            color: '#2563eb',
                            fillColor: '#3b82f6',
                            fillOpacity: 0.2
                        }).addTo(map);

                        editMaps[id] = { map, marker, circle };

                        marker.on('dragend', function(e) {
                            const position = marker.getLatLng();
                            document.getElementById('edit_latitude_' + id).value = position.lat.toFixed(7);
                            document.getElementById('edit_longitude_' + id).value = position.lng.toFixed(7);
                            circle.setLatLng(position);
                        });

                        map.on('click', function(e) {
                            marker.setLatLng(e.latlng);
                            circle.setLatLng(e.latlng);
                            document.getElementById('edit_latitude_' + id).value = e.latlng.lat.toFixed(7);
                            document.getElementById('edit_longitude_' + id).value = e.latlng.lng.toFixed(7);
                        });
                    } else {
                        editMaps[id].map.setView([defaultLat, defaultLng], 13);
                        editMaps[id].marker.setLatLng([defaultLat, defaultLng]);
                        editMaps[id].circle.setLatLng([defaultLat, defaultLng]);
                        editMaps[id].circle.setRadius(defaultRadius);
                    }
                    editMaps[id].map.invalidateSize();
                }, 200);
            });
        };

        window.updateEditCircle = function(id) {
            const radius = parseInt(document.getElementById('edit_radius_' + id).value) || 1000;
            if (editMaps[id] && editMaps[id].circle) {
                editMaps[id].circle.setRadius(radius);
            }
        };
    })();
</script>
