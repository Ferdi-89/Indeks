<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * [FITUR] Menyimpan akun pengguna baru ke database dan membuat profil admin otomatis jika rolenya admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,teknisi,pengguna'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        if ($validated['role'] === 'admin') {
            AdminProfile::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'username' => 'admin_' . $user->id,
                'email' => $user->email,
                'role' => 'Administrator',
            ]);
        }

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * [FITUR] Memperbarui detail informasi akun pengguna tertentu dan menyelaraskan profil adminnya jika relevan.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,teknisi,pengguna',
            'password' => 'nullable|string|min:6'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        if ($user->role === 'admin') {
            $profil = AdminProfile::where('user_id', $user->id)->first();
            if ($profil) {
                $profil->update([
                    'nama_lengkap' => $user->name,
                    'email' => $user->email,
                ]);
            } else {
                AdminProfile::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->name,
                    'username' => 'admin_' . $user->id,
                    'email' => $user->email,
                    'role' => 'Administrator',
                ]);
            }
        }

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    /**
     * [FITUR] Menghapus akun pengguna tertentu dari database.
     */
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
