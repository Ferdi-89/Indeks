<!-- Profil Admin Partial -->
<div class="max-w-5xl mx-auto">

    <!-- Profile Header Card -->
    <div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
        <div class="card-body flex-col md:flex-row items-center gap-8">
            <div class="relative group">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-32 ring ring-primary ring-offset-base-100 ring-offset-4">
                        <span class="text-4xl font-bold">{{ $adminProfile->initials ?? 'AR' }}</span>
                    </div>
                </div>
                <button class="btn btn-primary btn-circle btn-sm absolute bottom-0 right-0 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </button>
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold text-base-content">{{ $adminProfile->nama_lengkap ?? 'Admin R-NET' }}</h2>
                <p class="text-primary font-medium">{{ $adminProfile->role ?? 'Administrator' }}</p>
                <p class="text-base-content/50 text-sm mt-2">
                    Terakhir login: {{ $adminProfile->last_login_at ? $adminProfile->last_login_at->format('d F Y, H:i') . ' WIB' : 'Belum tercatat' }}
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
                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Nama Lengkap</span></label>
                                <input type="text" name="nama_lengkap" class="input input-bordered w-full" value="{{ $adminProfile->nama_lengkap ?? '' }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Username</span></label>
                                <input type="text" class="input input-bordered w-full bg-base-200" value="{{ $adminProfile->username ?? '' }}" disabled>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Email</span></label>
                                <input type="email" name="email" class="input input-bordered w-full" value="{{ $adminProfile->email ?? '' }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Nomor Telepon</span></label>
                                <input type="tel" name="phone" class="input input-bordered w-full" value="{{ $adminProfile->phone ?? '' }}">
                            </div>
                            <div class="form-control md:col-span-2">
                                <label class="label"><span class="label-text font-medium">Alamat</span></label>
                                <textarea name="alamat" class="textarea textarea-bordered w-full" rows="3">{{ $adminProfile->alamat ?? '' }}</textarea>
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

            <!-- Keamanan (Kata Sandi) -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg border-b border-base-200 pb-3 mb-4">Keamanan (Kata Sandi)</h3>
                    <form id="passwordForm" onsubmit="event.preventDefault(); profilSaveSettings('password');">
                        <div class="space-y-4 max-w-md">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kata Sandi Saat Ini</span></label>
                                <input type="password" id="profil-currentPass" class="input input-bordered w-full" placeholder="Masukkan kata sandi lama">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kata Sandi Baru</span></label>
                                <input type="password" id="profil-newPass" class="input input-bordered w-full" placeholder="Masukkan kata sandi baru">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Konfirmasi Kata Sandi Baru</span></label>
                                <input type="password" id="profil-confirmPass" class="input input-bordered w-full" placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" onclick="profilResetForm('password')" class="btn btn-ghost">Batal</button>
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
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
                    <h3 class="card-title text-lg mb-2">Preferensi Tampilan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-base-content/70">Mode Gelap</span>
                            <input type="checkbox" class="toggle toggle-primary toggle-sm" {{ ($adminProfile->dark_mode ?? false) ? 'checked' : '' }} />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-base-content/70">Notifikasi Email</span>
                            <input type="checkbox" class="toggle toggle-primary toggle-sm" {{ ($adminProfile->email_notif ?? true) ? 'checked' : '' }} />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-base-content/70">Suara Notifikasi</span>
                            <input type="checkbox" class="toggle toggle-primary toggle-sm" {{ ($adminProfile->sound_notif ?? false) ? 'checked' : '' }} />
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
                            <span class="opacity-80">Pelanggan Diaktifkan</span>
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
                    <div class="mt-4 pt-4 border-t border-primary-content/20">
                        <button class="btn btn-ghost btn-sm w-full bg-primary-content/20 hover:bg-primary-content/30 text-primary-content">Lihat Riwayat Lengkap</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Konfirmasi Simpan Profil -->
<dialog id="modal_profil_save" class="modal">
    <div class="modal-box text-center">
        <div class="text-success mb-4 flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 class="font-bold text-lg">Konfirmasi Simpan</h3>
        <p class="py-4 text-base-content/70">Apakah Anda yakin ingin menyimpan perubahan ini?</p>
        <div class="modal-action justify-center">
            <form method="dialog">
                <button class="btn mr-2">Batal</button>
            </form>
            <button onclick="profilConfirmSave()" class="btn btn-primary">Ya, Simpan</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
    // ═══════════════════════════════════════════
    // Profil Tab Scripts
    // ═══════════════════════════════════════════
    let profilCurrentSaveTarget = '';

    function profilSaveSettings(target) {
        profilCurrentSaveTarget = target;
        document.getElementById('modal_profil_save').showModal();
    }

    function profilResetForm(target) {
        if (target === 'info') {
            document.getElementById('profil-fullName').value = @json($adminProfile->nama_lengkap ?? '');
            document.getElementById('profil-email').value = @json($adminProfile->email ?? '');
            document.getElementById('profil-phone').value = @json($adminProfile->phone ?? '');
            document.getElementById('profil-address').value = @json($adminProfile->alamat ?? '');
        } else if (target === 'password') {
            document.getElementById('profil-currentPass').value = '';
            document.getElementById('profil-newPass').value = '';
            document.getElementById('profil-confirmPass').value = '';
        }
        profilShowToast('Form telah direset.');
    }

    function profilConfirmSave() {
        document.getElementById('modal_profil_save').close();
        let msg = '';
        if (profilCurrentSaveTarget === 'info') msg = 'Informasi akun berhasil diperbarui.';
        else if (profilCurrentSaveTarget === 'password') msg = 'Kata sandi berhasil diubah.';
        profilShowToast(msg);
    }

    function profilShowToast(message) {
        const existing = document.getElementById('profil-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.id = 'profil-toast';
        toast.className = 'toast toast-end toast-bottom z-50';
        toast.innerHTML = `
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div>
                    <span class="font-bold">Berhasil!</span>
                    <span class="text-sm">${message}</span>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
</script>
