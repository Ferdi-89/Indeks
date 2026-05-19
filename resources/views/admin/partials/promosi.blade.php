<!-- Promosi Partial -->
<div class="mb-8">
    <h3 class="text-2xl font-bold text-base-content">Promosi</h3>
    <p class="text-sm text-base-content/70 mt-1">Kelola promosi dan penawaran spesial</p>
</div>

<!-- Create Form -->
<div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
    <div class="card-body">
        <h4 class="card-title text-lg mb-4">Buat Promosi Baru</h4>
        <form action="{{ route('admin.promosi.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">ID Promosi</span></label>
                    <input type="text" name="id_promosi" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100 transition-colors" placeholder="Contoh: PROM-01" required />
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Tema</span></label>
                    <input type="text" name="tema" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100 transition-colors" placeholder="Contoh: Ramadhan" required />
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Diskon (%)</span></label>
                    <input type="number" name="value_promosi" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100 transition-colors" placeholder="30" required />
                </div>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text font-medium">Deskripsi Promosi</span></label>
                <textarea name="text_promosi" class="textarea textarea-bordered h-24 w-full bg-base-50/50 focus:bg-base-100 transition-colors" placeholder="Masukkan isi promosi..." required></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Tanggal Mulai</span></label>
                    <input type="date" name="valid_start" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100 transition-colors" required />
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Tanggal Berakhir</span></label>
                    <input type="date" name="valid_end" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100 transition-colors" required />
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn btn-primary px-8">Publikasikan</button>
            </div>
        </form>
    </div>
</div>

<!-- Promotions Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($promosi as $item)
    @php
        $isCurrentlyActive = now()->between($item->valid_start, $item->valid_end);
        $gradientClass = $loop->index % 2 === 0 ? 'from-blue-600 to-indigo-700' : 'from-purple-600 to-pink-700';
    @endphp
    <div class="card bg-gradient-to-br {{ $gradientClass }} text-white shadow-xl relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

        <div class="card-body relative z-10">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold">{{ $item->tema }}</h3>
                </div>
                <span class="badge badge-sm {{ $isCurrentlyActive ? 'badge-success' : 'badge-ghost bg-white/20' }} border-none font-bold">
                    {{ $isCurrentlyActive ? 'Aktif' : 'Off' }}
                </span>
            </div>

            <div class="mb-4">
                <span class="text-4xl font-extrabold">{{ $item->value_promosi }}%</span>
                <span class="text-lg font-medium opacity-80 uppercase ml-1">OFF</span>
            </div>

            <p class="text-sm opacity-90 mb-6 min-h-[60px] line-clamp-3">{{ $item->text_promosi }}</p>

            <div class="flex items-center gap-2 text-xs opacity-80 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>{{ date('d M', strtotime($item->valid_start)) }} - {{ date('d M Y', strtotime($item->valid_end)) }}</span>
            </div>

            <div class="flex gap-2 pt-4 border-t border-white/20">
                <button onclick="document.getElementById('modal_edit_promo_{{ $item->id_promosi }}').showModal()" class="flex-1 btn btn-sm bg-white/20 hover:bg-white/30 border-none text-white normal-case">
                    Edit
                </button>
                <button onclick="document.getElementById('modal_hapus_promo_{{ $item->id_promosi }}').showModal()" class="flex-1 btn btn-sm btn-error bg-red-500/80 hover:bg-red-500 border-none text-white normal-case">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <dialog id="modal_edit_promo_{{ $item->id_promosi }}" class="modal">
      <div class="modal-box w-11/12 max-w-3xl">
        <h3 class="font-bold text-lg mb-4 text-base-content">Edit Promosi: {{ $item->id_promosi }}</h3>
        <form action="{{ route('admin.promosi.update', $item->id_promosi) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control w-full text-base-content">
                    <label class="label"><span class="label-text font-medium">Tema</span></label>
                    <input type="text" name="tema" value="{{ $item->tema }}" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100" required />
                </div>
                <div class="form-control w-full text-base-content">
                    <label class="label"><span class="label-text font-medium">Diskon (%)</span></label>
                    <input type="number" name="value_promosi" value="{{ $item->value_promosi }}" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100" required />
                </div>
            </div>

            <div class="form-control w-full text-base-content">
                <label class="label"><span class="label-text font-medium">Deskripsi Promosi</span></label>
                <textarea name="text_promosi" class="textarea textarea-bordered h-24 w-full bg-base-50/50 focus:bg-base-100" required>{{ $item->text_promosi }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-base-content">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Tanggal Mulai</span></label>
                    <input type="date" name="valid_start" value="{{ $item->valid_start }}" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100" required />
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Tanggal Berakhir</span></label>
                    <input type="date" name="valid_end" value="{{ $item->valid_end }}" class="input input-bordered w-full bg-base-50/50 focus:bg-base-100" required />
                </div>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn" onclick="document.getElementById('modal_edit_promo_{{ $item->id_promosi }}').close()">Batal</button>
                <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
            </div>
        </form>
      </div>
      <form method="dialog" class="modal-backdrop">
        <button>close</button>
      </form>
    </dialog>

    <!-- Modal Hapus -->
    <dialog id="modal_hapus_promo_{{ $item->id_promosi }}" class="modal">
      <div class="modal-box text-center">
        <div class="text-error mb-4 flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3 class="font-bold text-lg text-base-content">Hapus Promosi?</h3>
        <p class="py-4 text-base-content/70">Yakin ingin menghapus promosi <strong>{{ $item->tema }}</strong> ({{ $item->id_promosi }})?</p>
        <div class="modal-action justify-center">
          <form method="dialog">
            <button class="btn mr-2">Batal</button>
          </form>
          <form action="{{ route('admin.promosi.destroy', $item->id_promosi) }}" method="POST">
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
    @empty
    <div class="col-span-full py-16 text-center text-base-content/50 bg-base-100 rounded-2xl border border-dashed border-base-300">
        <div class="flex justify-center mb-4">
            <div class="p-4 bg-base-200 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"/></svg>
            </div>
        </div>
        <p class="text-lg font-semibold text-base-content/70">Belum Ada Promosi Aktif</p>
        <p class="text-sm mt-1">Buat penawaran spesial pertama Anda melalui formulir di atas.</p>
    </div>
    @endforelse
</div>
