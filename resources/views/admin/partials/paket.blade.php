<!-- Paket Partial -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Paket Internet</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola paket internet yang tersedia dari database</p>
    </div>
    <button onclick="document.getElementById('modal_tambah_paket').showModal()" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Paket
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($paket as $item)
    <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
        <div class="card-body">
            <div class="flex justify-between items-start mb-2">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
                </div>
                <div class="flex flex-col items-end gap-1">
                    @if($item->is_hidden)
                        <div class="px-2.5 py-1 bg-warning/10 text-warning font-semibold text-xs rounded-md border border-warning/20 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            Sembunyi
                        </div>
                    @else
                        <div class="px-2.5 py-1 bg-success/10 text-success font-semibold text-xs rounded-md border border-success/20 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Aktif
                        </div>
                    @endif
                    @if($item->id_promosi)
                        <span class="badge badge-secondary badge-xs font-bold mt-1">PROMO</span>
                    @endif
                </div>
            </div>
            <h2 class="card-title text-2xl">{{ $item->title_paket }}</h2>
            <p class="text-sm text-base-content/50 mb-1">ID: {{ $item->id_paket }}</p>
            
            <div class="my-2">
                <span class="text-3xl font-bold text-base-content">Rp {{ number_format($item->harga_paket, 0, ',', '.') }}</span>
                <span class="text-sm text-base-content/50">/bulan</span>
            </div>

            <div class="text-xs space-y-1 text-base-content/70 mt-2 border-t border-base-200/50 pt-2">
                <p><strong>Promosi:</strong> {{ $item->promosi ? $item->promosi->text_promosi : 'Tidak ada' }}</p>
                <p><strong>Tema:</strong> {{ $item->nama_tema ? $item->nama_tema : 'Default (Tidak ada)' }}</p>
                @if($item->badge_text)
                    <p><strong>Badge:</strong> <span class="badge badge-outline badge-xs font-semibold">{{ $item->badge_text }}</span></p>
                @endif
                @if($item->point_keunggulan && count($item->point_keunggulan) > 0)
                    <p><strong>Keunggulan:</strong> {{ count($item->point_keunggulan) }} Poin</p>
                @endif
            </div>

            <div class="flex flex-col gap-2 mt-4 border-t border-base-200 pt-4">
                <div class="flex gap-2">
                    <button onclick="document.getElementById('modal_edit_{{ $item->id_paket }}').showModal()" class="btn btn-sm btn-outline btn-success flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </button>
                    <button onclick="document.getElementById('modal_hapus_{{ $item->id_paket }}').showModal()" class="btn btn-sm btn-outline btn-error flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        Hapus
                    </button>
                </div>
                <form action="{{ route('admin.paket.toggle_hide', $item->id_paket) }}" method="POST" class="w-full">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-outline w-full {{ $item->is_hidden ? 'btn-info' : 'btn-warning' }}">
                        @if($item->is_hidden)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Tampilkan di Publik
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            Sembunyikan
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center text-base-content/50 bg-base-100 rounded-xl border border-base-200">
        Belum ada data paket internet di database.
    </div>
    @endforelse
</div>

