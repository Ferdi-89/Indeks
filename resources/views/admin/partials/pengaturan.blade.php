<!-- Pengaturan Perusahaan Partial -->
<div class="max-w-5xl mx-auto">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="alert alert-success mb-6 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error mb-6 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-bold text-base-content">Pengaturan Perusahaan</h3>
            <p class="text-sm text-base-content/70 mt-1">Kelola informasi dan konfigurasi perusahaan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Informasi Perusahaan -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg border-b border-base-200 pb-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                        Informasi Perusahaan
                    </h3>
                    <form action="{{ route('admin.pengaturan.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_section" value="company">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control md:col-span-2">
                                <label class="label"><span class="label-text font-medium">Nama Perusahaan</span></label>
                                <input type="text" name="nama_perusahaan" class="input input-bordered w-full @error('nama_perusahaan') input-error @enderror" value="{{ old('nama_perusahaan', $company->nama_perusahaan ?? '') }}" required>
                                @error('nama_perusahaan')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Email Perusahaan</span></label>
                                <input type="email" name="email_perusahaan" class="input input-bordered w-full @error('email_perusahaan') input-error @enderror" value="{{ old('email_perusahaan', $company->email_perusahaan ?? '') }}" placeholder="info@rnet.id">
                                @error('email_perusahaan')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Telepon Perusahaan</span></label>
                                <input type="tel" name="telepon_perusahaan" class="input input-bordered w-full" value="{{ old('telepon_perusahaan', $company->telepon_perusahaan ?? '') }}" placeholder="(021) xxxxxxx">
                            </div>
                            <div class="form-control md:col-span-2">
                                <label class="label"><span class="label-text font-medium">Alamat Perusahaan</span></label>
                                <textarea name="alamat_perusahaan" class="textarea textarea-bordered w-full" rows="3" placeholder="Jl. ...">{{ old('alamat_perusahaan', $company->alamat_perusahaan ?? '') }}</textarea>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Website</span></label>
                                <input type="url" name="website" class="input input-bordered w-full" value="{{ old('website', $company->website ?? '') }}" placeholder="https://rnet.id">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">NPWP</span></label>
                                <input type="text" name="npwp" class="input input-bordered w-full" value="{{ old('npwp', $company->npwp ?? '') }}" placeholder="00.000.000.0-000.000">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Media Sosial -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg border-b border-base-200 pb-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        Media Sosial
                    </h3>
                    <form action="{{ route('admin.pengaturan.social') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Facebook</span></label>
                                <label class="input input-bordered flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                    <input type="text" name="facebook" class="grow" value="{{ old('facebook', $company->facebook ?? '') }}" placeholder="https://facebook.com/rnet">
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Instagram</span></label>
                                <label class="input input-bordered flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                    <input type="text" name="instagram" class="grow" value="{{ old('instagram', $company->instagram ?? '') }}" placeholder="@rnet.id">
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">WhatsApp</span></label>
                                <label class="input input-bordered flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <input type="text" name="whatsapp" class="grow" value="{{ old('whatsapp', $company->whatsapp ?? '') }}" placeholder="628xxxxxxxxxx">
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Simpan Media Sosial
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Jam Operasional -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg border-b border-base-200 pb-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Jam Operasional
                    </h3>
                    <form action="{{ route('admin.pengaturan.hours') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam Buka</th>
                                        <th>Jam Tutup</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-medium">Senin – Jumat</td>
                                        <td><input type="time" name="jam_buka_weekday" class="input input-bordered input-sm w-32" value="{{ $company->jam_buka_weekday ? \Carbon\Carbon::parse($company->jam_buka_weekday)->format('H:i') : '08:00' }}"></td>
                                        <td><input type="time" name="jam_tutup_weekday" class="input input-bordered input-sm w-32" value="{{ $company->jam_tutup_weekday ? \Carbon\Carbon::parse($company->jam_tutup_weekday)->format('H:i') : '17:00' }}"></td>
                                        <td><span class="badge badge-success badge-sm">Buka</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Sabtu</td>
                                        <td><input type="time" name="jam_buka_sabtu" class="input input-bordered input-sm w-32" value="{{ $company->jam_buka_sabtu ? \Carbon\Carbon::parse($company->jam_buka_sabtu)->format('H:i') : '08:00' }}"></td>
                                        <td><input type="time" name="jam_tutup_sabtu" class="input input-bordered input-sm w-32" value="{{ $company->jam_tutup_sabtu ? \Carbon\Carbon::parse($company->jam_tutup_sabtu)->format('H:i') : '12:00' }}"></td>
                                        <td><span class="badge badge-warning badge-sm">Setengah Hari</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Minggu</td>
                                        <td colspan="2">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" name="buka_minggu" value="1" class="checkbox checkbox-primary checkbox-sm" id="buka-minggu-toggle" {{ ($company->buka_minggu ?? false) ? 'checked' : '' }}>
                                                <span class="text-sm">Buka pada hari Minggu</span>
                                            </label>
                                        </td>
                                        <td><span class="badge {{ ($company->buka_minggu ?? false) ? 'badge-success' : 'badge-error' }} badge-sm">{{ ($company->buka_minggu ?? false) ? 'Buka' : 'Tutup' }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Simpan Jam Operasional
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="space-y-8">

            <!-- Logo Perusahaan -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body items-center text-center">
                    <h3 class="card-title text-lg mb-4">Logo Perusahaan</h3>
                    <div class="mb-4">
                        @if($company->logo_path)
                            <div class="rounded-2xl w-32 h-32 overflow-hidden border border-base-200 mx-auto">
                                <img src="{{ $company->logo_path }}" alt="Logo Perusahaan" class="w-full h-full object-contain p-2">
                            </div>
                        @else
                            <div class="bg-primary/10 text-primary rounded-2xl w-32 h-32 flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
                            </div>
                        @endif
                    </div>
                    <p class="text-sm text-base-content/50 mb-4">Format: PNG, JPG. Maks 2MB</p>
                    <form action="{{ route('admin.pengaturan.logo') }}" method="POST" enctype="multipart/form-data" id="logo-upload-form">
                        @csrf
                        <input type="file" name="logo" id="logo-file-input" accept="image/png,image/jpeg,image/jpg" class="hidden" onchange="document.getElementById('logo-upload-form').submit()">
                        <button type="button" onclick="document.getElementById('logo-file-input').click()" class="btn btn-outline btn-primary btn-sm w-full gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            Upload Logo
                        </button>
                    </form>
                    @if($company->logo_path)
                    <form action="{{ route('admin.pengaturan.logo.delete') }}" method="POST" class="mt-2 w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm text-error w-full" onclick="return confirm('Hapus logo perusahaan?')">Hapus Logo</button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Area Layanan -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-2">Area Layanan</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @forelse($areaLayanan as $area)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-2">
                                <span class="badge badge-primary badge-sm">●</span>
                                <span class="text-sm">{{ $area->nama_area }}</span>
                            </div>
                            <form action="{{ route('admin.area.destroy', $area->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-xs text-error" onclick="return confirm('Hapus area {{ $area->nama_area }}?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                        @empty
                        <p class="text-sm text-base-content/50 italic">Belum ada area layanan.</p>
                        @endforelse
                    </div>
                    <button class="btn btn-outline btn-sm mt-4 gap-1 w-full" onclick="document.getElementById('modal_tambah_area').showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Area
                    </button>
                </div>
            </div>

            <!-- Info Sistem -->
            <div class="card bg-neutral text-neutral-content shadow-lg">
                <div class="card-body">
                    <h3 class="card-title text-lg">Info Sistem</h3>
                    <div class="space-y-3 mt-2">
                        <div class="flex justify-between text-sm">
                            <span class="opacity-70">Versi Aplikasi</span>
                            <span class="font-bold">v2.1.0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="opacity-70">Framework</span>
                            <span class="font-bold">Laravel {{ app()->version() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="opacity-70">Database</span>
                            <span class="font-bold">Supabase</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="opacity-70">Terakhir Update</span>
                            <span class="font-bold">{{ $company->updated_at ? $company->updated_at->format('d M Y') : now()->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Area Layanan -->
<dialog id="modal_tambah_area" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Tambah Area Layanan</h3>
        <form action="{{ route('admin.area.store') }}" method="POST">
            @csrf
            <div class="form-control">
                <label class="label"><span class="label-text font-medium">Nama Area / Kelurahan / Kecamatan</span></label>
                <input type="text" name="nama_area" class="input input-bordered w-full" placeholder="cth: Kel. Cikaret, Kec. Bogor Selatan" required autofocus>
            </div>
            <div class="modal-action">
                <form method="dialog"><button class="btn btn-ghost">Batal</button></form>
                <button type="submit" class="btn btn-primary">Tambah Area</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

{{-- Toast dari sesi (fallback non-AJAX) ditangani oleh spaToast global --}}

