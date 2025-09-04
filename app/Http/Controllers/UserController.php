<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    
    /**
     * MANAJEMEN USER
     */

    /**
     * Menampilkan daftar user
     *
     * @return \Illuminate\View\View
     */
    public function showuser()
    {
        $users = User::with('roles')->get();

        return view('dashboard.main.user.user', compact('users'));
    }


    public function adduser(){
    

        return view('dashboard.main.user.create');
    }

    public function createuser(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_card' => 'required|string|max:250|unique:users,id_card',
            'jabatan' => 'required|string|max:250',
            'nama' => 'required|string|max:250',
            'username' => 'required|string|max:250|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Cari role default
        $defaultRole = Roles::where('role', 'user')->first();

        if (!$defaultRole) {
            return Redirect::back()->with('error', 'Default role "user" is not defined. Please contact the administrator.');
        }

        // Buat user baru
        $user = User::create([
            'id_card' => $request->id_card,
            'jabatan' => $request->jabatan,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $defaultRole->id,
        ]);

        return redirect()->route('show.user')
            ->withSuccess('Akun Telah Terdaftar!');
    }

    /**
     * Menampilkan form edit user
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edituser($id)
    {
        $roles = Roles::all();

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('show.user')->with('error', 'Data tidak ditemukan!');
        }

        return view('dashboard.main.user.edit', compact('user', 'roles'));
    }

    /**
     * Menyimpan perubahan data user
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateuser(Request $request, $id)
    {
        $request->validate([
            'username' => 'nullable|max:250|unique:users,username,' . $id,
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $datauser = User::find($id);

        if (!$datauser) {
            return redirect()->route('show.user')->with('error', 'Data tidak ditemukan!');
        }

        // Update hanya field yang diisi
        if ($request->filled('username')) {
            $datauser->username = $request->username;
        }

        if ($request->filled('role_id')) {
            $datauser->role_id = $request->role_id;
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'nullable|min:8|confirmed',
            ]);
            $datauser->password = Hash::make($request->password);
        }

        $datauser->save();

        return redirect()->route('show.user')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus user
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteuser($id)
    {
        $deletedatauser = User::find($id);

        if (!$deletedatauser) {
            return redirect()->route('show.user')->with('error', 'Data tidak ditemukan!');
        }

        $deletedatauser->delete();

        return redirect()->route('show.user')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * MANAJEMEN PASSWORD
     */

    /**
     * Menampilkan form ubah password
     *
     * @return \Illuminate\View\View
     */
    public function ubahpassword()
    {
        return view('dashboard.main.user.updatepassword', [
            'iconname' => 'Ubah Password',
        ]);
    }

    /**
     * Menyimpan perubahan password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatepassword(Request $request)
    {
        try {
            // Validasi input pengguna
            $request->validate([
                'passlama' => 'required',
                'passbaru' => [
                    'required',
                    'min:8',
                    'different:passlama'
                ],
                'passbaru_confirmation' => 'required|same:passbaru',
            ], [
                'passlama.required' => 'Password Lama wajib diisi.',
                'passbaru.required' => 'Password Baru wajib diisi.',
                'passbaru.min' => 'Password Baru harus minimal 8 karakter.',
                'passbaru.different' => 'Password Baru tidak boleh sama dengan Password Lama.',
                'passbaru_confirmation.required' => 'Konfirmasi Password Baru wajib diisi.',
                'passbaru_confirmation.same' => 'Konfirmasi Password Baru harus sama dengan Password Baru.',
            ]);

            $user = Auth::user();

            // Cek apakah password lama benar
            if (!Hash::check($request->passlama, $user->password)) {
                return redirect()->back()->with('error', 'Kata sandi salah!');
            }

            // Cek apakah password baru sama dengan yang lama
            if (Hash::check($request->passbaru, $user->password)) {
                return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password lama!');
            }

            // Simpan password baru
            $user->password = Hash::make($request->passbaru);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
