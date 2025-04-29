<?php

namespace App\Http\Controllers\Comprof;

use App\Http\Controllers\Controller;
use App\Models\Comprof\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SettingMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('parent')
            ->orderBy('urutan')
            ->get();
            
        return view('comprof.settingmenu.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'slug' => [
                'required',
                'string',
                'max:100',
                'unique:comprof_menus',
                'alpha_dash'
            ],
            'route' => 'nullable|string|max:100',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'parent_id' => [
                'nullable',
                Rule::exists('comprof_menus', 'id')->where(function ($query) {
                    $query->whereNull('parent_id');
                })
            ]
        ]);

        // Auto-generate slug if empty
        $slug = $request->slug ?: Str::slug($request->nama_menu);
        
        // Prevent invalid parent assignment
        if ($request->parent_id && Menu::find($request->parent_id)->parent_id) {
            return redirect()->back()
                ->with('error', 'Cannot assign submenu to another submenu')
                ->withInput();
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'slug' => $slug,
            'route' => $request->route,
            'urutan' => $request->urutan,
            'status' => $request->status,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('comprof.settingmenu.index')
            ->with('Sukses', 'Menu Berhasil ditambahkan');
    }

    public function update(Request $request, Menu $settingmenu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'slug' => [
                'required',
                'string',
                'max:100',
                Rule::unique('comprof_menus')->ignore($settingmenu->id),
                'alpha_dash'
            ],
            'route' => 'nullable|string|max:100',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'parent_id' => [
                'nullable',
                Rule::exists('comprof_menus', 'id')->where(function ($query) use ($settingmenu) {
                    $query->whereNull('parent_id')
                          ->where('id', '!=', $settingmenu->id);
                })
            ]
        ]);

        // Prevent circular references
        if ($request->parent_id) {
            $parent = Menu::find($request->parent_id);
            if ($parent && $this->isDescendant($parent, $settingmenu)) {
                return redirect()->back()
                    ->with('Error', 'Cannot create circular menu reference')
                    ->withInput();
            }
        }

        $settingmenu->update([
            'nama_menu' => $request->nama_menu,
            'slug' => $request->slug,
            'route' => $request->route,
            'urutan' => $request->urutan,
            'status' => $request->status,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('comprof.settingmenu.index')
            ->with('success', 'Menu updated successfully');
    }

    public function destroy(Menu $settingmenu)
    {
        if ($settingmenu->children()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete menu with submenus');
        }

        $settingmenu->delete();

        return redirect()->route('comprof.settingmenu.index')
            ->with('success', 'Menu deleted successfully');
    }

    private function isDescendant($parent, $child)
    {
        if ($parent->id === $child->id) return true;
        
        foreach ($parent->children as $currentChild) {
            if ($this->isDescendant($currentChild, $child)) {
                return true;
            }
        }
        
        return false;
    }
}