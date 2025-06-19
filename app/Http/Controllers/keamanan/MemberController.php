<?php

namespace App\Http\Controllers\keamanan;

use App\Http\Controllers\Controller;
use App\Models\keamanan\RightAccess;
use App\Models\keamanan\Member;
use App\Models\keamanan\Role;
use App\Models\keamanan\Karyawan;
use App\Models\keamanan\RoleMenu; // Tetap diperlukan untuk mapping hak akses

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar member dan form untuk menambah/mengedit.
     */
    public function index(Request $request)
    {
        $members = Member::with('role')->get(); // Ambil semua member dengan eager loading role utama
        $roles = Role::all(); // Semua role untuk dropdown dan tabel hak akses

        // Data karyawan untuk dropdown
        $karyawans = Karyawan::all();

        // Variabel untuk mode edit
        $memberToEdit = null;
        // Inisialisasi hak akses yang disederhanakan untuk UI (key: role_id)
        $simplifiedAccesses = []; 
        foreach ($roles as $role) {
            $simplifiedAccesses[$role->id] = [
                'tambah' => '0', // Default 'F' atau '0'
                'ubah' => '0',
                'hapus' => '0',
            ];
        }

        // Cek jika ada parameter 'edit_id' di URL (dari redirect method edit)
        if ($request->has('edit_id')) {
            $memberToEdit = Member::with('role', 'rightAccesses.roleMenuCombination.role', 'rightAccesses.roleMenuCombination.menu')
                                ->find($request->input('edit_id'));
            
            if ($memberToEdit) {
                // Proses hak akses granular dari DB menjadi format yang disederhanakan untuk UI
                foreach ($memberToEdit->rightAccesses as $access) {
                    // Pastikan kombinasi role-menu dan role-nya ada
                    if ($access->roleMenuCombination && $access->roleMenuCombination->role) {
                        $roleId = $access->roleMenuCombination->role->id;
                        
                        // Set 'T'/'1' jika ada setidaknya satu hak akses yang 'T' untuk role tersebut
                        // Ini adalah logika "OR": jika salah satu submenu diizinkan, checkbox role-level dicentang
                        if ($access->AC_AD == 'T') $simplifiedAccesses[$roleId]['tambah'] = '1';
                        if ($access->AC_ED == 'T') $simplifiedAccesses[$roleId]['ubah'] = '1';
                        if ($access->AC_DE == 'T') $simplifiedAccesses[$roleId]['hapus'] = '1';
                    }
                }
            }
        }

        // Tidak perlu lagi $allRoleMenus karena pemfilteran di JS dihapus
        // dan tabel akses akan diisi berdasarkan $roles dan $simplifiedAccesses
        return view('keamanan.user.index', compact('members', 'roles', 'karyawans', 'memberToEdit', 'simplifiedAccesses'));
    }

    /**
     * Menyimpan member baru dan hak aksesnya.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Mem_ID' => 'required|string|max:10|unique:m_members,Mem_ID',
            'Mem_UserName' => 'required|string|max:50',
            'mem_password' => 'required|string|min:4|same:confirm_password',
            'Mem_ActiveYN' => 'required|in:Y,N',
            'role_id' => 'required|exists:roles,id', // Role utama
            'akses_role' => 'nullable|array', // Array hak akses dari UI yang disederhanakan (keyed by role_id)
            'akses_role.*.tambah' => 'nullable|in:1',
            'akses_role.*.ubah' => 'nullable|in:1',
            'akses_role.*.hapus' => 'nullable|in:1',
        ]);

        DB::beginTransaction(); // Memulai transaksi database
        try {
            // Simpan member baru
            $member = Member::create([
                'Mem_ID' => $request->Mem_ID,
                'Mem_UserName' => $request->Mem_UserName,
                'mem_password' => Hash::make($request->mem_password),
                'Mem_ActiveYN' => $request->Mem_ActiveYN,
                'role_id' => $request->role_id,
            ]);

            // Proses dan simpan hak akses granular
            if ($request->has('akses_role') && is_array($request->akses_role)) {
                // Iterate setiap role yang ada di form
                foreach ($request->akses_role as $roleId => $permissions) {
                    // Cek apakah role_id valid
                    $roleExists = Role::where('id', $roleId)->exists();
                    if (!$roleExists) {
                        continue;
                    }

                    // Dapatkan semua kombinasi role-menu untuk role_id ini
                    $roleMenusForThisRole = RoleMenu::where('role_id', $roleId)->get();

                    foreach ($roleMenusForThisRole as $rm) {
                        // Untuk setiap kombinasi role-menu, simpan hak aksesnya
                        RightAccess::updateOrCreate( // Menggunakan updateOrCreate untuk memastikan uniqueness
                            ['AC_USER' => $member->Mem_ID, 'AC_MAINMENU' => $rm->id],
                            [
                                'AC_AD' => isset($permissions['tambah']) && $permissions['tambah'] == '1' ? 'T' : 'F',
                                'AC_ED' => isset($permissions['ubah']) && $permissions['ubah'] == '1' ? 'T' : 'F',
                                'AC_DE' => isset($permissions['hapus']) && $permissions['hapus'] == '1' ? 'T' : 'F',
                                'AC_USERID' => auth()->user()->id ?? 'admin',
                                'AC_LASTUPDATE' => now(),
                            ]
                        );
                    }
                }
            }

            DB::commit(); // Commit transaksi
            return redirect()->back()->with('success', 'Pengguna dan hak akses berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaksi jika ada kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Redirect ke halaman index untuk menampilkan form edit.
     */
    public function edit($id)
    {
        return redirect()->route('keamanan.member.index', ['edit_id' => $id]);
    }

    /**
     * Memperbarui member dan hak aksesnya.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id); // Temukan member yang akan diupdate

        // Validasi input
        $request->validate([
            'Mem_UserName' => 'required|string|max:50',
            'Mem_ActiveYN' => 'required|in:Y,N',
            'role_id' => 'required|exists:roles,id',
            'mem_password' => 'nullable|string|min:4|same:confirm_password',
            'akses_role' => 'nullable|array', // Array hak akses dari UI yang disederhanakan
            'akses_role.*.tambah' => 'nullable|in:1',
            'akses_role.*.ubah' => 'nullable|in:1',
            'akses_role.*.hapus' => 'nullable|in:1',
        ]);

        DB::beginTransaction(); // Memulai transaksi database
        try {
            // Update data dasar member
            $member->Mem_UserName = $request->Mem_UserName;
            $member->Mem_ActiveYN = $request->Mem_ActiveYN;
            $member->role_id = $request->role_id;
            if ($request->filled('mem_password')) {
                $member->mem_password = Hash::make($request->mem_password);
            }
            $member->save();

            // Hapus semua hak akses lama untuk pengguna ini (opsional, bisa juga update langsung)
            // Menggunakan updateOrCreate akan lebih efisien jika sudah ada, tapi delete all then create is safer
            $member->rightAccesses()->delete();

            // Proses dan simpan hak akses granular yang baru
            if ($request->has('akses_role') && is_array($request->akses_role)) {
                foreach ($request->akses_role as $roleId => $permissions) {
                    $roleExists = Role::where('id', $roleId)->exists();
                    if (!$roleExists) {
                        continue;
                    }

                    // Dapatkan semua kombinasi role-menu untuk role_id ini
                    $roleMenusForThisRole = RoleMenu::where('role_id', $roleId)->get();

                    foreach ($roleMenusForThisRole as $rm) {
                        RightAccess::updateOrCreate( // Menggunakan updateOrCreate untuk memastikan uniqueness
                            ['AC_USER' => $member->Mem_ID, 'AC_MAINMENU' => $rm->id],
                            [
                                'AC_AD' => isset($permissions['tambah']) && $permissions['tambah'] == '1' ? 'T' : 'F',
                                'AC_ED' => isset($permissions['ubah']) && $permissions['ubah'] == '1' ? 'T' : 'F',
                                'AC_DE' => isset($permissions['hapus']) && $permissions['hapus'] == '1' ? 'T' : 'F',
                                'AC_USERID' => auth()->user()->id ?? 'admin',
                                'AC_LASTUPDATE' => now(),
                            ]
                        );
                    }
                }
            }

            DB::commit();
            return redirect()->route('keamanan.member.index')->with('success', 'Data member dan hak akses diperbarui.');
        } catch (\Exception | \Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus member dan hak aksesnya.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $member = Member::findOrFail($id);
            $member->rightAccesses()->delete(); // Hapus semua hak akses terkait
            $member->delete(); // Hapus member

            DB::commit();
            return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function searchEmployees(Request $request)
    {
        $search = $request->query('term'); // Ambil query pencarian
        $page = $request->query('page', 1); // Ambil nomor halaman untuk paginasi
        $perPage = 10; // Jumlah item per halaman

        $query = Karyawan::query();

        if ($search) {
            // Jika ada term pencarian, filter berdasarkan nama atau ID
            $query->where('Kar_Nama', 'LIKE', '%' . $search . '%')
                  ->orWhere('Kar_ID', 'LIKE', '%' . $search . '%');
        } else {
            // Jika tidak ada term pencarian, kembalikan semua karyawan (dengan paginasi)
            // Ini akan memungkinkan Select2 menampilkan daftar awal
        }

        // Terapkan paginasi pada query
        $employees = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];
        foreach ($employees->items() as $employee) {
            $results[] = [
                'id' => $employee->Kar_ID,
                'text' => $employee->Kar_Nama . ' (' . $employee->Kar_ID . ')',
            ];
        }

        // Select2 mengharapkan format respons dengan 'results' dan 'pagination.more'
        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $employees->hasMorePages()
            ]
        ]);
    }
}
