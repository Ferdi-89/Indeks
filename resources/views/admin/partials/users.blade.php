<!-- Users Management Partial -->
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
            <h3 class="text-2xl font-bold text-base-content">Manajemen Pengguna</h3>
            <p class="text-sm text-base-content/70 mt-1">Kelola data akun pengguna, teknisi, dan admin sistem</p>
        </div>
        <button onclick="document.getElementById('modal_add_user').showModal()" class="btn btn-primary gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
            Tambah Pengguna
        </button>
    </div>

    <!-- Table Card -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="font-bold">{{ $user->name }}</div>
                            @if(Auth::id() === $user->id)
                            <span class="badge badge-primary badge-xs">Anda</span>
                            @endif
                        </td>
                        <td class="font-mono text-sm">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-error text-white text-xs font-semibold py-1.5 px-2.5">Admin</span>
                            @elseif($user->role === 'teknisi')
                                <span class="badge badge-accent text-white text-xs font-semibold py-1.5 px-2.5">Teknisi</span>
                            @else
                                <span class="badge badge-ghost text-xs font-semibold py-1.5 px-2.5">Pengguna</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                        <td class="flex justify-center gap-2">
                            <button 
                                onclick="openEditUserModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" 
                                class="btn btn-sm btn-ghost text-info btn-square"
                                title="Edit Pengguna">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            </button>
                            
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-ghost text-error btn-square" title="Hapus Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                            @else
                            <div class="w-8"></div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah User -->
<dialog id="modal_add_user" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-6">Tambah Pengguna Baru</h3>
        
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                <input type="text" name="name" class="input input-bordered w-full" placeholder="Nama Lengkap" required />
            </div>
            
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Alamat Email</span></label>
                <input type="email" name="email" class="input input-bordered w-full" placeholder="name@email.com" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Password</span></label>
                <input type="password" name="password" class="input input-bordered w-full" placeholder="Min. 6 karakter" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Role Pengguna</span></label>
                <select name="role" class="select select-bordered w-full" required>
                    <option value="pengguna">Pengguna (Customer)</option>
                    <option value="teknisi">Teknisi (Field Engineer)</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary w-full">Tambah Pengguna</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal: Edit User -->
<dialog id="modal_edit_user" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-6">Edit Data Pengguna</h3>
        
        <form id="form_edit_user" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                <input type="text" name="name" id="edit_user_name" class="input input-bordered w-full" required />
            </div>
            
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Alamat Email</span></label>
                <input type="email" name="email" id="edit_user_email" class="input input-bordered w-full" required />
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Password (Kosongkan jika tidak ingin diubah)</span>
                </label>
                <input type="password" name="password" class="input input-bordered w-full" placeholder="Password baru" />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Role Pengguna</span></label>
                <select name="role" id="edit_user_role" class="select select-bordered w-full" required>
                    <option value="pengguna">Pengguna (Customer)</option>
                    <option value="teknisi">Teknisi (Field Engineer)</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary w-full">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openEditUserModal(id, name, email, role) {
        // Set action form dinamis
        const form = document.getElementById('form_edit_user');
        form.action = `/admin/users/${id}`;
        
        // Isi input field
        document.getElementById('edit_user_name').value = name;
        document.getElementById('edit_user_email').value = email;
        document.getElementById('edit_user_role').value = role;
        
        // Tampilkan modal
        document.getElementById('modal_edit_user').showModal();
    }
</script>
