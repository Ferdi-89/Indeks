<!-- Paket Partial -->
<!-- Google Fonts for Real-time Card Customization Preview -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700;900&family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8 bg-base-100 p-6 rounded-2xl border border-base-200/60 shadow-sm">
    <div class="space-y-1">
        <div class="flex items-center gap-2">
            <h3 class="text-2xl font-black text-base-content tracking-tight">Paket Internet</h3>
            <span class="px-2.5 py-0.5 text-xs font-bold bg-primary/10 text-primary border border-primary/20 rounded-full">
                {{ count($paket) }} Paket
            </span>
        </div>
        <p class="text-xs sm:text-sm text-base-content/60">Kelola konfigurasi paket internet, harga, promosi, dan kustomisasi tema visual secara terpusat.</p>
    </div>
    <button onclick="document.getElementById('modal_tambah_paket').showModal()" class="btn btn-primary btn-md rounded-xl font-bold gap-2 text-white shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Tambah Paket Baru
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($paket as $item)
        <div class="group relative bg-base-100 rounded-2xl border border-base-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
            <!-- Top Status Indicator Bar -->
            <div class="absolute top-0 left-0 right-0 h-1 @if($item->is_hidden) bg-amber-500 @else bg-emerald-500 @endif"></div>
            
            <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                <div>
                    <!-- Card Top Header -->
                    <div class="flex justify-between items-start">
                        <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h.01" />
                                <path d="M2 8.82a15 15 0 0 1 20 0" />
                                <path d="M5 12.859a10 10 0 0 1 14 0" />
                                <path d="M8.5 16.429a5 5 0 0 1 7 0" />
                            </svg>
                        </div>
                        <div class="flex flex-col items-end gap-1.5">
                            @if($item->is_hidden)
                                <div class="px-2.5 py-1 bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold text-[10px] uppercase tracking-wider rounded-lg border border-amber-500/20 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Sembunyi
                                </div>
                            @else
                                <div class="px-2.5 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-[10px] uppercase tracking-wider rounded-lg border border-emerald-500/20 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Aktif
                                </div>
                            @endif
                            @if($item->id_promosi)
                                <span class="px-2 py-0.5 bg-secondary text-secondary-content font-black text-[9px] uppercase tracking-wider rounded shadow-sm">PROMO</span>
                            @endif
                        </div>
                    </div>

                    <!-- Title & Identifier -->
                    <div class="mt-4 space-y-1">
                        <h4 class="text-xl font-bold tracking-tight text-base-content leading-tight">{{ $item->title_paket }}</h4>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold bg-base-200 text-base-content/60 rounded font-mono uppercase tracking-wider">ID: {{ $item->id_paket }}</span>
                    </div>

                    <!-- Pricing Info -->
                    <div class="flex items-baseline gap-1 mt-3">
                        <span class="text-2xl font-black text-base-content tracking-tight">Rp {{ number_format($item->harga_paket, 0, ',', '.') }}</span>
                        <span class="text-xs text-base-content/50 font-medium">/bulan</span>
                    </div>

                    <!-- Theme Preview Swatch -->
                    @if($item->warna_bg || $item->warna_font || $item->warna_border || $item->warna_button)
                        <div class="flex items-center gap-1.5 mt-4 bg-base-200/40 px-3 py-1.5 rounded-xl border border-base-200/60 w-fit">
                            <span class="text-[9px] font-bold text-base-content/50 uppercase tracking-wider mr-1">Palet Tema:</span>
                            <span class="w-3.5 h-3.5 rounded-full border border-base-300 shadow-sm" style="background-color: {{ $item->warna_bg ?? '#ffffff' }}" title="Latar (Background)"></span>
                            <span class="w-3.5 h-3.5 rounded-full border border-base-300 shadow-sm" style="background-color: {{ $item->warna_font ?? '#1f2937' }}" title="Tulisan (Font)"></span>
                            <span class="w-3.5 h-3.5 rounded-full border border-base-300 shadow-sm" style="background-color: {{ $item->warna_border ?? '#e5e7eb' }}" title="Garis Tepi (Border)"></span>
                            <span class="w-3.5 h-3.5 rounded-full border border-base-300 shadow-sm" style="background-color: {{ $item->warna_button ?? '#2563eb' }}" title="Tombol (Button)"></span>
                        </div>
                    @endif
                </div>

                <!-- Structured Metadata List -->
                <div class="text-xs space-y-2.5 text-base-content/70 mt-4 pt-4 border-t border-base-200/50">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="opacity-60"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="font-medium">Promosi:</span>
                        <span class="font-semibold text-base-content ml-auto">{{ $item->promosi ? $item->promosi->text_promosi : 'Tidak ada' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="opacity-60"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span class="font-medium">Badge Pill:</span>
                        @if($item->badge_text)
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-primary/10 text-primary border border-primary/20 rounded ml-auto">{{ $item->badge_text }}</span>
                        @else
                            <span class="font-semibold text-base-content/50 italic ml-auto">Tidak ada</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="opacity-60"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="font-medium">Poin Informasi:</span>
                        @if($item->point_keunggulan && count($item->point_keunggulan) > 0)
                            <span class="px-2.5 py-0.5 text-[10px] font-bold bg-base-200 text-base-content/80 rounded-full ml-auto">{{ count($item->point_keunggulan) }} Poin</span>
                        @else
                            <span class="font-semibold text-base-content/50 italic ml-auto">0 Poin</span>
                        @endif
                    </div>
                </div>

                <!-- Action Button Block -->
                <div class="flex flex-col gap-2 mt-4 pt-4 border-t border-base-200/50">
                    <div class="flex gap-2">
                        <button onclick="document.getElementById('modal_edit_{{ $item->id_paket }}').showModal()"
                            class="btn btn-sm btn-outline btn-success flex-1 gap-1.5 rounded-xl font-bold transition-all hover:bg-success hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </button>
                        <button onclick="document.getElementById('modal_hapus_{{ $item->id_paket }}').showModal()"
                            class="btn btn-sm btn-outline btn-error flex-1 gap-1.5 rounded-xl font-bold transition-all hover:bg-error hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <line x1="10" y1="11" x2="10" y2="17" />
                                <line x1="14" y1="11" x2="14" y2="17" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                    <form action="{{ route('admin.paket.toggle_hide', $item->id_paket) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="btn btn-xs btn-ghost hover:bg-base-200/80 w-full rounded-xl font-bold text-[10px] gap-1.5 py-2 h-auto min-h-0 border border-base-200 transition-colors uppercase tracking-wider {{ $item->is_hidden ? 'text-primary' : 'text-base-content/60' }}">
                            @if($item->is_hidden)
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                Tampilkan di Publik
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                                Sembunyikan
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center text-base-content/40 bg-base-100 rounded-2xl border border-dashed border-base-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto opacity-30 mb-3"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
            <p class="font-bold text-sm">Belum Ada Paket Internet</p>
            <p class="text-xs mt-1">Gunakan tombol "Tambah Paket Baru" untuk mendaftarkan layanan paket.</p>
        </div>
    @endforelse
</div>

<!-- Modal Tambah -->
<dialog id="modal_tambah_paket" class="modal">
    <div id="modal_box_tambah" class="modal-box w-full max-w-lg transition-all duration-300 max-h-[90vh] flex flex-col overflow-hidden p-0 rounded-2xl border border-base-200/60 shadow-2xl bg-base-100">
        <form id="form_tambah_paket" action="{{ route('admin.paket.store') }}" method="POST" class="flex flex-col h-full max-h-[90vh] overflow-hidden m-0">
            @csrf

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-base-200 flex justify-between items-center bg-base-100 shrink-0">
                <div>
                    <h3 class="font-bold text-lg text-base-content flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-primary"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
                        Tambah Paket Baru
                    </h3>
                    <p class="text-xs text-base-content/50">Lengkapi detail paket internet dan kustomisasi visual tampilan kartu.</p>
                </div>
                <button type="button" class="btn btn-sm btn-circle btn-ghost" onclick="closeTambahPaketModal()">✕</button>
            </div>

            <!-- Modal Body (Columns container) -->
            <div class="flex-1 flex flex-col lg:flex-row min-h-0 overflow-y-auto lg:overflow-hidden">
                <!-- COLUMN 1: Basic Form -->
                <div class="flex-1 p-6 space-y-4 lg:overflow-y-auto scrollbar-thin">
                    <div class="pb-2 border-b border-base-200/60 mb-4 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <span class="text-xs font-bold text-base-content/70 uppercase tracking-wider">Detail Informasi</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">ID Paket</span></label>
                            <input type="text" name="id_paket" class="input input-bordered w-full bg-base-100"
                                placeholder="Contoh: PK04" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">Hubungan Promosi</span></label>
                            <select name="id_promosi" class="select select-bordered w-full bg-base-100">
                                <option value="" data-discount="0" data-text="">-- Tanpa Promosi --</option>
                                @foreach($promosi as $p)
                                    <option value="{{ $p->id_promosi }}" data-discount="{{ $p->value_promosi }}" data-text="{{ $p->text_promosi }}">
                                        {{ $p->id_promosi }} - {{ $p->text_promosi }} (Diskon: {{ number_format($p->value_promosi) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">Nama Paket</span></label>
                            <input type="text" name="title_paket" oninput="updateAnnouncementPlaceholders()"
                                class="input input-bordered w-full bg-base-100" placeholder="Contoh: Super Cepat" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">Harga Paket (Rp)</span></label>
                            <input type="number" name="harga_paket" oninput="updateAnnouncementPlaceholders()"
                                class="input input-bordered w-full bg-base-100" placeholder="150000" required />
                        </div>
                    </div>

                    <!-- Poin Informasi -->
                    <div class="form-control">
                        <div class="flex justify-between items-center mb-2">
                            <label class="label p-1"><span class="label-text text-sm font-semibold text-base-content/80">Poin Informasi</span></label>
                            <button type="button" onclick="addPointField('tambah')"
                                class="btn btn-sm btn-outline btn-primary">Tambah Poin</button>
                        </div>
                        <div id="points_container_tambah" class="space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="text" name="point_informasi[]" value="Kuota 100% Unlimited Murni"
                                    class="input input-bordered input-sm flex-1 bg-base-100" required />
                                <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                    onclick="removePointField(this)">×</button>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" name="point_informasi[]" value="Bebas Lag &amp; Throttling FUP"
                                    class="input input-bordered input-sm flex-1 bg-base-100" required />
                                <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                    onclick="removePointField(this)">×</button>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" name="point_informasi[]" value="Modem WiFi ONT Dipinjamkan Gratis"
                                    class="input input-bordered input-sm flex-1 bg-base-100" required />
                                <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                    onclick="removePointField(this)">×</button>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Customizer Trigger Button -->
                    <div class="form-control border border-base-200 rounded-xl p-3 bg-base-200/30 flex flex-row items-center justify-between">
                        <div>
                            <span class="font-bold text-sm block text-base-content/90">Kustomisasi Tema Paket</span>
                            <span class="text-xs text-base-content/50">Atur warna latar, font, dan keunggulan khusus.</span>
                        </div>
                        <button type="button" onclick="toggleThemePanel('tambah')" class="btn btn-sm btn-primary">
                            Konfigurasi Tema
                        </button>
                    </div>

                    <!-- Automatic Announcement Toggle and Placeholder fields -->
                    <div class="divider my-4"></div>
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="create_announcement" id="toggle_create_announcement" value="1"
                                onchange="toggleAnnouncementSection(this.checked)"
                                class="checkbox checkbox-primary checkbox-sm" />
                            <span class="label-text font-bold text-sm text-base-content/85">Buat Pengumuman Otomatis untuk Paket Ini</span>
                        </label>
                    </div>

                    <div id="announcement_fields_container"
                        class="hidden border border-primary/20 bg-primary/5 rounded-2xl p-4 mt-2 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-xs font-semibold">ID Pengumuman</span></label>
                                <input type="text" name="announcement_id"
                                    class="input input-bordered input-sm w-full bg-base-100" placeholder="PENG05" />
                            </div>
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-xs font-semibold">Tema Pengumuman</span></label>
                                <input type="text" name="announcement_tema"
                                    class="input input-bordered input-sm w-full bg-base-100" value="Promo Paket Baru"
                                    placeholder="Maintenance / Promo" />
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label p-1"><span class="label-text text-xs font-semibold">Isi Pengumuman</span></label>
                            <textarea name="announcement_text"
                                class="textarea textarea-bordered textarea-sm h-16 w-full bg-base-100"
                                placeholder="Masukkan pengumuman..."></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-xs font-semibold">Tanggal Mulai</span></label>
                                <input type="date" name="announcement_valid_start"
                                    class="input input-bordered input-sm w-full bg-base-100" value="{{ date('Y-m-d') }}" />
                            </div>
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-xs font-semibold">Tanggal Berakhir</span></label>
                                <input type="date" name="announcement_valid_end"
                                    class="input input-bordered input-sm w-full bg-base-100"
                                    value="{{ date('Y-m-d', strtotime('+30 days')) }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLUMN 2: Theme Customizer (Width: lg:w-80) -->
                <div id="dragable_theme_tambah" class="hidden lg:w-80 border-t lg:border-t-0 lg:border-l border-base-200 bg-base-50/50 p-6 space-y-4 lg:overflow-y-auto scrollbar-thin flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b border-base-200/60 mb-2 shrink-0">
                            <span class="text-xs font-bold text-base-content/70 uppercase tracking-wider flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-primary"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" /><path d="M12 8V16" /><path d="M8 12H16" /></svg>
                                Kustomisasi Desain
                            </span>
                            <button type="button" onclick="toggleThemePanel('tambah')" class="btn btn-xs btn-circle btn-ghost text-base-content/40 hover:text-base-content" title="Tutup Kustomisasi">✕</button>
                        </div>
                        
                        <!-- Preset Buttons -->
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-bold text-base-content/50 uppercase tracking-wider">Pilih Preset Tema</span>
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button" onclick="applyPreset('tambah', 'default')"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-lg hover:bg-base-200 transition-colors gap-1 flex items-center bg-base-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                        <path d="M3 3v5h5" />
                                    </svg>
                                    Default
                                </button>
                                <button type="button" onclick="applyPreset('tambah', 'dark')"
                                    class="px-2.5 py-1 text-[10px] font-bold bg-neutral text-neutral-content rounded-lg hover:opacity-90 transition-opacity flex items-center gap-1">🌙 Dark</button>
                                <button type="button" onclick="applyPreset('tambah', 'ocean')"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-info/30 text-info bg-info/5 rounded-lg hover:bg-info/10 transition-colors flex items-center gap-1">🌊 Ocean</button>
                                <button type="button" onclick="applyPreset('tambah', 'sunset')"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-warning/30 text-warning bg-warning/5 rounded-lg hover:bg-warning/10 transition-colors flex items-center gap-1">🌅 Sunset</button>
                            </div>
                        </div>
                        
                        <div class="form-control">
                            <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Nama Tema</span></label>
                            <input type="text" name="nama_tema"
                                class="input input-bordered input-sm rounded-lg w-full bg-base-100" placeholder="Contoh: Light Orange" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Latar</span></label>
                                <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all shadow-sm">
                                    <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_tambah_warna_bg" style="background-color: #ffffff;">
                                        <input type="color" oninput="syncColorInput('tambah', 'warna_bg', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="#ffffff" />
                                    </div>
                                    <input type="text" id="tambah_warna_bg" name="warna_bg" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="#ffffff" />
                                </div>
                            </div>
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Font</span></label>
                                <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all shadow-sm">
                                    <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_tambah_warna_font" style="background-color: #1f2937;">
                                        <input type="color" oninput="syncColorInput('tambah', 'warna_font', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="#1f2937" />
                                    </div>
                                    <input type="text" id="tambah_warna_font" name="warna_font" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="#1f2937" />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Border</span></label>
                                <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all shadow-sm">
                                    <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_tambah_warna_border" style="background-color: #e5e7eb;">
                                        <input type="color" oninput="syncColorInput('tambah', 'warna_border', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="#e5e7eb" />
                                    </div>
                                    <input type="text" id="tambah_warna_border" name="warna_border" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="#e5e7eb" />
                                </div>
                            </div>
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Tombol</span></label>
                                <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all shadow-sm">
                                    <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_tambah_warna_button" style="background-color: #2563eb;">
                                        <input type="color" oninput="syncColorInput('tambah', 'warna_button', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="#2563eb" />
                                    </div>
                                    <input type="text" id="tambah_warna_button" name="warna_button" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="#2563eb" />
                                </div>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Font Family</span></label>
                            <select name="font_family" class="select select-bordered select-sm rounded-lg w-full bg-base-100">
                                <option value="Inter">Inter (Default)</option>
                                <option value="Poppins">Poppins</option>
                                <option value="Roboto">Roboto</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Outfit">Outfit</option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Pill Informasi (Badge)</span></label>
                            <input type="text" id="badge_text_tambah" name="badge_text"
                                class="input input-bordered input-sm rounded-lg w-full mb-2 bg-base-100" placeholder="Contoh: Terpopuler" />
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary hover:border-primary/20 transition-all bg-base-100 font-sans"
                                    onclick="selectBadge('tambah', 'Terpopuler')">Terpopuler</button>
                                <button type="button"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary hover:border-primary/20 transition-all bg-base-100 font-sans"
                                    onclick="selectBadge('tambah', 'Promo')">Promo</button>
                                <button type="button"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary hover:border-primary/20 transition-all bg-base-100 font-sans"
                                    onclick="selectBadge('tambah', 'Terbatas')">Terbatas</button>
                                <button type="button"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary hover:border-primary/20 transition-all bg-base-100 font-sans"
                                    onclick="selectBadge('tambah', 'Unlimited')">Unlimited</button>
                                <button type="button"
                                    class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary hover:border-primary/20 transition-all bg-base-100 font-sans"
                                    onclick="selectBadge('tambah', 'Weekend')">Weekend</button>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-base-100/50 border-t border-base-200 text-center text-[10px] text-base-content/40 font-mono shrink-0">
                        Tema disinkronkan otomatis
                    </div>
                </div>

                <!-- COLUMN 3: Live Preview (Width: lg:w-[340px]) -->
                <div id="preview_card_container_tambah" class="hidden lg:w-[340px] border-t lg:border-t-0 lg:border-l border-base-200 bg-base-200/10 p-6 flex flex-col items-center justify-start lg:overflow-y-auto scrollbar-thin shrink-0">
                    <div class="w-full text-center pb-2 border-b border-base-200/60 mb-6 shrink-0">
                        <span class="text-xs font-bold text-base-content/70 uppercase tracking-wider flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-primary"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            Pratinjau Tampilan
                        </span>
                    </div>
                    
                    <div class="live-preview-card w-full rounded-3xl border p-6 space-y-6 relative overflow-hidden transition-all duration-300 shadow-md flex flex-col justify-between bg-white text-base-content" style="font-family: 'Inter', sans-serif;">
                         <!-- Mesh Grid Decor -->
                         <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]"></div>
                         
                         <!-- Glow decoration -->
                         <div class="pricing-mesh-bg"></div>
                         <div class="absolute -top-12 -right-12 w-28 h-28 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>

                         <div class="space-y-6 flex-1 flex flex-col justify-between relative z-10">
                             <div class="space-y-4">
                                 <div class="flex justify-between items-center">
                                     <span class="preview-tag text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-md bg-primary/15 text-primary">
                                         Jaringan FTTH
                                     </span>
                                     <span class="preview-badge badge font-black text-[9px] uppercase tracking-wider py-2.5 px-3 text-white border-none shadow-md hidden" style="background-color: #2563eb;">
                                         Terpopuler
                                     </span>
                                 </div>
                                 
                                 <div class="flex items-center gap-3">
                                     <div class="preview-icon-wrapper w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-primary/15 text-primary">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/></svg>
                                     </div>
                                     <h3 class="preview-title text-xl font-black leading-tight tracking-tight">
                                         Nama Paket
                                     </h3>
                                 </div>
                             </div>
                             
                             <div class="preview-price-container py-2 space-y-1 relative z-10">
                                 <!-- Promo section -->
                                 <div class="preview-promo-old-price text-xs font-semibold opacity-50 line-through hidden">
                                     Rp 150.000
                                 </div>
                                 <div class="flex items-baseline justify-start gap-1">
                                     <span class="preview-price text-5xl font-black tracking-tight">
                                         150K
                                     </span>
                                     <span class="preview-price-unit text-xs font-bold opacity-70">/bulan</span>
                                 </div>
                                 <div class="preview-promo-badge inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-wider text-secondary mt-1 bg-secondary/15 px-2 py-0.5 rounded hidden">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-secondary w-3 h-3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                     <span>PROMO</span>
                                 </div>
                             </div>
                             
                             <div class="border-t border-base-300/40 my-1 relative z-10"></div>
                             
                             <ul class="preview-points space-y-3 text-xs font-medium pt-2 relative z-10">
                                 <!-- Dynamically generated points -->
                             </ul>
                         </div>
                         
                         <!-- Action Button Card -->
                         <div class="pt-4 border-t border-base-300/40 relative z-10">
                             <div class="preview-button w-full py-3 rounded-xl font-bold text-xs text-center text-white shadow-lg transition-all uppercase" style="background-color: #2563eb;">
                                 PILIH PAKET
                             </div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-base-200 bg-base-50/50 flex justify-end gap-3 shrink-0">
                <button type="button" class="btn btn-outline btn-md rounded-xl font-bold" onclick="closeTambahPaketModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-md rounded-xl font-bold px-6 text-white shadow-md shadow-primary/20 hover:shadow-primary/30 transition-all duration-300">Simpan</button>
            </div>
        </form>
    </div>
</dialog>

@foreach($paket as $item)
    <!-- Modal Edit -->
    <dialog id="modal_edit_{{ $item->id_paket }}" class="modal">
        <div id="modal_box_edit_{{ $item->id_paket }}" class="modal-box w-full max-w-lg transition-all duration-300 max-h-[90vh] flex flex-col overflow-hidden p-0 rounded-2xl border border-base-200/60 shadow-2xl bg-base-100">
            <form id="form_edit_paket_{{ $item->id_paket }}" action="{{ route('admin.paket.update', $item->id_paket) }}" method="POST" class="flex flex-col h-full max-h-[90vh] overflow-hidden m-0">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-base-200 flex justify-between items-center bg-base-100 shrink-0">
                    <div>
                        <h3 class="font-bold text-lg text-base-content flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-success"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" /><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>
                            Edit Paket: {{ $item->title_paket }}
                        </h3>
                        <p class="text-xs text-base-content/50">Sesuaikan informasi paket internet dan visualisasi tema tampilan kartu.</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-circle btn-ghost" onclick="closeEditPaketModal('{{ $item->id_paket }}')">✕</button>
                </div>

                <!-- Modal Body (Columns container) -->
                <div class="flex-1 flex flex-col lg:flex-row min-h-0 overflow-y-auto lg:overflow-hidden">
                    <!-- COLUMN 1: Basic Form -->
                    <div class="flex-1 p-6 space-y-4 lg:overflow-y-auto scrollbar-thin">
                        <div class="pb-2 border-b border-base-200/60 mb-4 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-success"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span class="text-xs font-bold text-base-content/70 uppercase tracking-wider">Detail Informasi</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">Hubungan Promosi</span></label>
                            <select name="id_promosi" class="select select-bordered w-full bg-base-100">
                                <option value="" data-discount="0" data-text="">-- Tanpa Promosi --</option>
                                @foreach($promosi as $p)
                                    <option value="{{ $p->id_promosi }}" data-discount="{{ $p->value_promosi }}" data-text="{{ $p->text_promosi }}" {{ $item->id_promosi === $p->id_promosi ? 'selected' : '' }}>
                                        {{ $p->id_promosi }} - {{ $p->text_promosi }} (Diskon: {{ number_format($p->value_promosi) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">Nama Paket</span></label>
                            <input type="text" name="title_paket" value="{{ $item->title_paket }}"
                                class="input input-bordered w-full bg-base-100" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium text-base-content/80">Harga Paket (Rp)</span></label>
                            <input type="number" name="harga_paket" value="{{ $item->harga_paket }}"
                                class="input input-bordered w-full bg-base-100" required />
                        </div>

                        <!-- Poin Informasi -->
                        <div class="form-control">
                            <div class="flex justify-between items-center mb-2">
                                <label class="label p-1"><span class="label-text text-sm font-semibold text-base-content/80">Poin Informasi</span></label>
                                <button type="button" onclick="addPointField('edit_{{ $item->id_paket }}')"
                                    class="btn btn-sm btn-outline btn-success">Tambah Poin</button>
                            </div>
                            <div id="points_container_edit_{{ $item->id_paket }}" class="space-y-2">
                                @if($item->point_keunggulan && is_array($item->point_keunggulan))
                                    @foreach($item->point_keunggulan as $pPoint)
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="point_informasi[]" value="{{ $pPoint }}"
                                                class="input input-bordered input-sm flex-1 bg-base-100" required />
                                            <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                                onclick="removePointField(this)">×</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="point_informasi[]" value="Kuota 100% Unlimited Murni"
                                            class="input input-bordered input-sm flex-1 bg-base-100" required />
                                        <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                            onclick="removePointField(this)">×</button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="point_informasi[]" value="Bebas Lag &amp; Throttling FUP"
                                            class="input input-bordered input-sm flex-1 bg-base-100" required />
                                        <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                            onclick="removePointField(this)">×</button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="point_informasi[]" value="Modem WiFi ONT Dipinjamkan Gratis"
                                            class="input input-bordered input-sm flex-1 bg-base-100" required />
                                        <button type="button" class="btn btn-sm btn-error btn-circle text-white"
                                            onclick="removePointField(this)">×</button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Theme Customizer Trigger Button -->
                        <div class="form-control border border-base-200 rounded-xl p-3 bg-base-200/30 flex flex-row items-center justify-between">
                            <div>
                                <span class="font-bold text-sm block text-base-content/90">Kustomisasi Tema Paket</span>
                                <span class="text-xs text-base-content/50">Edit warna latar, font, dan keunggulan khusus.</span>
                            </div>
                            <button type="button" onclick="toggleThemePanel('edit_{{ $item->id_paket }}')"
                                class="btn btn-sm btn-success text-white">
                                Konfigurasi Tema
                            </button>
                        </div>
                    </div>

                    <!-- COLUMN 2: Theme Customizer (Width: lg:w-80) -->
                    <div id="dragable_theme_edit_{{ $item->id_paket }}" class="hidden lg:w-80 border-t lg:border-t-0 lg:border-l border-base-200 bg-base-50/50 p-6 space-y-4 lg:overflow-y-auto scrollbar-thin flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-base-200/60 mb-2 shrink-0">
                                <span class="text-xs font-bold text-base-content/70 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-success"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" /><path d="M12 8V16" /><path d="M8 12H16" /></svg>
                                    Kustomisasi Desain
                                </span>
                                <button type="button" onclick="toggleThemePanel('edit_{{ $item->id_paket }}')" class="btn btn-xs btn-circle btn-ghost text-base-content/40 hover:text-base-content" title="Tutup Kustomisasi">✕</button>
                            </div>
                            
                            <!-- Preset Buttons -->
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-bold text-base-content/50 uppercase tracking-wider">Pilih Preset Tema</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'default')"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-lg hover:bg-base-200 transition-colors gap-1 flex items-center bg-base-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                            <path d="M3 3v5h5" />
                                        </svg>
                                        Default
                                    </button>
                                    <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'dark')"
                                        class="px-2.5 py-1 text-[10px] font-bold bg-neutral text-neutral-content rounded-lg hover:opacity-90 transition-opacity flex items-center gap-1">🌙 Dark</button>
                                    <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'ocean')"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-info/30 text-info bg-info/5 rounded-lg hover:bg-info/10 transition-colors flex items-center gap-1">🌊 Ocean</button>
                                    <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'sunset')"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-warning/30 text-warning bg-warning/5 rounded-lg hover:bg-warning/10 transition-colors flex items-center gap-1">🌅 Sunset</button>
                                </div>
                            </div>
                            
                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Nama Tema</span></label>
                                <input type="text" name="nama_tema"
                                    value="{{ $item->nama_tema }}" class="input input-bordered input-sm rounded-lg w-full bg-base-100"
                                    placeholder="Contoh: Light Orange" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-control">
                                    <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Latar</span></label>
                                    <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-success focus-within:ring-2 focus-within:ring-success/10 transition-all shadow-sm">
                                        <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_edit_{{ $item->id_paket }}_warna_bg" style="background-color: {{ $item->warna_bg ?? '#ffffff' }};">
                                            <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_bg', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="{{ $item->warna_bg ?? '#ffffff' }}" />
                                        </div>
                                        <input type="text" id="edit_{{ $item->id_paket }}_warna_bg" name="warna_bg" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="{{ $item->warna_bg ?? '#ffffff' }}" />
                                    </div>
                                </div>
                                <div class="form-control">
                                    <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Font</span></label>
                                    <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-success focus-within:ring-2 focus-within:ring-success/10 transition-all shadow-sm">
                                        <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_edit_{{ $item->id_paket }}_warna_font" style="background-color: {{ $item->warna_font ?? '#1f2937' }};">
                                            <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_font', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="{{ $item->warna_font ?? '#1f2937' }}" />
                                        </div>
                                        <input type="text" id="edit_{{ $item->id_paket }}_warna_font" name="warna_font" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="{{ $item->warna_font ?? '#1f2937' }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="form-control">
                                    <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Border</span></label>
                                    <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-success focus-within:ring-2 focus-within:ring-success/10 transition-all shadow-sm">
                                        <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_edit_{{ $item->id_paket }}_warna_border" style="background-color: {{ $item->warna_border ?? '#e5e7eb' }};">
                                            <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_border', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="{{ $item->warna_border ?? '#e5e7eb' }}" />
                                        </div>
                                        <input type="text" id="edit_{{ $item->id_paket }}_warna_border" name="warna_border" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="{{ $item->warna_border ?? '#e5e7eb' }}" />
                                    </div>
                                </div>
                                <div class="form-control">
                                    <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Warna Tombol</span></label>
                                    <div class="flex gap-2.5 items-center bg-base-100 hover:bg-base-200/40 p-1.5 rounded-xl border border-base-300 focus-within:border-success focus-within:ring-2 focus-within:ring-success/10 transition-all shadow-sm">
                                        <div class="relative w-8 h-8 rounded-lg border border-base-300 shadow-sm shrink-0 overflow-hidden cursor-pointer transition-transform hover:scale-105" id="preview_color_indicator_edit_{{ $item->id_paket }}_warna_button" style="background-color: {{ $item->warna_button ?? '#2563eb' }};">
                                            <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_button', this.value)" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" value="{{ $item->warna_button ?? '#2563eb' }}" />
                                        </div>
                                        <input type="text" id="edit_{{ $item->id_paket }}_warna_button" name="warna_button" class="input input-sm border-none bg-transparent w-full text-center font-mono text-xs focus:outline-none p-0 tracking-wide" value="{{ $item->warna_button ?? '#2563eb' }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Font Family</span></label>
                                <select name="font_family"
                                    class="select select-bordered select-sm rounded-lg w-full bg-base-100">
                                    <option value="Inter" {{ $item->font_family === 'Inter' ? 'selected' : '' }}>Inter (Default)</option>
                                    <option value="Poppins" {{ $item->font_family === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                                    <option value="Roboto" {{ $item->font_family === 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                    <option value="Montserrat" {{ $item->font_family === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                    <option value="Outfit" {{ $item->font_family === 'Outfit' ? 'selected' : '' }}>Outfit</option>
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label p-1"><span class="label-text text-[11px] font-bold text-base-content/75 uppercase tracking-wide">Pill Informasi (Badge)</span></label>
                                <input type="text"
                                    id="badge_text_edit_{{ $item->id_paket }}" name="badge_text" value="{{ $item->badge_text }}"
                                    class="input input-bordered input-sm rounded-lg w-full mb-2 bg-base-100" placeholder="Contoh: Terpopuler" />
                                <div class="flex flex-wrap gap-1.5">
                                    <button type="button"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-success/10 hover:text-success hover:border-success/20 transition-all bg-base-100 font-sans"
                                        onclick="selectBadge('edit_{{ $item->id_paket }}', 'Terpopuler')">Terpopuler</button>
                                    <button type="button"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-success/10 hover:text-success hover:border-success/20 transition-all bg-base-100 font-sans"
                                        onclick="selectBadge('edit_{{ $item->id_paket }}', 'Promo')">Promo</button>
                                    <button type="button"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-success/10 hover:text-success hover:border-success/20 transition-all bg-base-100 font-sans"
                                        onclick="selectBadge('edit_{{ $item->id_paket }}', 'Terbatas')">Terbatas</button>
                                    <button type="button"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-success/10 hover:text-success hover:border-success/20 transition-all bg-base-100 font-sans"
                                        onclick="selectBadge('edit_{{ $item->id_paket }}', 'Unlimited')">Unlimited</button>
                                    <button type="button"
                                        class="px-2.5 py-1 text-[10px] font-bold border border-base-300 rounded-full cursor-pointer hover:bg-success/10 hover:text-success hover:border-success/20 transition-all bg-base-100 font-sans"
                                        onclick="selectBadge('edit_{{ $item->id_paket }}', 'Weekend')">Weekend</button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-base-100/50 border-t border-base-200 text-center text-[10px] text-base-content/40 font-mono shrink-0">
                            Tema disinkronkan otomatis
                        </div>
                    </div>

                    <!-- COLUMN 3: Live Preview (Width: lg:w-[340px]) -->
                    <div id="preview_card_container_edit_{{ $item->id_paket }}" class="hidden lg:w-[340px] border-t lg:border-t-0 lg:border-l border-base-200 bg-base-200/20 p-6 flex flex-col items-center justify-start lg:overflow-y-auto scrollbar-thin shrink-0">
                        <div class="w-full text-center pb-2 border-b border-base-200/60 mb-6 shrink-0">
                            <span class="text-xs font-bold text-base-content/70 uppercase tracking-wider flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-success"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                Pratinjau Tampilan
                            </span>
                        </div>
                        
                        <div class="live-preview-card w-full rounded-3xl border p-6 space-y-6 relative overflow-hidden transition-all duration-300 shadow-lg flex flex-col justify-between bg-white text-base-content" style="font-family: 'Inter', sans-serif;">
                             <!-- Mesh Grid Decor -->
                             <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]"></div>
                             
                             <!-- Glow decoration -->
                             <div class="pricing-mesh-bg"></div>
                             <div class="absolute -top-12 -right-12 w-28 h-28 bg-success/10 rounded-full blur-2xl pointer-events-none"></div>

                             <div class="space-y-6 flex-1 flex flex-col justify-between relative z-10">
                                 <div class="space-y-4">
                                     <div class="flex justify-between items-center">
                                         <span class="preview-tag text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-md bg-success/15 text-success">
                                             Jaringan FTTH
                                         </span>
                                         <span class="preview-badge badge font-black text-[9px] uppercase tracking-wider py-2.5 px-3 text-white border-none shadow-md hidden" style="background-color: #22c55e;">
                                             Terpopuler
                                         </span>
                                     </div>
                                     
                                     <div class="flex items-center gap-3">
                                         <div class="preview-icon-wrapper w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-success/15 text-success">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/></svg>
                                         </div>
                                         <h3 class="preview-title text-xl font-black leading-tight tracking-tight">
                                             Nama Paket
                                         </h3>
                                     </div>
                                 </div>
                                 
                                 <div class="preview-price-container py-2 space-y-1 relative z-10">
                                     <!-- Promo section -->
                                     <div class="preview-promo-old-price text-xs font-semibold opacity-50 line-through hidden">
                                         Rp 150.000
                                     </div>
                                     <div class="flex items-baseline justify-start gap-1">
                                         <span class="preview-price text-5xl font-black tracking-tight">
                                             150K
                                         </span>
                                         <span class="preview-price-unit text-xs font-bold opacity-70">/bulan</span>
                                     </div>
                                     <div class="preview-promo-badge inline-flex items-center gap-1 text-[9px] font-black uppercase tracking-wider text-secondary mt-1 bg-secondary/15 px-2 py-0.5 rounded hidden">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-secondary w-3 h-3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                         <span>PROMO</span>
                                     </div>
                                 </div>
                                 
                                 <div class="border-t border-base-300/40 my-1 relative z-10"></div>
                                 
                                 <ul class="preview-points space-y-3 text-xs font-medium pt-2 relative z-10">
                                     <!-- Dynamically generated points -->
                                 </ul>
                             </div>
                             
                             <!-- Action Button Card -->
                             <div class="pt-4 border-t border-base-300/40 relative z-10">
                                 <div class="preview-button w-full py-3 rounded-xl font-bold text-xs text-center text-white shadow-lg transition-all uppercase" style="background-color: #22c55e;">
                                     PILIH PAKET
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-base-200 bg-base-50/50 flex justify-end gap-3 shrink-0">
                    <button type="button" class="btn btn-outline btn-md rounded-xl font-bold" onclick="closeEditPaketModal('{{ $item->id_paket }}')">Batal</button>
                    <button type="submit" class="btn btn-success text-white px-6 btn-md rounded-xl font-bold shadow-md shadow-success/20 hover:shadow-success/30 transition-all duration-300">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal Hapus -->
    <dialog id="modal_hapus_{{ $item->id_paket }}" class="modal">
        <div class="modal-box text-center">
            <div class="text-error mb-4 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            </div>
            <h3 class="font-bold text-lg">Hapus Paket?</h3>
            <p class="py-4">Yakin ingin menghapus paket <strong>{{ $item->title_paket }}</strong>?</p>
            <div class="modal-action justify-center">
                <form method="dialog">
                    <button class="btn mr-2">Batal</button>
                </form>
                <form action="{{ route('admin.paket.destroy', $item->id_paket) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error text-white">Hapus</button>
                </form>
            </div>
        </div>
    </dialog>
@endforeach

<script>
    // ═══════════════════════════════════════════
    // Theme Customizer Toggle Script
    // ═══════════════════════════════════════════
    function toggleThemePanel(id) {
        const optionsPanel = document.getElementById('dragable_theme_' + id);
        const previewPanel = document.getElementById('preview_card_container_' + id);
        const modalBox = document.getElementById('modal_box_' + id);
        
        if (optionsPanel) {
            optionsPanel.classList.toggle('hidden');
        }
        if (previewPanel) {
            previewPanel.classList.toggle('hidden');
        }
        
        if (modalBox) {
            if (optionsPanel && !optionsPanel.classList.contains('hidden')) {
                modalBox.classList.remove('max-w-lg');
                modalBox.classList.add('lg:max-w-6xl');
            } else {
                modalBox.classList.remove('lg:max-w-6xl');
                modalBox.classList.add('max-w-lg');
            }
        }
        
        if (optionsPanel && !optionsPanel.classList.contains('hidden')) {
            updateLivePreview(id);
        }
    }

    function syncColorInput(prefix, type, color) {
        const textInput = document.getElementById(prefix + '_' + type);
        if (textInput) {
            textInput.value = color;
        }
        const indicator = document.getElementById('preview_color_indicator_' + prefix + '_' + type);
        if (indicator) {
            indicator.style.backgroundColor = color;
        }
        updateLivePreview(prefix);
    }

    function syncColorPicker(prefix, type, color) {
        const textInput = document.getElementById(prefix + '_' + type);
        if (textInput && textInput.parentNode) {
            const colorPicker = textInput.parentNode.querySelector('input[type="color"]');
            if (colorPicker && colorPicker.value !== color) {
                if (/^#[0-9A-F]{6}$/i.test(color)) {
                    colorPicker.value = color;
                }
            }
        }
        const indicator = document.getElementById('preview_color_indicator_' + prefix + '_' + type);
        if (indicator) {
            indicator.style.backgroundColor = color;
        }
        updateLivePreview(prefix);
    }

    // ═══════════════════════════════════════════
    // Theme Presets (Default, Dark, Ocean, Sunset)
    // ═══════════════════════════════════════════
    const THEME_PRESETS = {
        default: { nama: '', bg: '#ffffff', font: '#1f2937', border: '#e5e7eb', button: '#2563eb', fontFamily: 'Inter' },
        dark: { nama: 'Dark Mode', bg: '#1a1a2e', font: '#e0e0e0', border: '#3a3a5c', button: '#6366f1', fontFamily: 'Inter' },
        ocean: { nama: 'Ocean Blue', bg: '#0f172a', font: '#e2e8f0', border: '#1e40af', button: '#3b82f6', fontFamily: 'Poppins' },
        sunset: { nama: 'Sunset Warm', bg: '#fef3c7', font: '#78350f', border: '#f59e0b', button: '#d97706', fontFamily: 'Outfit' },
    };

    function applyPreset(prefix, presetKey) {
        const preset = THEME_PRESETS[presetKey];
        if (!preset) return;

        const formId = prefix === 'tambah' ? 'form_tambah_paket' : 'form_edit_paket_' + prefix.replace('edit_', '');
        const form = document.getElementById(formId);
        const panel = document.getElementById('dragable_theme_' + prefix);

        const namaInput = panel ? panel.querySelector('[name="nama_tema"]') : (form ? form.querySelector('[name="nama_tema"]') : null);
        if (namaInput) namaInput.value = preset.nama;

        const colorFields = ['warna_bg', 'warna_font', 'warna_border', 'warna_button'];
        const presetValues = [preset.bg, preset.font, preset.border, preset.button];
        colorFields.forEach((field, i) => {
            const textEl = document.getElementById(prefix + '_' + field);
            if (textEl) textEl.value = presetValues[i];
            if (textEl && textEl.parentNode) {
                const colorPicker = textEl.parentNode.querySelector('input[type="color"]');
                if (colorPicker) colorPicker.value = presetValues[i];
            }
            const indicator = document.getElementById('preview_color_indicator_' + prefix + '_' + field);
            if (indicator) indicator.style.backgroundColor = presetValues[i];
        });

        const fontSelect = panel ? panel.querySelector('[name="font_family"]') : (form ? form.querySelector('[name="font_family"]') : null);
        if (fontSelect) fontSelect.value = preset.fontFamily;

        updateLivePreview(prefix);
    }

    function selectBadge(prefix, badgeText) {
        const input = document.getElementById('badge_text_' + prefix);
        if (input) {
            input.value = badgeText;
            updateLivePreview(prefix);
        }
    }

    function addPointField(prefix) {
        const container = document.getElementById('points_container_' + prefix);
        if (!container) return;

        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <input type="text" name="point_informasi[]" class="input input-bordered input-sm flex-1" placeholder="Masukkan poin informasi..." required />
            <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
        `;
        container.appendChild(div);
        updateLivePreview(prefix);
    }

    function removePointField(btn) {
        const container = btn.parentNode.parentNode;
        const prefix = container.id.replace('points_container_', '');
        btn.parentNode.remove();
        updateLivePreview(prefix);
    }

    function closeTambahPaketModal() {
        document.getElementById('modal_tambah_paket').close();
        document.getElementById('dragable_theme_tambah')?.classList.add('hidden');
        document.getElementById('preview_card_container_tambah')?.classList.add('hidden');
        const modalBox = document.getElementById('modal_box_tambah');
        if (modalBox) {
            modalBox.classList.remove('lg:max-w-6xl');
            modalBox.classList.add('max-w-lg');
        }
    }

    function closeEditPaketModal(id) {
        document.getElementById('modal_edit_' + id).close();
        document.getElementById('dragable_theme_edit_' + id)?.classList.add('hidden');
        document.getElementById('preview_card_container_edit_' + id)?.classList.add('hidden');
        const modalBox = document.getElementById('modal_box_edit_' + id);
        if (modalBox) {
            modalBox.classList.remove('lg:max-w-6xl');
            modalBox.classList.add('max-w-lg');
        }
    }

    function toggleAnnouncementSection(checked) {
        const container = document.getElementById('announcement_fields_container');
        if (container) {
            container.classList.toggle('hidden', !checked);
            if (checked) updateAnnouncementPlaceholders();
        }
    }

    function updateAnnouncementPlaceholders() {
        const titleInput = document.querySelector('#modal_tambah_paket [name="title_paket"]');
        const priceInput = document.querySelector('#modal_tambah_paket [name="harga_paket"]');

        const titleVal = titleInput ? titleInput.value : '';
        const priceVal = priceInput ? priceInput.value : '';

        const idEl = document.querySelector('#modal_tambah_paket [name="announcement_id"]');
        const temaEl = document.querySelector('#modal_tambah_paket [name="announcement_tema"]');
        const textEl = document.querySelector('#modal_tambah_paket [name="announcement_text"]');

        if (idEl && !idEl.value) idEl.value = 'P' + Math.floor(100 + Math.random() * 899);
        if (temaEl && !temaEl.value) temaEl.value = 'Promo Paket Baru';

        if (textEl) {
            let priceFormatted = priceVal ? parseInt(priceVal).toLocaleString('id-ID') : '0';
            const valueString = `Telah hadir paket baru: ${titleVal || '[Nama Paket]'} dengan harga Rp ${priceFormatted || '[Harga]'} / bulan!`;
            textEl.placeholder = valueString;
            if (!textEl.value || textEl.value.startsWith('Telah hadir paket baru:')) {
                textEl.value = valueString;
            }
        }
    }

    function updateLivePreview(prefix) {
        const formId = prefix === 'tambah' ? 'form_tambah_paket' : 'form_edit_paket_' + prefix.replace('edit_', '');
        const panelId = 'dragable_theme_' + prefix;
        const form = document.getElementById(formId);
        const panel = document.getElementById(panelId);
        if (!form || !panel) return;

        const bg = document.getElementById(prefix + '_warna_bg')?.value || '#ffffff';
        const font = document.getElementById(prefix + '_warna_font')?.value || '#1f2937';
        const border = document.getElementById(prefix + '_warna_border')?.value || '#e5e7eb';
        const button = document.getElementById(prefix + '_warna_button')?.value || '#2563eb';
        const fontFamily = panel.querySelector('[name="font_family"]')?.value || 'Inter';
        const badgeText = document.getElementById('badge_text_' + prefix)?.value || '';

        const title = form.querySelector('[name="title_paket"]')?.value || 'Nama Paket';
        const hargaVal = parseInt(form.querySelector('[name="harga_paket"]')?.value || '0', 10) || 0;

        const promoSelect = form.querySelector('[name="id_promosi"]');
        const selectedPromoOpt = promoSelect ? promoSelect.options[promoSelect.selectedIndex] : null;
        const discount = selectedPromoOpt ? parseInt(selectedPromoOpt.getAttribute('data-discount') || '0', 10) : 0;
        const promoText = selectedPromoOpt ? selectedPromoOpt.getAttribute('data-text') || '' : '';

        const pointInputs = form.querySelectorAll('[name="point_informasi[]"]');
        const points = Array.from(pointInputs).map(inp => inp.value).filter(val => val.trim() !== '');

        // Select live preview elements inside the actual .live-preview-card (not the column wrapper)
        const cardContainer = document.getElementById('preview_card_container_' + prefix);
        if (!cardContainer) return;
        const card = cardContainer.querySelector('.live-preview-card');
        if (!card) return;

        const previewTag = card.querySelector('.preview-tag');
        const previewBadge = card.querySelector('.preview-badge');
        const previewIconWrapper = card.querySelector('.preview-icon-wrapper');
        const previewTitle = card.querySelector('.preview-title');
        const previewPromoOldPrice = card.querySelector('.preview-promo-old-price');
        const previewPrice = card.querySelector('.preview-price');
        const previewPromoBadge = card.querySelector('.preview-promo-badge');
        const previewPoints = card.querySelector('.preview-points');
        const previewButton = card.querySelector('.preview-button');

        card.style.backgroundColor = bg;
        card.style.borderColor = border;
        card.style.boxShadow = `0 10px 30px -10px ${border}60`;
        card.style.color = font;
        card.style.fontFamily = `'${fontFamily}', sans-serif`;

        if (previewTag) {
            previewTag.style.color = font;
            previewTag.style.opacity = '0.8';
            previewTag.style.backgroundColor = button + '25';
        }

        if (previewIconWrapper) {
            previewIconWrapper.style.backgroundColor = button + '25';
            previewIconWrapper.style.color = button;
        }

        if (previewTitle) {
            previewTitle.innerText = title;
            previewTitle.style.color = font;
        }

        if (previewBadge) {
            if (badgeText.trim()) {
                previewBadge.innerText = badgeText;
                previewBadge.style.backgroundColor = button;
                previewBadge.style.borderColor = button;
                previewBadge.style.boxShadow = `0 4px 12px -2px ${button}60`;
                previewBadge.classList.remove('hidden');
            } else {
                previewBadge.classList.add('hidden');
            }
        }

        const hasPromo = discount > 0 && promoText.trim() !== '';
        if (previewPromoOldPrice) {
            if (hasPromo) {
                previewPromoOldPrice.innerText = `Rp ${hargaVal.toLocaleString('id-ID')}`;
                previewPromoOldPrice.style.color = font;
                previewPromoOldPrice.style.opacity = '0.5';
                previewPromoOldPrice.classList.remove('hidden');
            } else {
                previewPromoOldPrice.classList.add('hidden');
            }
        }

        if (previewPrice) {
            const finalPrice = hasPromo ? Math.max(0, hargaVal - discount) : hargaVal;
            const priceFormatted = finalPrice >= 1000 ? Math.floor(finalPrice / 1000) + 'K' : finalPrice;
            previewPrice.innerText = finalPrice >= 1000 ? priceFormatted : `Rp ${finalPrice}`;
            previewPrice.style.color = font;
        }

        if (previewPromoBadge) {
            if (hasPromo) {
                const badgeSpan = previewPromoBadge.querySelector('span');
                if (badgeSpan) badgeSpan.innerText = `PROMO: ${promoText}`;
                previewPromoBadge.style.color = font;
                previewPromoBadge.style.opacity = '0.9';
                previewPromoBadge.classList.remove('hidden');
            } else {
                previewPromoBadge.classList.add('hidden');
            }
        }

        if (previewPoints) {
            previewPoints.innerHTML = '';
            if (points.length > 0) {
                points.forEach(pt => {
                    const li = document.createElement('li');
                    li.className = 'flex items-center gap-2 transition-transform duration-200 hover:translate-x-1';
                    li.innerHTML = `
                        <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 shadow-sm" style="background-color: ${button}25; color: ${button};">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span class="text-[13px] truncate" style="color: ${font};">${pt}</span>
                    `;
                    previewPoints.appendChild(li);
                });
            } else {
                previewPoints.innerHTML = `
                    <li class="text-[13px] opacity-50 italic">Tidak ada poin informasi</li>
                `;
            }
        }

        if (previewButton) {
            previewButton.style.backgroundColor = button;
            previewButton.style.borderColor = button;
            previewButton.style.boxShadow = `0 4px 14px -2px ${button}80`;
        }
    }

    function initLivePreview(prefix) {
        console.log('initLivePreview initialized for:', prefix);
        const formId = prefix === 'tambah' ? 'form_tambah_paket' : 'form_edit_paket_' + prefix.replace('edit_', '');
        const panelId = 'dragable_theme_' + prefix;
        const form = document.getElementById(formId);
        const panel = document.getElementById(panelId);
        if (!form) {
            console.warn('initLivePreview: form not found for prefix', prefix, 'expected ID:', formId);
        }
        if (!panel) {
            console.warn('initLivePreview: theme panel not found for prefix', prefix, 'expected ID:', panelId);
        }
        if (!form || !panel) return;

        const formInputs = form.querySelectorAll('input[name="title_paket"], input[name="harga_paket"], select[name="id_promosi"]');
        formInputs.forEach(input => {
            input.addEventListener('input', () => updateLivePreview(prefix));
            input.addEventListener('change', () => updateLivePreview(prefix));
        });

        const themeInputs = panel.querySelectorAll('input, select');
        themeInputs.forEach(input => {
            input.addEventListener('input', () => updateLivePreview(prefix));
            input.addEventListener('change', () => updateLivePreview(prefix));
        });

        const pointsContainer = document.getElementById('points_container_' + prefix);
        if (pointsContainer) {
            pointsContainer.addEventListener('input', (e) => {
                if (e.target.name === 'point_informasi[]') {
                    updateLivePreview(prefix);
                }
            });
        }

        const colorFields = ['warna_bg', 'warna_font', 'warna_border', 'warna_button'];
        colorFields.forEach(field => {
            const textEl = document.getElementById(prefix + '_' + field);
            if (textEl) {
                textEl.addEventListener('input', (e) => {
                    syncColorPicker(prefix, field, e.target.value);
                });
            }
        });

        updateLivePreview(prefix);
    }

    function initAllPreviews() {
        console.log('initAllPreviews executing...');
        const modalTambah = document.getElementById('modal_tambah_paket');
        if (modalTambah) {
            modalTambah.addEventListener('close', () => {
                document.getElementById('dragable_theme_tambah')?.classList.add('hidden');
                document.getElementById('preview_card_container_tambah')?.classList.add('hidden');
                const modalBox = document.getElementById('modal_box_tambah');
                if (modalBox) {
                    modalBox.classList.remove('lg:max-w-6xl');
                    modalBox.classList.add('max-w-lg');
                }
            });
        }
        initLivePreview('tambah');

        @foreach($paket as $item)
            const modalEdit_{{ $item->id_paket }} = document.getElementById('modal_edit_{{ $item->id_paket }}');
            if (modalEdit_{{ $item->id_paket }}) {
                modalEdit_{{ $item->id_paket }}.addEventListener('close', () => {
                    document.getElementById('dragable_theme_edit_{{ $item->id_paket }}')?.classList.add('hidden');
                    document.getElementById('preview_card_container_edit_{{ $item->id_paket }}')?.classList.add('hidden');
                    const modalBox = document.getElementById('modal_box_edit_{{ $item->id_paket }}');
                    if (modalBox) {
                        modalBox.classList.remove('lg:max-w-6xl');
                        modalBox.classList.add('max-w-lg');
                    }
                });
            }
            initLivePreview('edit_{{ $item->id_paket }}');
        @endforeach

        window.initAllPreviews = initAllPreviews;
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllPreviews);
    } else {
        initAllPreviews();
    }
</script>