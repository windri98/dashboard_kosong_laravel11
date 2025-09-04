<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function showrole()
    {
        $roles = Roles::with('users')->get();
        return view('dashboard.main.role.roles', compact('roles'));
    }

    /**
     * Store a newly created role in storage.
     */

    public function addrole(){

    return view('dashboard.main.role.create');
    }

    public function createrole(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles',
            'permissions' => 'array',
        ]);

        // Inisialisasi array permission kosong
        $permissions = [];
        
        // Proses permissions sebagai array aksi per modul
        if ($request->has('permissions')) {
            foreach ($request->permissions as $module => $actions) {
                // Simpan actions array untuk setiap modul
                if (!empty($actions)) {
                    $permissions[$module] = $actions;
                }
            }
        }
        
        Roles::create([
            'role' => $request->role,
            'akses' => json_encode($permissions),
        ]);

        return redirect()->route('show.role')->with('success', 'Role berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified role.
     */
        public function editrole($id)
    {
        $role = Roles::findOrFail($id);

        // Cek jika role adalah 'SuperAdmin', redirect dengan pesan error
        if (strtolower($role->role) === 'superadmin') {
            return redirect()->route('show.role')->with('error', 'Role Super Admin tidak dapat diedit!');
        }

        $role->akses = json_decode($role->akses, true); // Konversi JSON ke array
        
        $permissionModules = [
            'manage-roles.role' => 'Manajemen Role & User',
            'change-password' => 'Ubah Password',
            'manage-bukti-jackpot.buktijackpot' => 'Manajemen Bukti Jackpot',
            'manage-priority.priority' => 'Manajemen Prioritas',
            'manage-social-media.socialmedia' => 'Manajemen Social Media',
            'manage-website.website' => 'Manajemen Website',
            'manage-game.game' => 'Manajemen Game',
            'manage-kategori-game.kategorigame' => 'Manajemen Kategori Game',
            'manage-link-website.linkwebsite' => 'Manajemen Link Website'
        ];
        
        return view('dashboard.main.role.edit', [
            'role' => $role,
            'permissionModules' => $permissionModules,
        ]);
    }


    /**
     * Update the specified role in storage.
     */
        public function updaterole(Request $request, $id)
    {
        $role = Roles::findOrFail($id);

        // Cegah update SuperAdmin
        if (strtolower($role->role) === 'superadmin') {
            return redirect()->route('show.role')->with('error', 'Role Super Admin tidak dapat diedit!');
        }

        $request->validate([
            'role' => 'required|unique:roles,role,' . $id,
        ]);
        
        $permissions = [];
        if ($request->has('permissions')) {
            foreach ($request->permissions as $module => $actions) {
                if (!empty($actions)) {
                    $permissions[$module] = $actions;
                }
            }
        }
        
        $role->update([
            'role' => $request->role,
            'akses' => json_encode($permissions),
        ]);
        
        return redirect()->route('show.role')->with('success', 'Role berhasil diperbarui!');
    }


    /**
     * Remove the specified role from storage.
     */
        public function deleterole($id)
    {
        $role = Roles::find($id);
        if (!$role) {
            return redirect()->route('show.role')->with('error', 'Role tidak ditemukan!');
        }

        // Cegah hapus SuperAdmin
        if (strtolower($role->role) === 'superadmin') {
            return redirect()->route('show.role')->with('error', 'Role Super Admin tidak dapat dihapus!');
        }

        $role->delete();
        return redirect()->route('show.role')->with('success', 'Role berhasil dihapus!');
    }

}
