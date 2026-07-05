<!-- Pendaftaran Partial -->
<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Data Pendaftaran</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola semua pendaftaran pelanggan baru</p>
    </div>
    
    <div class="flex flex-wrap items-center gap-2">
        <!-- Search Form -->
        <form action="{{ route('admin.index') }}#pendaftaran" method="GET" class="join">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, wilayah, dll..." class="input input-bordered input-sm join-item w-40 sm:w-48 md:w-56 focus:w-64 transition-all duration-300" />
            
            <!-- Hidden inputs to preserve filters -->
            <input type="hidden" name="filter_status" value="{{ request('filter_status') }}">
            <input type="hidden" name="filter_paket" value="{{ request('filter_paket') }}">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
            <input type="hidden" name="sort_order" value="{{ request('sort_order') }}">

            <button type="submit" class="btn btn-sm btn-primary join-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
            @if(request('search'))
                @php
                    $clearSearchUrl = route('admin.index', request()->except('search')) . '#pendaftaran';
                @endphp
                <a href="{{ $clearSearchUrl }}" onclick="resetPendaftaranFilters(event)" class="btn btn-sm btn-ghost join-item" title="Hapus Pencarian">✕</a>
            @endif
        </form>

        <!-- Filter Toggle Button -->
        <button onclick="toggleFilterPanel()" class="btn btn-sm btn-outline btn-primary relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
            Filter & Urutkan
            @if(request('filter_status') || request('filter_paket') || request('start_date') || request('end_date') || (request('sort_by') && request('sort_by') !== 'created_at'))
                <span class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-primary rounded-full animate-ping"></span>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-primary rounded-full"></span>
            @endif
        </button>

        <!-- Export Excel Button -->
        <button onclick="document.getElementById('modal_export_pendaftaran').showModal()" class="btn btn-sm btn-success text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Ekspor Excel
        </button>

        <!-- Tambah Pendaftaran Button -->
        <button onclick="document.getElementById('modal_tambah_pendaftaran').showModal()" class="btn btn-sm btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah
        </button>
    </div>
</div>

