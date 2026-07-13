<!-- Wilayah / Area Layanan Partial -->
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-2xl font-bold text-base-content">Wilayah Layanan</h3>
            <p class="text-sm text-base-content/60 mt-1">Kelola radius operasional & cakupan area jaringan pelanggan R-NET</p>
        </div>
        <button onclick="openTambahAreaModal()" class="btn btn-primary gap-2 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Area
        </button>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="card bg-base-100 border border-base-200 shadow-sm p-4 flex flex-row items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-base-content/40 uppercase">Total Area</span>
                <span class="text-xl font-extrabold text-base-content">{{ $areaLayanan->count() }}</span>
            </div>
        </div>
        <div class="card bg-base-100 border border-base-200 shadow-sm p-4 flex flex-row items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-success/10 text-success flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-base-content/40 uppercase">Area Aktif</span>
                <span class="text-xl font-extrabold text-success">{{ $areaLayanan->where('is_active', true)->count() }}</span>
            </div>
        </div>
        <div class="card bg-base-100 border border-base-200 shadow-sm p-4 flex flex-row items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-error/10 text-error flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/></svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-base-content/40 uppercase">Non-Aktif</span>
                <span class="text-xl font-extrabold text-error">{{ $areaLayanan->where('is_active', false)->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="card bg-base-100 rounded-xl shadow-sm border border-base-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr class="bg-base-200 text-base-content">
                        <th class="w-16">ID</th>
                        <th>Nama Wilayah / Area</th>
                        <th>Koordinat Pusat</th>
                        <th>Radius Jangkauan</th>
                        <th>Status</th>
                        <th class="text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areaLayanan as $area)
                    <tr class="hover">
                        <td class="font-mono text-xs text-base-content/50">#{{ $area->id }}</td>
                        <td class="font-bold text-base-content/85">{{ $area->nama_area }}</td>
                        <td>
                            @if($area->latitude && $area->longitude)
                                <span class="badge badge-ghost font-mono text-[11px] py-2 px-2.5 border border-base-300">
                                    {{ number_format($area->latitude, 6) }}, {{ number_format($area->longitude, 6) }}
                                </span>
                            @else
                                <span class="text-base-content/30 italic text-xs">Belum diatur</span>
                            @endif
                        </td>
                        <td>
                            @if($area->radius)
                                <span class="badge badge-primary badge-outline font-semibold text-xs py-2 px-2.5">
                                    {{ number_format($area->radius) }} meter
                                </span>
                            @else
                                <span class="text-base-content/30 italic text-xs">Belum diatur</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full {{ $area->is_active ? 'bg-success animate-pulse' : 'bg-error' }}"></span>
                                <span class="text-xs font-bold {{ $area->is_active ? 'text-success' : 'text-error' }}">
                                    {{ $area->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="flex justify-center gap-1.5">
                                <!-- Toggle Hide -->
                                <form action="{{ route('admin.area.toggle_hide', $area->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn btn-sm btn-ghost btn-square {{ $area->is_active ? 'text-success hover:bg-success/15' : 'text-base-content/40 hover:bg-base-300' }}" 
                                            title="{{ $area->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                        @if($area->is_active)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                        @endif
                                    </button>
                                </form>
                                
                                <!-- Edit Button -->
                                <button onclick="openEditAreaModal({{ $area->id }}, {{ $area->latitude ?? -2.0337714 }}, {{ $area->longitude ?? 101.3963373 }}, {{ $area->radius ?? 1000 }})" 
                                        class="btn btn-sm btn-ghost btn-square text-warning hover:bg-warning/15" 
                                        title="Edit Area">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.area.destroy', $area->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-ghost btn-square text-error hover:bg-error/15" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus wilayah {{ $area->nama_area }}?')" 
                                            title="Hapus Area">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-base-content/40">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/30"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>Belum ada wilayah layanan yang terdaftar.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Area Layanan -->
<dialog id="modal_tambah_area" class="modal backdrop-blur-sm">
    <div class="modal-box w-11/12 max-w-5xl p-6 rounded-3xl border border-base-300 shadow-2xl relative overflow-hidden bg-base-100">
        <!-- Floating neon top line -->
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-primary to-accent"></div>

        <h3 class="font-black text-lg mb-1 flex items-center gap-2 text-base-content">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Tambah Wilayah Layanan Baru
        </h3>
        <p class="text-xs text-base-content/50 mb-6">Buat titik operasional & konfigurasi jangkauan area jaringan pelanggan baru.</p>
        
        <form action="{{ route('admin.area.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column: Inputs & Controls -->
                <div class="lg:col-span-4 space-y-5">
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text font-bold text-xs uppercase text-base-content/70">Nama Area / Wilayah</span></label>
                        <input type="text" name="nama_area" class="input input-bordered w-full rounded-xl focus:border-primary/50 text-sm font-medium" placeholder="cth: Kel. Cikaret, Kec. Bogor" required autofocus>
                    </div>

                    <div class="form-control">
                        <label class="label py-1"><span class="label-text font-bold text-xs uppercase text-primary/85 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> Cari Lokasi Instan</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-base-content/40">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </div>
                            <input type="text" id="search_area_tambah_input" class="input input-bordered w-full pl-9 pr-16 text-xs rounded-xl focus:border-primary/50" placeholder="Ketik nama kota..." onkeydown="if(event.key === 'Enter') { event.preventDefault(); searchLocationTambah(); }">
                            <button type="button" onclick="searchLocationTambah()" class="btn btn-primary btn-xs absolute right-1.5 top-2.5 rounded-lg text-white font-bold px-3">Cari</button>
                        </div>
                    </div>

                    <div class="form-control bg-base-200/40 border border-base-300/30 p-4 rounded-2xl">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold uppercase text-base-content/70">Radius Area</span>
                            <span class="badge badge-primary font-mono font-bold text-xs px-2.5 py-2 shrink-0 shadow-sm" id="tambah_radius_badge">1,000 meter</span>
                        </div>
                        <input type="range" id="tambah_radius" name="radius" min="100" max="10000" step="100" value="1000" class="range range-primary range-xs mt-2" oninput="updateTambahCircle(this.value)">
                        <div class="w-full flex justify-between text-[9px] px-1 text-base-content/40 font-mono mt-1">
                            <span>100 m</span>
                            <span>5 km</span>
                            <span>10 km</span>
                        </div>
                    </div>
                    
                    <input type="hidden" name="latitude" id="tambah_latitude" value="-2.0337714">
                    <input type="hidden" name="longitude" id="tambah_longitude" value="101.3963373">
                </div>
                
                <!-- Right Column: Massive Map with HUD -->
                <div class="lg:col-span-8 space-y-2">
                    <label class="label py-0"><span class="label-text font-bold text-xs uppercase text-base-content/75">Klik Peta / Seret Marker untuk Menentukan Pusat</span></label>
                    <div class="relative overflow-hidden w-full h-[380px] rounded-2xl border border-base-300 shadow-md">
                        <div id="map_tambah" class="w-full h-full z-0"></div>
                        <!-- Sleek HUD Overlay -->
                        <div class="absolute bottom-3 left-3 z-[1000] bg-base-100/95 backdrop-blur-md border border-base-300 p-3.5 rounded-2xl shadow-xl pointer-events-none text-[11px] font-mono space-y-1 min-w-[190px]">
                            <div class="flex items-center gap-1.5 mb-1.5"><span class="w-2 h-2 rounded-full bg-primary shrink-0 animate-ping"></span><strong class="text-base-content/80 text-[10px] uppercase tracking-wide">HUD Koordinat</strong></div>
                            <div class="text-base-content/70 flex justify-between gap-4"><span>Lat:</span><span id="hud_tambah_lat" class="font-bold text-primary">-2.0337714</span></div>
                            <div class="text-base-content/70 flex justify-between gap-4"><span>Lng:</span><span id="hud_tambah_lng" class="font-bold text-primary">101.3963373</span></div>
                            <div class="text-base-content/70 flex justify-between gap-4"><span>Radius:</span><span id="hud_tambah_rad" class="font-bold text-primary">1,000m</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-action border-t border-base-200 pt-4 mt-2">
                <button type="button" onclick="document.getElementById('modal_tambah_area').close()" class="btn btn-ghost rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary rounded-xl font-bold px-6">Tambah Area</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@foreach($areaLayanan as $area)
<!-- Modal Edit Area Layanan -->
<dialog id="modal_edit_area_{{ $area->id }}" class="modal backdrop-blur-sm">
    <div class="modal-box w-11/12 max-w-5xl p-6 rounded-3xl border border-base-300 shadow-2xl relative overflow-hidden bg-base-100">
        <!-- Floating neon top line -->
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-warning to-accent"></div>

        <h3 class="font-black text-lg mb-1 flex items-center gap-2 text-base-content">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-warning"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            Edit Wilayah Layanan: {{ $area->nama_area }}
        </h3>
        <p class="text-xs text-base-content/50 mb-6">Sesuaikan nama, koordinat pusat, atau radius jangkauan wilayah.</p>
        
        <form action="{{ route('admin.area.update', $area->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left Column: Inputs & Controls -->
                <div class="lg:col-span-4 space-y-5">
                    <div class="form-control">
                        <label class="label py-1"><span class="label-text font-bold text-xs uppercase text-base-content/75">Nama Area / Wilayah</span></label>
                        <input type="text" name="nama_area" class="input input-bordered w-full rounded-xl focus:border-warning/50 text-sm font-medium" value="{{ $area->nama_area }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label py-1"><span class="label-text font-bold text-xs uppercase text-warning flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> Cari Lokasi / Alamat Baru</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-base-content/40">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </div>
                            <input type="text" id="search_area_edit_input_{{ $area->id }}" class="input input-bordered w-full pl-9 pr-16 text-xs rounded-xl focus:border-warning/50" placeholder="Ketik lokasi baru..." onkeydown="if(event.key === 'Enter') { event.preventDefault(); searchLocationEdit({{ $area->id }}); }">
                            <button type="button" onclick="searchLocationEdit({{ $area->id }})" class="btn btn-warning btn-xs absolute right-1.5 top-2.5 rounded-lg text-amber-950 font-bold px-3">Cari</button>
                        </div>
                    </div>

                    <div class="form-control bg-base-200/40 border border-base-300/30 p-4 rounded-2xl">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold uppercase text-base-content/70">Radius Area</span>
                            <span class="badge badge-warning text-amber-950 font-mono font-bold text-xs px-2.5 py-2 shrink-0 shadow-sm" id="edit_radius_badge_{{ $area->id }}">{{ number_format($area->radius ?? 1000) }} meter</span>
                        </div>
                        <input type="range" id="edit_radius_{{ $area->id }}" name="radius" min="100" max="10000" step="100" value="{{ $area->radius ?? 1000 }}" class="range range-warning range-xs mt-2" oninput="updateEditCircle({{ $area->id }}, this.value)">
                        <div class="w-full flex justify-between text-[9px] px-1 text-base-content/40 font-mono mt-1">
                            <span>100 m</span>
                            <span>5 km</span>
                            <span>10 km</span>
                        </div>
                    </div>

                    <input type="hidden" name="latitude" id="edit_latitude_{{ $area->id }}" value="{{ $area->latitude }}">
                    <input type="hidden" name="longitude" id="edit_longitude_{{ $area->id }}" value="{{ $area->longitude }}">
                </div>

                <!-- Right Column: Massive Map with HUD -->
                <div class="lg:col-span-8 space-y-2">
                    <label class="label py-0"><span class="label-text font-bold text-xs uppercase text-base-content/75">Klik Peta / Seret Marker untuk Memindahkan Pusat</span></label>
                    <div class="relative overflow-hidden w-full h-[380px] rounded-2xl border border-base-300 shadow-md">
                        <div id="map_edit_{{ $area->id }}" class="w-full h-full z-0"></div>
                        <!-- Sleek HUD Overlay -->
                        <div class="absolute bottom-3 left-3 z-[1000] bg-base-100/95 backdrop-blur-md border border-base-300 p-3.5 rounded-2xl shadow-xl pointer-events-none text-[11px] font-mono space-y-1 min-w-[190px]">
                            <div class="flex items-center gap-1.5 mb-1.5"><span class="w-2 h-2 rounded-full bg-warning shrink-0 animate-ping"></span><strong class="text-base-content/80 text-[10px] uppercase tracking-wide">HUD Koordinat</strong></div>
                            <div class="text-base-content/70 flex justify-between gap-4"><span>Lat:</span><span id="hud_edit_lat_{{ $area->id }}" class="font-bold text-warning">{{ $area->latitude }}</span></div>
                            <div class="text-base-content/70 flex justify-between gap-4"><span>Lng:</span><span id="hud_edit_lng_{{ $area->id }}" class="font-bold text-warning">{{ $area->longitude }}</span></div>
                            <div class="text-base-content/70 flex justify-between gap-4"><span>Radius:</span><span id="hud_edit_rad_{{ $area->id }}" class="font-bold text-warning">{{ $area->radius ?? 1000 }}m</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="is_active" value="{{ $area->is_active ? 1 : 0 }}">
            <div class="modal-action border-t border-base-200 pt-4 mt-2">
                <button type="button" onclick="document.getElementById('modal_edit_area_{{ $area->id }}').close()" class="btn btn-ghost rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary rounded-xl font-bold px-6">Simpan Perubahan</button>
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

        // Integrated location search with OSM Nominatim API for Tambah Modal
        window.searchLocationTambah = function() {
            const query = document.getElementById('search_area_tambah_input').value;
            if (!query) return;

            const btn = document.querySelector('#modal_tambah_area button[onclick="searchLocationTambah()"]');
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = '...';

            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        document.getElementById('tambah_latitude').value = lat.toFixed(7);
                        document.getElementById('tambah_longitude').value = lng.toFixed(7);
                        document.getElementById('hud_tambah_lat').textContent = lat.toFixed(7);
                        document.getElementById('hud_tambah_lng').textContent = lng.toFixed(7);

                        if (mapTambah) {
                            mapTambah.setView([lat, lng], 14);
                            markerTambah.setLatLng([lat, lng]);
                            circleTambah.setLatLng([lat, lng]);
                        }
                    } else {
                        alert('Lokasi tidak ditemukan. Coba ketik nama kota/kecamatan yang lebih spesifik.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal menghubungi layanan pencarian peta.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = originalText;
                });
        };

        // Integrated location search with OSM Nominatim API for Edit Modal
        window.searchLocationEdit = function(id) {
            const query = document.getElementById(`search_area_edit_input_${id}`).value;
            if (!query) return;

            const btn = document.querySelector(`#modal_edit_area_${id} button[onclick="searchLocationEdit(${id})"]`);
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = '...';

            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        document.getElementById(`edit_latitude_${id}`).value = lat.toFixed(7);
                        document.getElementById(`edit_longitude_${id}`).value = lng.toFixed(7);
                        document.getElementById(`hud_edit_lat_${id}`).textContent = lat.toFixed(7);
                        document.getElementById(`hud_edit_lng_${id}`).textContent = lng.toFixed(7);

                        if (editMaps[id]) {
                            editMaps[id].map.setView([lat, lng], 14);
                            editMaps[id].marker.setLatLng([lat, lng]);
                            editMaps[id].circle.setLatLng([lat, lng]);
                        }
                    } else {
                        alert('Lokasi tidak ditemukan. Coba ketik nama lokasi yang lebih spesifik.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal menghubungi layanan pencarian peta.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = originalText;
                });
        };

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
                    document.getElementById('tambah_radius_badge').textContent = `${defaultRadius.toLocaleString('id-ID')} meter`;
                    document.getElementById('hud_tambah_lat').textContent = defaultLat;
                    document.getElementById('hud_tambah_lng').textContent = defaultLng;
                    document.getElementById('hud_tambah_rad').textContent = `${defaultRadius}m`;

                    if (!mapTambah) {
                        mapTambah = L.map('map_tambah').setView([defaultLat, defaultLng], 13);
                        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
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
                            document.getElementById('hud_tambah_lat').textContent = position.lat.toFixed(7);
                            document.getElementById('hud_tambah_lng').textContent = position.lng.toFixed(7);
                            circleTambah.setLatLng(position);
                        });

                        // Update on map click
                        mapTambah.on('click', function(e) {
                            markerTambah.setLatLng(e.latlng);
                            circleTambah.setLatLng(e.latlng);
                            document.getElementById('tambah_latitude').value = e.latlng.lat.toFixed(7);
                            document.getElementById('tambah_longitude').value = e.latlng.lng.toFixed(7);
                            document.getElementById('hud_tambah_lat').textContent = e.latlng.lat.toFixed(7);
                            document.getElementById('hud_tambah_lng').textContent = e.latlng.lng.toFixed(7);
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

        window.updateTambahCircle = function(value) {
            const radius = parseInt(value) || 1000;
            document.getElementById('tambah_radius_badge').textContent = `${radius.toLocaleString('id-ID')} meter`;
            document.getElementById('hud_tambah_rad').textContent = `${radius}m`;
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
                    document.getElementById('edit_radius_badge_' + id).textContent = `${defaultRadius.toLocaleString('id-ID')} meter`;
                    document.getElementById(`hud_edit_lat_${id}`).textContent = defaultLat;
                    document.getElementById(`hud_edit_lng_${id}`).textContent = defaultLng;
                    document.getElementById(`hud_edit_rad_${id}`).textContent = `${defaultRadius}m`;

                    if (!editMaps[id]) {
                        const map = L.map('map_edit_' + id).setView([defaultLat, defaultLng], 13);
                        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
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
                            document.getElementById(`hud_edit_lat_${id}`).textContent = position.lat.toFixed(7);
                            document.getElementById(`hud_edit_lng_${id}`).textContent = position.lng.toFixed(7);
                            circle.setLatLng(position);
                        });

                        map.on('click', function(e) {
                            marker.setLatLng(e.latlng);
                            circle.setLatLng(e.latlng);
                            document.getElementById('edit_latitude_' + id).value = e.latlng.lat.toFixed(7);
                            document.getElementById('edit_longitude_' + id).value = e.latlng.lng.toFixed(7);
                            document.getElementById(`hud_edit_lat_${id}`).textContent = e.latlng.lat.toFixed(7);
                            document.getElementById(`hud_edit_lng_${id}`).textContent = e.latlng.lng.toFixed(7);
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

        window.updateEditCircle = function(id, value) {
            const radius = parseInt(value) || 1000;
            document.getElementById('edit_radius_badge_' + id).textContent = `${radius.toLocaleString('id-ID')} meter`;
            document.getElementById(`hud_edit_rad_${id}`).textContent = `${radius}m`;
            if (editMaps[id] && editMaps[id].circle) {
                editMaps[id].circle.setRadius(radius);
            }
        };
    })();
</script>
