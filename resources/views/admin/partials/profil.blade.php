<!-- Profil Admin Partial -->
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

    <!-- Profile Header Card -->
    <div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
        <div class="card-body flex-col md:flex-row items-center gap-8">
            <div class="relative group">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-32 ring ring-primary ring-offset-base-100 ring-offset-4">
                        @if($adminProfile && $adminProfile->avatar_path)
                            <img src="{{ $adminProfile->avatar_path }}" alt="Avatar" class="rounded-full w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-bold">{{ $adminProfile->initials ?? 'AR' }}</span>
                        @endif
                    </div>
                </div>
                <label for="avatar-upload-trigger" class="btn btn-primary btn-circle btn-sm absolute bottom-0 right-0 shadow-lg cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </label>
                <!-- Hidden avatar upload form -->
                <form id="avatar-upload-form" action="{{ route('admin.profil.avatar') }}" method="POST" enctype="multipart/form-data" style="display:none;">
                    @csrf
                    <input type="file" id="avatar-upload-trigger" name="avatar" accept="image/*" onchange="document.getElementById('avatar-upload-form').submit();">
                </form>
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold text-base-content">{{ $adminProfile->nama_lengkap ?? 'Admin R-NET' }}</h2>
                <p class="text-primary font-medium">{{ $adminProfile->role ?? 'Administrator' }}</p>
                <p class="text-base-content/50 text-sm mt-2">
                    Terakhir login: {{ $adminProfile && $adminProfile->last_login_at ? $adminProfile->last_login_at->format('d F Y, H:i') . ' WIB' : 'Belum tercatat' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Account Info -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Informasi Akun -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg border-b border-base-200 pb-3 mb-4">Informasi Akun</h3>
                    <form id="profil-info-form" action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Nama Lengkap</span></label>
                                <input type="text" name="nama_lengkap" id="profil-fullName" class="input input-bordered w-full @error('nama_lengkap') input-error @enderror" value="{{ old('nama_lengkap', $adminProfile->nama_lengkap ?? '') }}" required>
                                @error('nama_lengkap')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Username</span></label>
                                <input type="text" class="input input-bordered w-full bg-base-200" value="{{ $adminProfile->username ?? '' }}" disabled title="Username tidak dapat diubah">
                                <span class="text-xs text-base-content/40 mt-1">Username tidak dapat diubah</span>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Email</span></label>
                                <input type="email" name="email" id="profil-email" class="input input-bordered w-full @error('email') input-error @enderror" value="{{ old('email', $adminProfile->email ?? '') }}" required>
                                @error('email')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Nomor Telepon</span></label>
                                <input type="tel" name="phone" id="profil-phone" class="input input-bordered w-full @error('phone') input-error @enderror" value="{{ old('phone', $adminProfile->phone ?? '') }}" placeholder="08xxxxxxxxxx">
                                @error('phone')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control md:col-span-2">
                                <label class="label"><span class="label-text font-medium">Alamat</span></label>
                                <textarea name="alamat" id="profil-address" class="textarea textarea-bordered w-full @error('alamat') textarea-error @enderror" rows="3" placeholder="Masukkan alamat lengkap...">{{ old('alamat', $adminProfile->alamat ?? '') }}</textarea>
                                @error('alamat')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="profilResetForm('info')" class="btn btn-ghost">Batal</button>
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Keamanan (Kata Sandi) -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg border-b border-base-200 pb-3 mb-4">Keamanan (Kata Sandi)</h3>
                    <form id="passwordForm" action="{{ route('admin.profil.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4 max-w-md">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kata Sandi Saat Ini</span></label>
                                <input type="password" name="current_password" id="profil-currentPass" class="input input-bordered w-full @error('current_password') input-error @enderror" placeholder="Masukkan kata sandi lama" autocomplete="current-password">
                                @error('current_password')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kata Sandi Baru</span></label>
                                <input type="password" name="new_password" id="profil-newPass" class="input input-bordered w-full @error('new_password') input-error @enderror" placeholder="Min. 8 karakter" autocomplete="new-password">
                                @error('new_password')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Konfirmasi Kata Sandi Baru</span></label>
                                <input type="password" name="new_password_confirmation" id="profil-confirmPass" class="input input-bordered w-full" placeholder="Ulangi kata sandi baru" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="profilResetForm('password')" class="btn btn-ghost">Batal</button>
                            <button type="submit" class="btn btn-warning gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Ubah Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column: Stats/Preferences -->
        <div class="space-y-8">

            <!-- Preferensi Tampilan -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4">Preferensi Tampilan</h3>
                    {{-- Tidak pakai <form> — setiap toggle langsung kirim AJAX individual --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-medium text-base-content">Mode Gelap</span>
                                <p class="text-xs text-base-content/50">Aktifkan tema gelap</p>
                            </div>
                            <input type="checkbox" id="pref-dark_mode" data-pref="dark_mode"
                                class="toggle toggle-primary toggle-sm"
                                {{ ($adminProfile->dark_mode ?? false) ? 'checked' : '' }}
                                onchange="savePreference(this)">
                        </div>
                        <div class="divider my-0"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-medium text-base-content">Notifikasi Email</span>
                                <p class="text-xs text-base-content/50">Terima notifikasi via email</p>
                            </div>
                            <input type="checkbox" id="pref-email_notif" data-pref="email_notif"
                                class="toggle toggle-primary toggle-sm"
                                {{ ($adminProfile->email_notif ?? true) ? 'checked' : '' }}
                                onchange="savePreference(this)">
                        </div>
                        <div class="divider my-0"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-medium text-base-content">Suara Notifikasi</span>
                                <p class="text-xs text-base-content/50">Aktifkan suara notifikasi</p>
                            </div>
                            <input type="checkbox" id="pref-sound_notif" data-pref="sound_notif"
                                class="toggle toggle-primary toggle-sm"
                                {{ ($adminProfile->sound_notif ?? false) ? 'checked' : '' }}
                                onchange="savePreference(this)">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Aktivitas Admin -->
            <div class="card bg-primary text-primary-content shadow-lg">
                <div class="card-body">
                    <h3 class="card-title text-lg">Aktivitas Admin</h3>
                    <div class="space-y-3 mt-2">
                        <div class="flex justify-between text-sm">
                            <span class="opacity-80">Total Pendaftar</span>
                            <span class="font-bold">{{ $totalPendaftaran ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="opacity-80">Paket Tersedia</span>
                            <span class="font-bold">{{ $totalPaket ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="opacity-80">Pengumuman Aktif</span>
                            <span class="font-bold">{{ $totalPengumuman ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-primary-content/20 text-xs opacity-70 text-center">
                        Data diperbarui setiap halaman dimuat
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // ═══════════════════════════════════════════
    // Profil Tab Scripts
    // ═══════════════════════════════════════════

    // ── Simpan satu preferensi langsung via fetch (tanpa reload) ──
    async function savePreference(toggleEl) {
        const key   = toggleEl.dataset.pref;
        const value = toggleEl.checked ? '1' : '0';

        // Ambil semua state toggle sekarang
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                       || document.querySelector('input[name="_token"]')?.value
                       || '';

        const body = new URLSearchParams({
            _token:      csrfToken,
            _method:     'PUT',
            dark_mode:   document.getElementById('pref-dark_mode')?.checked  ? '1' : '0',
            email_notif: document.getElementById('pref-email_notif')?.checked ? '1' : '0',
            sound_notif: document.getElementById('pref-sound_notif')?.checked ? '1' : '0',
        });

        // Optimistik: langsung beri feedback visual
        toggleEl.disabled = true;

        try {
            const res  = await fetch('{{ route("admin.profil.preferences") }}', {
                method:  'POST',
                body:    body,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept':           'application/json',
                    'Content-Type':     'application/x-www-form-urlencoded',
                }
            });
            const json = await res.json();
            if (json.success) {
                spaToast(json.message || 'Preferensi disimpan.', 'success');
            } else {
                // Kembalikan state toggle jika gagal
                toggleEl.checked = !toggleEl.checked;
                spaToast(json.message || 'Gagal menyimpan preferensi.', 'error');
            }
        } catch (err) {
            toggleEl.checked = !toggleEl.checked;
            spaToast('Koneksi bermasalah. Coba lagi.', 'error');
        } finally {
            toggleEl.disabled = false;
        }
    }

    const _profilDefaults = {
        nama_lengkap: @json($adminProfile->nama_lengkap ?? ''),
        email: @json($adminProfile->email ?? ''),
        phone: @json($adminProfile->phone ?? ''),
        alamat: @json($adminProfile->alamat ?? ''),
    };

    function profilResetForm(target) {
        if (target === 'info') {
            const el = (id) => document.getElementById(id);
            if (el('profil-fullName'))  el('profil-fullName').value  = _profilDefaults.nama_lengkap;
            if (el('profil-email'))     el('profil-email').value     = _profilDefaults.email;
            if (el('profil-phone'))     el('profil-phone').value     = _profilDefaults.phone;
            if (el('profil-address'))   el('profil-address').value   = _profilDefaults.alamat;
            spaToast('Form informasi akun telah direset.', 'info');
        } else if (target === 'password') {
            ['profil-currentPass', 'profil-newPass', 'profil-confirmPass'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            spaToast('Form kata sandi telah dikosongkan.', 'info');
        }
    }

    // Avatar upload via AJAX — preview langsung tanpa reload
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar-upload-trigger');
        if (!avatarInput) return;
        avatarInput.addEventListener('change', async function() {
            const file = this.files[0];
            if (!file) return;
            // Preview lokal dulu
            const reader = new FileReader();
            reader.onload = e => {
                const avatarEl = document.querySelector('#panel-profil .avatar div');
                if (avatarEl) avatarEl.innerHTML = `<img src="${e.target.result}" class="rounded-full w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
            // Upload ke server
            const form = document.getElementById('avatar-upload-form');
            const formData = new FormData(form);
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const json = await res.json();
                spaToast(json.message || (json.success ? 'Avatar diperbarui.' : 'Gagal upload.'), json.success ? 'success' : 'error');
            } catch (err) {
                spaToast('Gagal mengupload avatar.', 'error');
            }
        });
    });
</script>