<!-- Modal Tambah -->
<dialog id="modal_tambah_paket" class="modal">
  <div class="flex flex-col lg:flex-row gap-6 items-center justify-center max-w-5xl mx-auto p-4 z-10 pointer-events-auto max-h-[95vh] overflow-y-auto scrollbar-thin">
    <div class="modal-box w-full max-w-lg m-0">
      <h3 class="font-bold text-lg mb-4">Tambah Paket Baru</h3>
      <form id="form_tambah_paket" action="{{ route('admin.paket.store') }}" method="POST">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-control mb-4">
                  <label class="label"><span class="label-text font-medium">ID Paket</span></label>
                  <input type="text" name="id_paket" class="input input-bordered w-full" placeholder="Contoh: PK04" required />
              </div>
              <div class="form-control mb-4">
                  <label class="label"><span class="label-text font-medium">Hubungan Promosi</span></label>
                  <select name="id_promosi" class="select select-bordered w-full">
                      <option value="">-- Tanpa Promosi --</option>
                      @foreach($promosi as $p)
                          <option value="{{ $p->id_promosi }}">{{ $p->id_promosi }} - {{ $p->text_promosi }} (Diskon: {{ number_format($p->value_promosi) }})</option>
                      @endforeach
                  </select>
              </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-control mb-4">
                  <label class="label"><span class="label-text font-medium">Nama Paket</span></label>
                  <input type="text" name="title_paket" oninput="updateAnnouncementPlaceholders()" class="input input-bordered w-full" placeholder="Contoh: Super Cepat" required />
              </div>
              <div class="form-control mb-4">
                  <label class="label"><span class="label-text font-medium">Harga Paket (Rp)</span></label>
                  <input type="number" name="harga_paket" oninput="updateAnnouncementPlaceholders()" class="input input-bordered w-full" placeholder="150000" required />
              </div>
          </div>

          <!-- Theme Customizer Trigger Button -->
          <div class="form-control mb-4 border border-base-300 rounded-xl p-3 bg-base-100 flex flex-row items-center justify-between">
              <div>
                  <span class="font-bold text-sm block">Kustomisasi Tema Paket</span>
                  <span class="text-xs text-base-content/50">Atur warna latar, font, dan keunggulan khusus.</span>
              </div>
              <button type="button" onclick="toggleThemePanel('tambah')" class="btn btn-sm btn-primary">
                  Konfigurasi Tema
              </button>
          </div>

          <!-- Automatic Announcement Toggle and Placeholder fields -->
          <div class="divider my-4"></div>
          <div class="form-control mb-2">
              <label class="label cursor-pointer justify-start gap-3">
                  <input type="checkbox" name="create_announcement" id="toggle_create_announcement" value="1" onchange="toggleAnnouncementSection(this.checked)" class="checkbox checkbox-primary checkbox-sm" />
                  <span class="label-text font-bold text-sm">Buat Pengumuman Otomatis untuk Paket Ini</span>
              </label>
          </div>

          <div id="announcement_fields_container" class="hidden border border-primary/20 bg-primary/5 rounded-2xl p-4 mt-2 space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="form-control">
                      <label class="label p-1"><span class="label-text text-xs font-semibold">ID Pengumuman</span></label>
                      <input type="text" name="announcement_id" class="input input-bordered input-sm w-full bg-base-100" placeholder="PENG05" />
                  </div>
                  <div class="form-control">
                      <label class="label p-1"><span class="label-text text-xs font-semibold">Tema Pengumuman</span></label>
                      <input type="text" name="announcement_tema" class="input input-bordered input-sm w-full bg-base-100" value="Promo Paket Baru" placeholder="Maintenance / Promo" />
                  </div>
              </div>
              <div class="form-control">
                  <label class="label p-1"><span class="label-text text-xs font-semibold">Isi Pengumuman</span></label>
                  <textarea name="announcement_text" class="textarea textarea-bordered textarea-sm h-16 w-full bg-base-100" placeholder="Masukkan pengumuman..."></textarea>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="form-control">
                      <label class="label p-1"><span class="label-text text-xs font-semibold">Tanggal Mulai</span></label>
                      <input type="date" name="announcement_valid_start" class="input input-bordered input-sm w-full bg-base-100" value="{{ date('Y-m-d') }}" />
                  </div>
                  <div class="form-control">
                      <label class="label p-1"><span class="label-text text-xs font-semibold">Tanggal Berakhir</span></label>
                      <input type="date" name="announcement_valid_end" class="input input-bordered input-sm w-full bg-base-100" value="{{ date('Y-m-d', strtotime('+30 days')) }}" />
                  </div>
              </div>
          </div>
          
          <div class="modal-action mt-6 border-t border-base-200 pt-4">
              <button type="button" class="btn btn-outline" onclick="closeTambahPaketModal()">Batal</button>
              <button type="submit" class="btn btn-primary px-6">Simpan</button>
          </div>
      </form>
    </div>
    
    <!-- THEME PANEL (TAMBAH) -->
    <div id="dragable_theme_tambah" class="card bg-base-100 shadow-2xl border border-base-300 w-full max-w-lg lg:w-80 hidden rounded-2xl overflow-hidden shadow-primary/10">
        <div class="bg-primary text-primary-content p-4 flex justify-between items-center rounded-t-2xl">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/><path d="M12 8V16"/><path d="M8 12H16"/></svg>
                <span class="font-bold text-sm uppercase tracking-wider">Kustomisasi Tema Paket</span>
            </div>
            <button type="button" onclick="toggleThemePanel('tambah')" class="btn btn-sm btn-circle btn-ghost text-primary-content hover:bg-primary-focus">×</button>
        </div>
        <div class="p-4 space-y-4 lg:max-h-[450px] lg:overflow-y-auto overflow-visible h-auto scrollbar-thin">
            <!-- Preset Buttons -->
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="applyPreset('tambah', 'default')" class="btn btn-xs btn-outline gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg> Default</button>
                <button type="button" onclick="applyPreset('tambah', 'dark')" class="btn btn-xs btn-neutral gap-1">🌙 Dark</button>
                <button type="button" onclick="applyPreset('tambah', 'ocean')" class="btn btn-xs btn-info btn-outline gap-1">🌊 Ocean</button>
                <button type="button" onclick="applyPreset('tambah', 'sunset')" class="btn btn-xs btn-warning btn-outline gap-1">🌅 Sunset</button>
            </div>
            <div class="form-control">
                <label class="label p-1"><span class="label-text text-xs font-semibold">Nama Tema</span></label>
                <input type="text" form="form_tambah_paket" name="nama_tema" class="input input-bordered input-sm w-full" placeholder="Contoh: Light Orange / Cyberpunk" />
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Latar</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('tambah', 'warna_bg', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="#ffffff" />
                        <input type="text" form="form_tambah_paket" id="tambah_warna_bg" name="warna_bg" class="input input-bordered input-sm w-full text-center font-mono" value="#ffffff" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Font</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('tambah', 'warna_font', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="#1f2937" />
                        <input type="text" form="form_tambah_paket" id="tambah_warna_font" name="warna_font" class="input input-bordered input-sm w-full text-center font-mono" value="#1f2937" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Border/Glow</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('tambah', 'warna_border', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="#e5e7eb" />
                        <input type="text" form="form_tambah_paket" id="tambah_warna_border" name="warna_border" class="input input-bordered input-sm w-full text-center font-mono" value="#e5e7eb" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Tombol</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('tambah', 'warna_button', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="#2563eb" />
                        <input type="text" form="form_tambah_paket" id="tambah_warna_button" name="warna_button" class="input input-bordered input-sm w-full text-center font-mono" value="#2563eb" />
                    </div>
                </div>
            </div>

            <div class="form-control">
                <label class="label p-1"><span class="label-text text-xs font-semibold">Font Family</span></label>
                <select form="form_tambah_paket" name="font_family" class="select select-bordered select-sm w-full">
                    <option value="Inter">Inter (Default)</option>
                    <option value="Poppins">Poppins</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Outfit">Outfit</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label p-1"><span class="label-text text-xs font-semibold">Pill Informasi (Badge)</span></label>
                <input type="text" form="form_tambah_paket" id="badge_text_tambah" name="badge_text" class="input input-bordered input-sm w-full" placeholder="Contoh: Terpopuler" />
                <div class="flex flex-wrap gap-1.5 mt-1.5">
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-primary hover:text-primary-content transition-colors font-medium" onclick="selectBadge('tambah', 'Terpopuler')">Terpopuler</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-primary hover:text-primary-content transition-colors font-medium" onclick="selectBadge('tambah', 'Promo')">Promo</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-primary hover:text-primary-content transition-colors font-medium" onclick="selectBadge('tambah', 'Terbatas')">Terbatas</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-primary hover:text-primary-content transition-colors font-medium" onclick="selectBadge('tambah', 'Unlimited')">Unlimited</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-primary hover:text-primary-content transition-colors font-medium" onclick="selectBadge('tambah', 'Weekend')">Weekend</button>
                </div>
            </div>

            <div class="divider my-1"></div>
            
            <div class="form-control">
                <div class="flex justify-between items-center mb-2">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Poin-poin Keunggulan</span></label>
                    <button type="button" onclick="addPointField('tambah')" class="btn btn-sm btn-outline btn-primary">Tambah Poin</button>
                </div>
                <div id="points_container_tambah" class="space-y-2">
                    <div class="flex items-center gap-2">
                        <input type="text" form="form_tambah_paket" name="point_keunggulan[]" value="Kuota 100% Unlimited Murni" class="input input-bordered input-sm flex-1" required />
                        <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" form="form_tambah_paket" name="point_keunggulan[]" value="Bebas Lag &amp; Throttling FUP" class="input input-bordered input-sm flex-1" required />
                        <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" form="form_tambah_paket" name="point_keunggulan[]" value="Modem WiFi ONT Dipinjamkan Gratis" class="input input-bordered input-sm flex-1" required />
                        <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button onclick="closeTambahPaketModal()">close</button>
  </form>
</dialog>

@foreach($paket as $item)
<!-- Modal Edit -->
<dialog id="modal_edit_{{ $item->id_paket }}" class="modal">
  <div class="flex flex-col lg:flex-row gap-6 items-center justify-center max-w-5xl mx-auto p-4 z-10 pointer-events-auto max-h-[95vh] overflow-y-auto scrollbar-thin">
    <div class="modal-box w-full max-w-lg m-0">
      <h3 class="font-bold text-lg mb-4">Edit Paket: {{ $item->title_paket }}</h3>
      <form id="form_edit_paket_{{ $item->id_paket }}" action="{{ route('admin.paket.update', $item->id_paket) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="form-control mb-4">
              <label class="label"><span class="label-text font-medium">Hubungan Promosi</span></label>
              <select name="id_promosi" class="select select-bordered w-full">
                  <option value="">-- Tanpa Promosi --</option>
                  @foreach($promosi as $p)
                      <option value="{{ $p->id_promosi }}" {{ $item->id_promosi === $p->id_promosi ? 'selected' : '' }}>
                          {{ $p->id_promosi }} - {{ $p->text_promosi }} (Diskon: {{ number_format($p->value_promosi) }})
                      </option>
                  @endforeach
              </select>
          </div>

          <div class="form-control mb-4">
              <label class="label"><span class="label-text font-medium">Nama Paket</span></label>
              <input type="text" name="title_paket" value="{{ $item->title_paket }}" class="input input-bordered w-full" required />
          </div>
          <div class="form-control mb-4">
              <label class="label"><span class="label-text font-medium">Harga Paket (Rp)</span></label>
              <input type="number" name="harga_paket" value="{{ $item->harga_paket }}" class="input input-bordered w-full" required />
          </div>

          <!-- Theme Customizer Trigger Button -->
          <div class="form-control mb-4 border border-base-300 rounded-xl p-3 bg-base-100 flex flex-row items-center justify-between">
              <div>
                  <span class="font-bold text-sm block">Kustomisasi Tema Paket</span>
                  <span class="text-xs text-base-content/50">Edit warna latar, font, dan keunggulan khusus.</span>
              </div>
              <button type="button" onclick="toggleThemePanel('edit_{{ $item->id_paket }}')" class="btn btn-sm btn-success text-white">
                  Konfigurasi Tema
              </button>
          </div>
          
          <div class="modal-action border-t border-base-200 pt-4 mt-6">
              <button type="button" class="btn btn-outline" onclick="closeEditPaketModal('{{ $item->id_paket }}')">Batal</button>
              <button type="submit" class="btn btn-success text-white px-6">Simpan Perubahan</button>
          </div>
      </form>
    </div>
    
    <!-- THEME PANEL (EDIT: {{ $item->id_paket }}) -->
    <div id="dragable_theme_edit_{{ $item->id_paket }}" class="card bg-base-100 shadow-2xl border border-base-300 w-full max-w-lg lg:w-80 hidden rounded-2xl overflow-hidden shadow-success/10">
        <div class="bg-success text-success-content p-4 flex justify-between items-center rounded-t-2xl">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span class="font-bold text-sm uppercase tracking-wider">Kustomisasi Tema Paket</span>
            </div>
            <button type="button" onclick="toggleThemePanel('edit_{{ $item->id_paket }}')" class="btn btn-sm btn-circle btn-ghost text-success-content hover:bg-success-focus">×</button>
        </div>
        <div class="p-4 space-y-4 lg:max-h-[450px] lg:overflow-y-auto overflow-visible h-auto scrollbar-thin">
            <!-- Preset Buttons -->
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'default')" class="btn btn-xs btn-outline gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg> Default</button>
                <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'dark')" class="btn btn-xs btn-neutral gap-1">🌙 Dark</button>
                <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'ocean')" class="btn btn-xs btn-info btn-outline gap-1">🌊 Ocean</button>
                <button type="button" onclick="applyPreset('edit_{{ $item->id_paket }}', 'sunset')" class="btn btn-xs btn-warning btn-outline gap-1">🌅 Sunset</button>
            </div>
            <div class="form-control">
                <label class="label p-1"><span class="label-text text-xs font-semibold">Nama Tema</span></label>
                <input type="text" form="form_edit_paket_{{ $item->id_paket }}" name="nama_tema" value="{{ $item->nama_tema }}" class="input input-bordered input-sm w-full" placeholder="Contoh: Light Orange / Cyberpunk" />
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Latar</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_bg', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="{{ $item->warna_bg ?? '#ffffff' }}" />
                        <input type="text" form="form_edit_paket_{{ $item->id_paket }}" id="edit_{{ $item->id_paket }}_warna_bg" name="warna_bg" class="input input-bordered input-sm w-full text-center font-mono" value="{{ $item->warna_bg ?? '#ffffff' }}" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Font</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_font', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="{{ $item->warna_font ?? '#1f2937' }}" />
                        <input type="text" form="form_edit_paket_{{ $item->id_paket }}" id="edit_{{ $item->id_paket }}_warna_font" name="warna_font" class="input input-bordered input-sm w-full text-center font-mono" value="{{ $item->warna_font ?? '#1f2937' }}" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Border/Glow</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_border', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="{{ $item->warna_border ?? '#e5e7eb' }}" />
                        <input type="text" form="form_edit_paket_{{ $item->id_paket }}" id="edit_{{ $item->id_paket }}_warna_border" name="warna_border" class="input input-bordered input-sm w-full text-center font-mono" value="{{ $item->warna_border ?? '#e5e7eb' }}" />
                    </div>
                </div>
                <div class="form-control">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Warna Tombol</span></label>
                    <div class="flex gap-2 items-center">
                        <input type="color" oninput="syncColorInput('edit_{{ $item->id_paket }}', 'warna_button', this.value)" class="w-10 h-10 rounded-lg border border-base-300 cursor-pointer p-0 bg-transparent shrink-0" value="{{ $item->warna_button ?? '#2563eb' }}" />
                        <input type="text" form="form_edit_paket_{{ $item->id_paket }}" id="edit_{{ $item->id_paket }}_warna_button" name="warna_button" class="input input-bordered input-sm w-full text-center font-mono" value="{{ $item->warna_button ?? '#2563eb' }}" />
                    </div>
                </div>
            </div>

            <div class="form-control">
                <label class="label p-1"><span class="label-text text-xs font-semibold">Font Family</span></label>
                <select form="form_edit_paket_{{ $item->id_paket }}" name="font_family" class="select select-bordered select-sm w-full">
                    <option value="Inter" {{ $item->font_family === 'Inter' ? 'selected' : '' }}>Inter (Default)</option>
                    <option value="Poppins" {{ $item->font_family === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                    <option value="Roboto" {{ $item->font_family === 'Roboto' ? 'selected' : '' }}>Roboto</option>
                    <option value="Montserrat" {{ $item->font_family === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                    <option value="Outfit" {{ $item->font_family === 'Outfit' ? 'selected' : '' }}>Outfit</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label p-1"><span class="label-text text-xs font-semibold">Pill Informasi (Badge)</span></label>
                <input type="text" form="form_edit_paket_{{ $item->id_paket }}" id="badge_text_edit_{{ $item->id_paket }}" name="badge_text" value="{{ $item->badge_text }}" class="input input-bordered input-sm w-full" placeholder="Contoh: Terpopuler" />
                <div class="flex flex-wrap gap-1.5 mt-1.5">
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-success hover:text-success-content transition-colors font-medium" onclick="selectBadge('edit_{{ $item->id_paket }}', 'Terpopuler')">Terpopuler</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-success hover:text-success-content transition-colors font-medium" onclick="selectBadge('edit_{{ $item->id_paket }}', 'Promo')">Promo</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-success hover:text-success-content transition-colors font-medium" onclick="selectBadge('edit_{{ $item->id_paket }}', 'Terbatas')">Terbatas</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-success hover:text-success-content transition-colors font-medium" onclick="selectBadge('edit_{{ $item->id_paket }}', 'Unlimited')">Unlimited</button>
                    <button type="button" class="badge badge-outline badge-sm py-2.5 px-3 cursor-pointer hover:bg-success hover:text-success-content transition-colors font-medium" onclick="selectBadge('edit_{{ $item->id_paket }}', 'Weekend')">Weekend</button>
                </div>
            </div>

            <div class="divider my-1"></div>
            
            <div class="form-control">
                <div class="flex justify-between items-center mb-2">
                    <label class="label p-1"><span class="label-text text-xs font-semibold">Poin-poin Keunggulan</span></label>
                    <button type="button" onclick="addPointField('edit_{{ $item->id_paket }}')" class="btn btn-sm btn-outline btn-success">Tambah Poin</button>
                </div>
                <div id="points_container_edit_{{ $item->id_paket }}" class="space-y-2">
                    @if($item->point_keunggulan && is_array($item->point_keunggulan))
                        @foreach($item->point_keunggulan as $pPoint)
                        <div class="flex items-center gap-2">
                            <input type="text" form="form_edit_paket_{{ $item->id_paket }}" name="point_keunggulan[]" value="{{ $pPoint }}" class="input input-bordered input-sm flex-1" required />
                            <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-center gap-2">
                            <input type="text" form="form_edit_paket_{{ $item->id_paket }}" name="point_keunggulan[]" value="Kuota 100% Unlimited Murni" class="input input-bordered input-sm flex-1" required />
                            <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" form="form_edit_paket_{{ $item->id_paket }}" name="point_keunggulan[]" value="Bebas Lag &amp; Throttling FUP" class="input input-bordered input-sm flex-1" required />
                            <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" form="form_edit_paket_{{ $item->id_paket }}" name="point_keunggulan[]" value="Modem WiFi ONT Dipinjamkan Gratis" class="input input-bordered input-sm flex-1" required />
                            <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
  </div>

  <form method="dialog" class="modal-backdrop">
    <button onclick="closeEditPaketModal('{{ $item->id_paket }}')">close</button>
  </form>
</dialog>

<!-- Modal Hapus -->
<dialog id="modal_hapus_{{ $item->id_paket }}" class="modal">
  <div class="modal-box text-center">
    <div class="text-error mb-4 flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
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
        <button type="submit" class="btn btn-error">Hapus</button>
      </form>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
@endforeach

<script>
    // ═══════════════════════════════════════════
    // Theme Customizer Toggle Script
    // ═══════════════════════════════════════════
    function toggleThemePanel(id) {
        const el = document.getElementById('dragable_theme_' + id);
        if (el) el.classList.toggle('hidden');
    }

    function syncColorInput(prefix, type, color) {
        const textInput = document.getElementById(prefix + '_' + type);
        if (textInput) textInput.value = color;
    }

    // ═══════════════════════════════════════════
    // Theme Presets (Default, Dark, Ocean, Sunset)
    // ═══════════════════════════════════════════
    const THEME_PRESETS = {
        default: { nama: '', bg: '#ffffff', font: '#1f2937', border: '#e5e7eb', button: '#2563eb', fontFamily: 'Inter' },
        dark:    { nama: 'Dark Mode', bg: '#1a1a2e', font: '#e0e0e0', border: '#3a3a5c', button: '#6366f1', fontFamily: 'Inter' },
        ocean:   { nama: 'Ocean Blue', bg: '#0f172a', font: '#e2e8f0', border: '#1e40af', button: '#3b82f6', fontFamily: 'Poppins' },
        sunset:  { nama: 'Sunset Warm', bg: '#fef3c7', font: '#78350f', border: '#f59e0b', button: '#d97706', fontFamily: 'Outfit' },
    };

    function applyPreset(prefix, presetKey) {
        const preset = THEME_PRESETS[presetKey];
        if (!preset) return;

        // Determine form ID
        const formId = prefix === 'tambah' ? 'form_tambah_paket' : 'form_edit_paket_' + prefix.replace('edit_', '');
        const form = document.getElementById(formId);
        const panel = document.getElementById('dragable_theme_' + prefix);

        // Set nama_tema
        const namaInput = panel ? panel.querySelector('[name="nama_tema"]') : (form ? form.querySelector('[name="nama_tema"]') : null);
        if (namaInput) namaInput.value = preset.nama;

        // Set color inputs (both text and color picker)
        const colorFields = ['warna_bg', 'warna_font', 'warna_border', 'warna_button'];
        const presetValues = [preset.bg, preset.font, preset.border, preset.button];
        colorFields.forEach((field, i) => {
            const textEl = document.getElementById(prefix + '_' + field);
            if (textEl) textEl.value = presetValues[i];
            // Also sync the color picker (sibling input[type=color])
            if (textEl && textEl.parentNode) {
                const colorPicker = textEl.parentNode.querySelector('input[type="color"]');
                if (colorPicker) colorPicker.value = presetValues[i];
            }
        });

        // Set font family select
        const fontSelect = panel ? panel.querySelector('[name="font_family"]') : (form ? form.querySelector('[name="font_family"]') : null);
        if (fontSelect) fontSelect.value = preset.fontFamily;
    }

    function selectBadge(prefix, badgeText) {
        const input = document.getElementById('badge_text_' + prefix);
        if (input) input.value = badgeText;
    }

    function addPointField(prefix) {
        const container = document.getElementById('points_container_' + prefix);
        if (!container) return;
        
        const formId = prefix === 'tambah' ? 'form_tambah_paket' : 'form_edit_paket_' + prefix.replace('edit_', '');

        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <input type="text" form="${formId}" name="point_keunggulan[]" class="input input-bordered input-sm flex-1" placeholder="Masukkan keunggulan..." required />
            <button type="button" class="btn btn-sm btn-error btn-circle text-white" onclick="removePointField(this)">×</button>
        `;
        container.appendChild(div);
    }

    function removePointField(btn) {
        btn.parentNode.remove();
    }

    // Modal close helpers
    function closeTambahPaketModal() {
        document.getElementById('modal_tambah_paket').close();
        document.getElementById('dragable_theme_tambah')?.classList.add('hidden');
    }

    function closeEditPaketModal(id) {
        document.getElementById('modal_edit_' + id).close();
        document.getElementById('dragable_theme_edit_' + id)?.classList.add('hidden');
    }

    // Auto-fill announcement script
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
</script>
