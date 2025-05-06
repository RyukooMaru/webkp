<?php

namespace App\Http\Controllers\Comprof;

use App\Http\Controllers\Controller;
use App\Models\Comprof\Menu;
use App\Models\Comprof\Submenu;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{
    /**
     * Menampilkan daftar submenu.
     */
    public function index()
    {
        $submenus = Submenu::with('menu')->orderBy('urut')->get();
        $menus = Menu::all();

        return view('comprof.submenu.index', compact('submenus', 'menus'));
    }

    /**
     * Menyimpan submenu baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id'       => 'required|exists:menu_tabel,id',
            'nama_submenu'  => 'required|string|max:255',
            'urut'          => 'required|integer',
            'tautan'        => 'required|string|max:255',
            'status'        => 'required|boolean',
        ]);

        Submenu::create($request->all());

        return redirect()->route('comprof.settingsubmenu.index')
                         ->with('success', 'Sub menu berhasil ditambahkan');
    }

    /**
     * Memperbarui data submenu.
     */
    public function update(Request $request, Submenu $settingsubmenu)
    {
        $request->validate([
            'menu_id'       => 'required|exists:menu_tabel,id',
            'nama_submenu'  => 'required|string|max:255',
            'urut'          => 'required|integer',
            'tautan'        => 'required|string|max:255',
            'status'        => 'required|boolean',
        ]);

        $settingsubmenu->update($request->all());

        return redirect()->route('comprof.settingsubmenu.index')
                         ->with('success', 'Sub menu berhasil diperbarui');
    }

    /**
     * Menghapus submenu.
     */
    public function destroy(Submenu $settingsubmenu)
    {
        $settingsubmenu->delete();

        return redirect()->route('comprof.settingsubmenu.index')
                         ->with('success', 'Sub menu berhasil dihapus');
    }
}
