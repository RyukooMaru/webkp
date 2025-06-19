<?php

namespace App\Http\Controllers\keamanan;

use App\Http\Controllers\Controller;
use App\Models\keamanan\Role;
use App\Models\keamanan\Menu;
use App\Models\keamanan\RoleMenu; // Penting: Ini model tabel pivot role_menu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    // ... (metode index() atau lainnya untuk menampilkan halaman permission) ...

    public function index()
    {
        $roles = Role::all();
        $menus = Menu::orderBy('order')->get(); // Ambil semua menu

        $selectedRole = request()->query('role_id') ? Role::find(request()->query('role_id')) : null;
        $currentPermissions = collect();
        if ($selectedRole) {
            // Ini akan mengambil ID menu dari role_menu yang sudah ada untuk role ini
            $currentPermissions = $selectedRole->menus->pluck('id'); 
        }

        return view('keamanan.permission.index', compact('roles', 'menus', 'selectedRole', 'currentPermissions'));
    }

    /**
     * Memperbarui akses menu untuk role tertentu.
     * Ini adalah metode yang perlu dimodifikasi.
     */
    public function updateMenuAccess(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'selected_menus' => 'nullable|array', // ID menu yang dicentang di form
            'selected_menus.*' => 'exists:menus,id', // Validasi setiap ID menu
        ]);

        $role = Role::findOrFail($request->role_id);
        $selectedMenuIds = $request->input('selected_menus', []); // ID menu yang dicentang

        DB::beginTransaction();
        try {
            // Detach semua menu yang ada saat ini untuk role ini dari tabel role_menu
            $role->menus()->detach(); 

            // Loop setiap menu_id yang dicentang di form
            foreach ($selectedMenuIds as $menuId) {
                $menu = Menu::find($menuId); // Dapatkan objek menu

                if ($menu) {
                    // Attach menu itu sendiri ke role_menu
                    // Laravel attach() akan mencegah duplikasi jika ada UNIQUE constraint di tabel pivot
                    $role->menus()->attach($menu->id); 

                    // --- BARIS INI YANG DIHAPUS / DIKOMENTARI ---
                    // if ($menu->parent_id) {
                    //     // Logika ini yang menambahkan parent menu secara otomatis
                    //     $role->menus()->attach($menu->parent_id);
                    // }
                    // --- AKHIR BARIS YANG DIHAPUS / DIKOMENTARI ---
                }
            }

            DB::commit(); // Commit transaksi
            return redirect()->back()->with('success', 'Akses menu berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback(); // Rollback jika ada kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}