<!-- Filter Panel -->
<div id="filter-panel" class="{{ (request('filter_status') || request('filter_paket') || request('start_date') || request('end_date') || (request('sort_by') && request('sort_by') !== 'created_at')) ? '' : 'hidden' }} bg-base-100 rounded-xl border border-base-200 p-5 mb-6 shadow-sm">
    <form action="{{ route('admin.index') }}#pendaftaran" method="GET" class="space-y-4">
        <!-- Keep the active search -->
        <input type="hidden" name="search" value="{{ request('search') }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <div class="form-control w-full">
                <label class="label py-1"><span class="label-text text-xs font-semibold text-base-content/70">Status</span></label>
                <select name="filter_status" class="select select-bordered select-sm w-full rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('filter_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="validated" {{ request('filter_status') === 'validated' ? 'selected' : '' }}>Validated</option>
                    <option value="rejected" {{ request('filter_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="setup" {{ request('filter_status') === 'setup' ? 'selected' : '' }}>Setup</option>
                    <option value="active" {{ request('filter_status') === 'active' ? 'selected' : '' }}>Active</option>
                </select>
            </div>

            <!-- Paket Filter -->
            <div class="form-control w-full">
                <label class="label py-1"><span class="label-text text-xs font-semibold text-base-content/70">Paket Layanan</span></label>
                <select name="filter_paket" class="select select-bordered select-sm w-full rounded-lg">
                    <option value="">Semua Paket</option>
                    @foreach($paket as $p)
                        <option value="{{ $p->id_paket }}" {{ request('filter_paket') === $p->id_paket ? 'selected' : '' }}>{{ $p->id_paket }} - {{ $p->title_paket }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range: Start Date -->
            <div class="form-control w-full">
                <label class="label py-1"><span class="label-text text-xs font-semibold text-base-content/70">Dari Tanggal</span></label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="input input-bordered input-sm w-full rounded-lg" />
            </div>

            <!-- Date Range: End Date -->
            <div class="form-control w-full">
                <label class="label py-1"><span class="label-text text-xs font-semibold text-base-content/70">Sampai Tanggal</span></label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="input input-bordered input-sm w-full rounded-lg" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end pt-2 border-t border-base-200/60">
            <!-- Sort By -->
            <div class="form-control w-full">
                <label class="label py-1"><span class="label-text text-xs font-semibold text-base-content/70">Urutkan</span></label>
                <select name="sort_by" class="select select-bordered select-sm w-full rounded-lg">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal Daftar</option>
                    <option value="status" {{ request('sort_by') === 'status' ? 'selected' : '' }}>Status</option>
                    <option value="id_paket" {{ request('sort_by') === 'id_paket' ? 'selected' : '' }}>Paket</option>
                    <option value="nama" {{ request('sort_by') === 'nama' ? 'selected' : '' }}>Nama Lengkap</option>
                </select>
            </div>

            <!-- Sort Order -->
            <div class="form-control w-full">
                <label class="label py-1"><span class="label-text text-xs font-semibold text-base-content/70">Urutan</span></label>
                <select name="sort_order" class="select select-bordered select-sm w-full rounded-lg">
                    <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Terbaru / Menurun</option>
                    <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Terlama / Menaik</option>
                </select>
            </div>

            <!-- Spacer for desktop layout alignment -->
            <div class="hidden md:block"></div>

            <!-- Filter Actions -->
            <div class="flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-1 rounded-lg">Terapkan</button>
                @php
                    $resetFiltersUrl = route('admin.index', request()->only('search')) . '#pendaftaran';
                @endphp
                <a href="{{ $resetFiltersUrl }}" onclick="resetPendaftaranFilters(event)" class="btn btn-sm btn-ghost border border-base-300 rounded-lg">Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="bg-base-100 rounded-xl shadow-sm border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200 text-base-content">
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Paket Layanan</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $item)
                @php
                    $imgSrc = null;
                    if ($item->path_gambar) {
                        $supabaseUrl = env('S3_ENDPOINT') ? str_replace('/s3', '/object/public/' . env('S3_BUCKET') . '/', env('S3_ENDPOINT')) . $item->path_gambar : Storage::disk('s3')->url($item->path_gambar);
                        $imgSrc = Str::startsWith($item->path_gambar, 'http') ? $item->path_gambar : $supabaseUrl;
                    }
                @endphp
                <tr>
                    <td class="font-mono text-sm font-semibold text-primary">{{ $item->id_pendaftaran }}</td>
                    <td class="font-medium">{{ $item->nama }}</td>
                    <td>
                        <div class="text-sm font-semibold">
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $item->nomor_tlpn);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($item->nama) }},%20kami%20dari%20R-NET..." target="_blank" rel="noopener noreferrer" class="link link-primary hover:underline inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-green-500 shrink-0"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $item->nomor_tlpn }}
                            </a>
                        </div>
                        <div class="text-xs text-base-content/70">{{ $item->wilayah }}</div>
                    </td>
                    <td class="max-w-[200px] truncate" title="{{ $item->alamat }}">{{ $item->alamat }}</td>
                    <td>
                        <span class="px-2 py-1 bg-primary/10 text-primary font-bold rounded-md border border-primary/20 text-xs whitespace-nowrap">
                            {{ $item->paket ? $item->paket->title_paket : $item->id_paket }}
                        </span>
                    </td>
                    <td>
                        <select
                            data-id="{{ $item->id_pendaftaran }}"
                            data-url="{{ route('admin.pendaftaran.update_status', $item->id_pendaftaran) }}"
                            class="select select-bordered select-sm w-full max-w-xs status-select rounded-md font-semibold bg-base-50/50"
                            onchange="updateStatus(this)"
                        >
                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="validated" {{ $item->status == 'validated' ? 'selected' : '' }}>Validated</option>
                            <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="setup" {{ $item->status == 'setup' ? 'selected' : '' }}>Setup</option>
                            <option value="active" {{ $item->status == 'active' || $item->status == 'aktif' ? 'selected' : '' }}>Active</option>
                        </select>
                    </td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <!-- Share Button -->
                            <button onclick="sharePendaftaran({{ Js::from($item->nama) }}, {{ Js::from($item->alamat) }}, {{ $item->latitude }}, {{ $item->longtitude }}, {{ Js::from($imgSrc) }})" class="btn btn-sm btn-square btn-ghost text-success" title="Bagikan ke Teknisi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            </button>
                            <!-- Detail Button -->
                            <button onclick="openDetailModal(
                                'modal_detail_{{ $item->id_pendaftaran }}',
                                {{ $item->latitude }},
                                {{ $item->longtitude }},
                                'map_{{ $item->id_pendaftaran }}',
                                'img_detail_{{ $item->id_pendaftaran }}',
                                ''
                            )" class="btn btn-sm btn-square btn-ghost text-info" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <!-- Edit Button -->
                            <button onclick="document.getElementById('modal_edit_{{ $item->id_pendaftaran }}').showModal()" class="btn btn-sm btn-square btn-ghost text-warning" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <!-- Delete Button -->
                            <button onclick="document.getElementById('modal_hapus_{{ $item->id_pendaftaran }}').showModal()" class="btn btn-sm btn-square btn-ghost text-error" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-base-content/50">Belum ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Links -->
    <div class="p-4 border-t border-base-200">
        {{ $pendaftaran->links('pagination::tailwind') }}
    </div>
