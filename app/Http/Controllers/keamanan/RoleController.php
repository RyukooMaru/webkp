<?php

namespace App\Http\Controllers\Keamanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get(); // Menampilkan semua roles dengan jumlah pengguna
        return view('keamanan.role.index', compact('roles'));
    }

    public function create()
    {
        return view('keamanan.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        // Menambahkan role baru
        Role::create(['name' => $request->name]);

        // Redirect dengan pesan sukses
        return redirect()->route('keamanan.role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('keamanan.role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        // Validasi nama role
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        // Update nama role
        $role->name = $request->input('name');
        $role->save();

        // Redirect dengan pesan sukses
        return redirect()->route('keamanan.role.index')->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy(Role $role)
    {
        // Hapus role
        $role->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('keamanan.role.index')->with('success', 'Role berhasil dihapus!');
    }
}
