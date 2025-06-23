<?php


use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Akuntansi\JurnalUmumController;
use App\Http\Controllers\Inventory\SupplierController;
use App\Http\Controllers\Keamanan\RoleController;
use App\Http\Controllers\Presensi\KaryawanController;
use App\Http\Controllers\Retur\ReturPenjualanController;
use App\Http\Controllers\Comprof\SettingMenuController;
use App\Http\Controllers\Presensi\DivisiController;
use App\Http\Controllers\Presensi\SubDivisiController;
use App\Http\Controllers\Presensi\PosisiController;
use App\Http\Controllers\Comprof\SubMenuController;
use App\Http\Controllers\Comprof\DataStafController;
use App\Http\Controllers\Inventory\KelompokprodukController;
use App\Http\Controllers\Inventory\SatuanprodukController;
use App\Http\Controllers\Inventory\DataprodukController;
use App\Http\Controllers\Akuntansi\BukuBesarController;
use App\Http\Controllers\Akuntansi\KasMasukController;
use App\Http\Controllers\Akuntansi\KasKeluarController;
use App\Http\Controllers\Keamanan\PermissionController;
use App\Http\Controllers\Keamanan\MemberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiGudang\WarehouseController;

use App\Http\Controllers\MutasiGudang\GudangOrderController;
use App\Http\Controllers\MutasiGudang\TransferGudangController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Login, Home, Profile */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');