</div>

<!-- Modal Tambah -->
<dialog id="modal_tambah_pendaftaran" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-4">Tambah Pendaftaran Baru</h3>
    <form action="{{ route('admin.pendaftaran.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Nama Lengkap</span></label>
            <input type="text" name="nama" class="input input-bordered w-full" placeholder="Masukkan nama lengkap" required />
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Wilayah</span></label>
            <select name="wilayah" class="select select-bordered w-full" required>
                <option value="" disabled selected>-- Pilih Wilayah --</option>
                @foreach($areaLayanan as $area)
                    <option value="{{ $area->nama_area }}">{{ $area->nama_area }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">No. Telepon / WhatsApp</span></label>
            <input type="text" name="nomor_tlpn" class="input input-bordered w-full" placeholder="Contoh: 08123456789 atau +628123456789" pattern="^(\+62|08|8)[0-9\s\-]{7,15}$" title="Format nomor HP harus diawali dengan 08, +62, atau langsung 8" required />
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Pilih Paket Layanan</span></label>
            <select name="id_paket" class="select select-bordered w-full" required>
                <option value="" disabled selected>-- Pilih Paket --</option>
                @foreach($paket as $p)
                    <option value="{{ $p->id_paket }}">{{ $p->id_paket }} - {{ $p->title_paket }} (Rp {{ number_format($p->harga_paket, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Alamat Pemasangan</span></label>
            <textarea name="alamat" class="textarea textarea-bordered h-24" placeholder="Masukkan alamat lengkap..." required></textarea>
        </div>
        <div class="modal-action">
            <button type="button" onclick="document.getElementById('modal_tambah_pendaftaran').close()" class="btn btn-ghost">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Pendaftaran</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

@foreach($pendaftaran as $item)
<!-- Modal Detail -->
<dialog id="modal_detail_{{ $item->id_pendaftaran }}" class="modal">
  <div class="modal-box max-w-2xl">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-4">Detail Pendaftaran: {{ $item->id_pendaftaran }}</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @if($item->path_gambar)
        <div class="md:col-span-2 rounded-xl overflow-hidden bg-base-200 h-48 flex items-center justify-center">
            @php
                $supabaseUrl = env('S3_ENDPOINT') ? str_replace('/s3', '/object/public/' . env('S3_BUCKET') . '/', env('S3_ENDPOINT')) . $item->path_gambar : Storage::disk('s3')->url($item->path_gambar);
                $imgSrc = Str::startsWith($item->path_gambar, 'http') ? $item->path_gambar : $supabaseUrl;
            @endphp
            <img id="img_detail_{{ $item->id_pendaftaran }}" data-src="{{ $imgSrc }}" alt="Foto Rumah" class="w-full h-full object-cover">
        </div>
        @endif
        
        <div><span class="text-base-content/70 text-sm block">Nama</span><span class="font-medium">{{ $item->nama }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Wilayah</span><span class="font-medium">{{ $item->wilayah }}</span></div>
        <div>
            <span class="text-base-content/70 text-sm block">Telepon</span>
            @php
                $cleanPhoneDetail = preg_replace('/[^0-9]/', '', $item->nomor_tlpn);
                if (str_starts_with($cleanPhoneDetail, '0')) {
                    $cleanPhoneDetail = '62' . substr($cleanPhoneDetail, 1);
                }
            @endphp
            <a href="https://wa.me/{{ $cleanPhoneDetail }}?text=Halo%20{{ urlencode($item->nama) }},%20kami%20dari%20R-NET..." target="_blank" rel="noopener noreferrer" class="link link-primary hover:underline inline-flex items-center gap-1 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                {{ $item->nomor_tlpn }}
            </a>
        </div>
        <div>
            <span class="text-base-content/70 text-sm block mb-1">Paket Layanan</span>
            <span class="px-2 py-1 bg-primary/10 text-primary font-bold rounded-md border border-primary/20 text-xs">
                {{ $item->paket ? $item->paket->title_paket : $item->id_paket }}
            </span>
        </div>
        <div><span class="text-base-content/70 text-sm block mb-1">Status</span><span id="detail_status_{{ $item->id_pendaftaran }}" class="px-2 py-1 font-bold rounded-md border text-xs {{ $item->status == 'pending' ? 'bg-warning/10 text-warning border-warning/20' : ($item->status == 'validated' ? 'bg-info/10 text-info border-info/20' : ($item->status == 'rejected' ? 'bg-error/10 text-error border-error/20' : ($item->status == 'setup' ? 'bg-accent/10 text-accent border-accent/20' : ($item->status == 'active' || $item->status == 'aktif' ? 'bg-success/10 text-success border-success/20' : 'bg-base-200 text-base-content/70 border-base-300')))) }}">{{ ucfirst($item->status) }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Tanggal Daftar</span><span class="font-medium">{{ $item->created_at->format('d M Y H:i') }}</span></div>
        
        <div class="md:col-span-2"><span class="text-base-content/70 text-sm block">Alamat</span><span class="font-medium">{{ $item->alamat }}</span></div>

        @if($item->pon_sn || $item->wifi_name)
        <div class="md:col-span-2 bg-success/5 border border-success/20 p-4 rounded-xl mt-2 space-y-3">
            <span class="text-success font-bold text-sm block flex items-center gap-1.5 border-b border-success/10 pb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Dokumentasi Pemasangan (Teknisi)
            </span>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div><span class="text-base-content/60 block">PON S/N:</span> <strong class="font-mono text-sm text-base-content">{{ $item->pon_sn }}</strong></div>
                <div><span class="text-base-content/60 block">Nama WiFi (SSID):</span> <strong class="text-sm text-base-content">{{ $item->wifi_name }}</strong></div>
                <div><span class="text-base-content/60 block">Password WiFi:</span> <strong class="text-sm text-base-content">{{ $item->wifi_password }}</strong></div>
                <div><span class="text-base-content/60 block">Tanggal Pasang:</span> <strong class="text-sm text-base-content">{{ $item->installed_at ? \Carbon\Carbon::parse($item->installed_at)->format('d M Y H:i') : '-' }}</strong></div>
            </div>
            @if($item->path_bukti_foto)
                @php
                    $buktiUrl = env('S3_ENDPOINT') ? str_replace('/s3', '/object/public/' . env('S3_BUCKET') . '/', env('S3_ENDPOINT')) . $item->path_bukti_foto : Storage::disk('s3')->url($item->path_bukti_foto);
                    $buktiImgSrc = Str::startsWith($item->path_bukti_foto, 'http') ? $item->path_bukti_foto : $buktiUrl;
                @endphp
                <div class="mt-3">
                    <span class="text-base-content/60 block text-xs mb-1.5 font-semibold">Foto Bukti Instalasi:</span>
                    <div class="rounded-lg overflow-hidden border border-base-300 max-h-48 flex items-center justify-center bg-base-200">
                        <img src="{{ $buktiImgSrc }}" alt="Foto Bukti Instalasi" class="max-h-48 w-full object-cover">
                    </div>
                </div>
            @endif
        </div>
        @endif
        
        <div class="md:col-span-2 bg-info/10 p-4 rounded-xl mt-2">
            <span class="text-info font-bold text-sm block">Titik Koordinat</span>
            <span class="font-mono text-sm mb-2 block">{{ $item->latitude }}, {{ $item->longtitude }}</span>
            <div id="map_{{ $item->id_pendaftaran }}" class="w-full h-48 rounded-lg z-0 relative"></div>
            <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longtitude }}" target="_blank" class="btn btn-sm btn-primary w-full mt-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                Buka di Google Maps
            </a>
        </div>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Modal Hapus -->
<dialog id="modal_hapus_{{ $item->id_pendaftaran }}" class="modal">
  <div class="modal-box text-center">
    <div class="text-error mb-4 flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <h3 class="font-bold text-lg">Hapus Pendaftaran?</h3>
    <p class="py-4">Yakin ingin menghapus pendaftaran <strong>{{ $item->nama }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
    <div class="modal-action justify-center">
      <form method="dialog">
        <button class="btn mr-2">Batal</button>
      </form>
      <!-- Form Hapus Real Backend (Metode DELETE) -->
      <form action="{{ route('admin.pendaftaran.destroy', $item->id_pendaftaran) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-error">Hapus</button>
      </form>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Modal Edit -->
<dialog id="modal_edit_{{ $item->id_pendaftaran }}" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-4">Edit Pendaftaran: {{ $item->id_pendaftaran }}</h3>
    
    <form action="{{ route('admin.pendaftaran.update', $item->id_pendaftaran) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Nama Lengkap</span></label>
            <input type="text" name="nama" value="{{ $item->nama }}" class="input input-bordered w-full" required />
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Wilayah</span></label>
            <select name="wilayah" class="select select-bordered w-full" required>
                <option value="" disabled>-- Pilih Wilayah --</option>
                @foreach($areaLayanan as $area)
                    <option value="{{ $area->nama_area }}" {{ $item->wilayah == $area->nama_area ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Telepon</span></label>
            <input type="text" name="nomor_tlpn" value="{{ $item->nomor_tlpn }}" class="input input-bordered w-full" pattern="^(\+62|08|8)[0-9\s\-]{7,15}$" title="Format nomor HP harus diawali dengan 08, +62, atau langsung 8" required />
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Paket</span></label>
            <select name="id_paket" class="select select-bordered w-full" required>
                @foreach($paket as $p)
                    <option value="{{ $p->id_paket }}" {{ $item->id_paket == $p->id_paket ? 'selected' : '' }}>{{ $p->id_paket }} - {{ $p->title_paket }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Alamat</span></label>
            <textarea name="alamat" class="textarea textarea-bordered h-24" required>{{ $item->alamat }}</textarea>
        </div>
        
        <div class="modal-action">
            <button type="button" onclick="document.getElementById('modal_edit_{{ $item->id_pendaftaran }}').close()" class="btn">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
@endforeach

<!-- Modal Ekspor Excel -->
<dialog id="modal_export_pendaftaran" class="modal">
  <div class="modal-box max-w-md">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Ekspor Data Pendaftaran
    </h3>
    <p class="text-sm text-base-content/70 mb-4">Pilih dan urutkan kolom yang ingin diekspor ke file Excel/CSV.</p>
    
    <form action="{{ route('admin.pendaftaran.export') }}" method="POST" data-no-ajax class="space-y-4">
        @csrf
        
        <!-- Opsi Ekspor (Semua vs Filter) -->
        @php
            $hasActiveFilters = request('search') || request('filter_status') || request('filter_paket') || request('start_date') || request('end_date') || (request('sort_by') && request('sort_by') !== 'created_at');
        @endphp
        <div class="form-control">
            <span class="label-text font-semibold mb-2 block">Cakupan Data</span>
            <div class="flex flex-col gap-2 p-3 bg-base-100 rounded-lg border border-base-200">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="export_option" value="all" {{ !$hasActiveFilters ? 'checked' : '' }} class="radio radio-primary radio-sm">
                    <span class="text-sm font-medium">Semua Data (Total: {{ $totalPendaftaran }})</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer {{ !$hasActiveFilters ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <input type="radio" name="export_option" value="filtered" {{ $hasActiveFilters ? 'checked' : '' }} {{ !$hasActiveFilters ? 'disabled' : '' }} class="radio radio-primary radio-sm">
                    <span class="text-sm font-medium">Hasil Filter / Pencarian Saja</span>
                </label>
            </div>
            <!-- Query Parameters Hidden -->
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="filter_status" value="{{ request('filter_status') }}">
            <input type="hidden" name="filter_paket" value="{{ request('filter_paket') }}">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
            <input type="hidden" name="sort_order" value="{{ request('sort_order') }}">
        </div>

        <!-- Kolom yang akan diekspor -->
        <div class="form-control">
            <span class="label-text font-semibold mb-2 block">Pilih & Urutkan Kolom</span>
            
            <div class="flex justify-between items-center mb-2">
                <button type="button" onclick="toggleAllExportColumns(true)" class="text-xs text-primary font-semibold hover:underline">Pilih Semua</button>
                <button type="button" onclick="toggleAllExportColumns(false)" class="text-xs text-base-content/50 font-semibold hover:underline">Hapus Semua</button>
            </div>

            <ul id="export-columns-list" class="space-y-2 max-h-64 overflow-y-auto pr-1">
                @php
                    $defaultColumns = [
                        'id_pendaftaran' => 'ID Pendaftaran',
                        'nama'           => 'Nama Lengkap',
                        'nomor_tlpn'     => 'No. Telepon / WA',
                        'wilayah'        => 'Wilayah',
                        'alamat'         => 'Alamat Pemasangan',
                        'latitude'       => 'Latitude',
                        'longtitude'     => 'Longitude',
                        'paket'          => 'Paket Layanan',
                        'harga'          => 'Harga Paket',
                        'status'         => 'Status',
                        'created_at'     => 'Tanggal Daftar'
                    ];
                @endphp
                @foreach($defaultColumns as $key => $label)
                <li draggable="true" class="flex items-center justify-between p-2.5 bg-base-50 hover:bg-base-200/50 border border-base-200 rounded-lg cursor-grab active:cursor-grabbing transition-colors duration-150" data-col="{{ $key }}">
                    <div class="flex items-center gap-3">
                        <span class="text-base-content/40 cursor-grab">
                            <!-- Grip Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/></svg>
                        </span>
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="columns[]" value="{{ $key }}" checked class="checkbox checkbox-primary checkbox-xs rounded">
                            <span class="text-sm font-medium text-base-content">{{ $label }}</span>
                        </label>
                    </div>
                    <!-- Up/Down Action Buttons for quick sorting -->
                    <div class="flex items-center">
                        <button type="button" onclick="moveExportColumn(this, 'up')" class="btn btn-ghost btn-xs btn-square text-base-content/60 hover:text-primary" title="Pindahkan ke atas">▲</button>
                        <button type="button" onclick="moveExportColumn(this, 'down')" class="btn btn-ghost btn-xs btn-square text-base-content/60 hover:text-primary" title="Pindahkan ke bawah">▼</button>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="modal-action">
            <button type="button" onclick="document.getElementById('modal_export_pendaftaran').close()" class="btn btn-ghost">Batal</button>
            <button type="submit" class="btn btn-success text-white">Unduh Excel</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Toast Notification Container -->
<div id="toast-container" class="toast toast-top toast-end z-50" style="display:none;">
    <div id="toast-msg" class="alert alert-success shadow-lg">
        <span></span>
    </div>
</div>