Route::middleware(['auth','can.access.menu'])->group(function () { // Pastikan hanya user terautentikasi
        Route::prefix('keamanan')->name('keamanan.')->group(function () {

            Route::resource('roles', RoleController::class);

            // Route untuk Permission (URL: /keamanan/permission)
            Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
            

            // Route untuk Member (User) (URL: /keamanan/member)
            Route::get('member', [MemberController::class, 'index'])->name('member.index');
            Route::post('member', [MemberController::class, 'store'])->name('member.store');
            Route::get('member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
            Route::put('member/{id}', [MemberController::class, 'update'])->name('member.update');
            Route::delete('member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
            Route::get('member/search-employees', [MemberController::class, 'searchEmployees'])->name('member.searchEmployees');
            Route::get('member/get-role-menus-by-role/{roleId?}', [MemberController::class, 'getRoleMenusByRoleId'])->name('member.getRoleMenusByRoleId');
        });

    /* Data Retur */
    Route::prefix('retur')->name('retur.')->group(function () {
        // RETUR PENJUALAN
        Route::get('penjualan', [ReturPenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('penjualan/data', [ReturPenjualanController::class, 'dataJson'])->name('penjualan.data');
        Route::get('penjualan/create', [ReturPenjualanController::class, 'create'])->name('penjualan.create');
        Route::get('penjualan/{id}/edit', [ReturPenjualanController::class, 'edit'])->name('penjualan.edit');
        Route::put('penjualan/{id}', [ReturPenjualanController::class, 'updateHeader'])->name('penjualan.update');
        // DETAIL
        Route::get('penjualan/{id}/details', [ReturPenjualanController::class, 'detailsJson'])->name('penjualan.details.data');
        Route::post('penjualan/{id}/details', [ReturPenjualanController::class, 'storeDetail'])->name('penjualan.details.store');
        Route::put('penjualan/{id}/details/{detailId}', [ReturPenjualanController::class, 'updateDetail'])->name('penjualan.details.update');
        Route::delete('penjualan/{id}/details/{detailId}', [ReturPenjualanController::class, 'destroyDetail'])->name('penjualan.details.destroy');
        // DRAFT
        Route::delete('penjualan/{id}', [ReturPenjualanController::class, 'destroyHeader'])->name('penjualan.destroy');
        Route::put('penjualan/{id}/publish', [ReturPenjualanController::class, 'publish'])->name('penjualan.publish');
        Route::put('penjualan/{id}/publish-edit', [ReturPenjualanController::class, 'publishEdit'])->name('penjualan.publishEdit');
        // APPROVE
        Route::post('penjualan/approve-all', [ReturPenjualanController::class, 'approveAll'])->name('penjualan.approveAll');
        Route::post('penjualan/{id}/approve', [ReturPenjualanController::class, 'approve'])->name('penjualan.approve');
        // PRINT
        Route::get('penjualan/print-all', [ReturPenjualanController::class, 'printAll'])->name('penjualan.printAll');
        Route::get('penjualan/{id}/print', [ReturPenjualanController::class, 'print'])->name('penjualan.print');
    });


    // Company Profile routes group
    Route::prefix('comprof')->name('comprof.')->group(function () {
    // Setting Menu Routes
        Route::get('/settingmenu', [SettingMenuController::class, 'index'])->name('settingmenu.index');
        Route::post('/settingmenu', [SettingMenuController::class, 'store'])->name('settingmenu.store');
        Route::put('/settingmenu/{settingmenu}', [SettingMenuController::class, 'update'])->name('settingmenu.update');
        Route::delete('/settingmenu/{settingmenu}', [SettingMenuController::class, 'destroy'])->name('settingmenu.destroy');

        // Sub Menu Routes
        Route::get('/settingsubmenu', [SubMenuController::class, 'index'])->name('settingsubmenu.index');
        Route::post('/settingsubmenu', [SubMenuController::class, 'store'])->name('settingsubmenu.store');
        Route::put('/settingsubmenu/{submenu}', [SubMenuController::class, 'update'])->name('settingsubmenu.update');
        Route::delete('/settingsubmenu/{submenu}', [SubMenuController::class, 'destroy'])->name('settingsubmenu.destroy');

        // Data Staf
        Route::get('/datastaf', [DataStafController::class, 'index'])->name('datastaf.index');
        Route::post('/datastaf', [DataStafController::class, 'store'])->name('datastaf.store');
        Route::put('/datastaf/{datastaf}', [DataStafController::class, 'update'])->name('datastaf.update');
        Route::delete('/datastaf/{datastaf}', [DataStafController::class, 'destroy'])->name('datastaf.destroy');
 });

 // Data Presensi
    Route::prefix('presensi')->group(function(){
        // Data Karyawan Routes
        Route::get('/employee', [KaryawanController::class,'index'])->name('employee.index');
        Route::post('/employee', [KaryawanController::class,'store'])->name('employee.store');
        Route::get('/employee/{Employee}', [KaryawanController::class,'show'])->name('employee.show');
        Route::put('/employee/{Employee}', [KaryawanController::class,'update'])->name('employee.update');
        Route::delete('/employee/{Employee}', [KaryawanController::class,'destroy'])->name('employee.destroy');
        // Divisi Routes
        Route::get('/divisi', [DivisiController::class,'index'])->name('divisi.index');
        Route::post('/divisi', [DivisiController::class,'store'])->name('divisi.store');
        Route::get('/divisi/{Divisi}', [DivisiController::class,'show'])->name('divisi.show');
        Route::put('/divisi/{Divisi}', [DivisiController::class,'update'])->name('divisi.update');
        Route::delete('/divisi/{Divisi}', [DivisiController::class,'destroy'])->name('divisi.destroy');
        // Sub-Divisi Routes
        Route::get('/subdivisi', [SubDivisiController::class,'index'])->name('subdivisi.index');
        Route::post('/subdivisi', [SubDivisiController::class,'store'])->name('subdivisi.store');
        Route::get('/subdivisi/{SubDivisi}', [SubDivisiController::class,'show'])->name('subdivisi.show');
        Route::put('/subdivisi/{SubDivisi}', [SubDivisiController::class,'update'])->name('subdivisi.update');
        Route::delete('/subdivisi/{SubDivisi}', [SubDivisiController::class,'destroy'])->name('subdivisi.destroy');
        Route::get('/get-subdivisi/{Divisi}', [SubDivisiController::class, 'getByDivision'])->name('subdivisi.getByDivision');
        // Posisi Routes
        Route::get('/posisi', [PosisiController::class,'index'])->name('posisi.index');
        Route::post('/posisi', [PosisiController::class,'store'])->name('posisi.store');
        Route::get('/posisi/{Posisi}', [PosisiController::class,'show'])->name('posisi.show');
        Route::put('/posisi/{Posisi}', [PosisiController::class,'update'])->name('posisi.update');
        Route::delete('/posisi/{Posisi}', [PosisiController::class,'destroy'])->name('posisi.destroy');
    });

    // Route untuk gudang
    Route::prefix('mutasigudang')->group(function () {

    // Gudang
        Route::resource('warehouse', WarehouseController::class);

    // Optional JSON endpoint (untuk AJAX edit)
        Route::get('/{id}/json', [WarehouseController::class, 'json'])->name('json');

    // Gudang Order
        Route::resource('gudangorder', GudangOrderController::class);

    // Transfer Gudang
        Route::resource('transfergudang', TransferGudangController::class);

    });

    // Akuntansi routes
    Route::prefix('akunting')->group(function () {
    // Kode Akuntansi routes
        Route::get('/kodeakunting', [KodeAkuntingController::class, 'index'])->name('kodeakunting.index');
        Route::post('/kodeakunting', [KodeAkuntingController::class, 'store'])->name('kodeakunting.store');
        Route::get('/kodeakunting/{id}/edit', [KodeAkuntingController::class, 'edit'])->name('kodeakunting.edit');
        Route::put('/kodeakunting/{id}', [KodeAkuntingController::class, 'update'])->name('kodeakunting.update');
        Route::delete('/kodeakunting/{id}', [KodeAkuntingController::class, 'destroy'])->name('kodeakunting.destroy');
        Route::get('/kodeakunting/get-subclasses/{classId}', [KodeAkuntingController::class, 'getSubclassesByClass'])->name('kodeakunting.getSubclasses');
    // Jurnal Umum routes
        Route::resource('jurnal-umum', JurnalUmumController::class)->names('jurnalumum');
        // Tambahkan route AJAX helper jika perlu (seperti getNamaPerkiraan)
        Route::get('jurnal-umum/get-nama-perkiraan/{id}', [JurnalUmumController::class, 'getNamaPerkiraan'])->name('jurnalumum.getNamaPerkiraan');
        // Route untuk mendapatkan nomor jurnal baru via AJAX (opsional)
        Route::get('jurnal-umum/get-next-no', [JurnalUmumController::class, 'create'])->name('jurnalumum.getNextNo');

    // Buku Besar routes
        Route::get('/buku-besar', [BukuBesarController::class, 'index'])->name('bukubesar.index');
        Route::get('/buku-besar/pdf', [BukuBesarController::class, 'generatePDF'])->name('akunting.bukubesar.pdf');

    // Kas Masuk routes
        Route::resource('kas-masuk', KasMasukController::class);
    // Kas Keluar routes
        Route::resource('kas-keluar', KasKeluarController::class);


    });
   

    // Inventory routes
    Route::prefix('inventory')->group(function () {
        // Supplier routes
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        // Kelompok Produk routes
        Route::get('/kelompokproduk', [KelompokprodukController::class, 'index'])->name('kelompokproduk.index');
        Route::post('/kelompokproduk', [KelompokprodukController::class, 'store'])->name('kelompokproduk.store');
        Route::put('/kelompokproduk/{kelompokproduk}', [KelompokprodukController::class, 'update'])->name('kelompokproduk.update');
        Route::delete('/kelompokproduk/{kelompokproduk}', [KelompokprodukController::class, 'destroy'])->name('kelompokproduk.destroy');

        // Satuan Produk Routes
        Route::get('/satuanproduk', [SatuanprodukController::class, 'index'])->name('satuanproduk.index');
        Route::post('/satuanproduk', [SatuanprodukController::class, 'store'])->name('satuanproduk.store');
        Route::put('/satuanproduk/{satuanproduk}', [SatuanprodukController::class, 'update'])->name('satuanproduk.update');
        Route::delete('/satuanproduk/{satuanproduk}', [SatuanprodukController::class, 'destroy'])->name('satuanproduk.destroy');

        // Data Produk routes
        Route::get('/dataproduk', [DataprodukController::class, 'index'])->name('dataproduk.index');
        Route::post('/dataproduk', [DataprodukController::class, 'store'])->name('dataproduk.store');
        Route::put('/dataproduk/{dataproduk}', [DataprodukController::class, 'update'])->name('dataproduk.update');
        Route::delete('/dataproduk/{dataproduk}', [DataprodukController::class, 'destroy'])->name('dataproduk.destroy');
    });
});

//route yang tidak perlu acess menu
Route::middleware(['auth'])->group(function () {
    Route::prefix('keamanan')->name('keamanan.')->group(function () {
        Route::post('permission/update-menu-access', [PermissionController::class, 'updateMenuAccess'])->name('permission.updateMenuAccess');
        Route::get('member/search-employees', [MemberController::class, 'searchEmployees'])->name('member.searchEmployees');
        Route::get('member/get-role-menus-by-role/{roleId?}', [MemberController::class, 'getRoleMenusByRoleId'])->name('member.getRoleMenusByRoleId');
    });
});


 
 
