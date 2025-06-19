<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Keamanan\RoleController;
use App\Http\Controllers\Keamanan\PermissionController;
use App\Http\Controllers\Keamanan\MemberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


/* Data Karyawan */
Route::resource('data-karyawan', DivisiController::class)
    ->parameters(['data-karyawan' => 'ts_div']);


// --- Grup Route Keamanan yang Dilindungi ---
    // Tambahkan middleware 'can.access.menu' di sini.
    // Middleware ini akan berjalan SETELAH 'auth' dan akan memeriksa izin akses menu.
    Route::prefix('keamanan')->name('keamanan.')->middleware(['auth', 'can.access.menu'])->group(function () {
        
        // Route untuk Role (URL: /keamanan/roles)
        Route::resource('roles', RoleController::class);

        // Route untuk Permission (URL: /keamanan/permission)
        Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('permission/update-menu-access', [PermissionController::class, 'updateMenuAccess'])->name('permission.updateMenuAccess');

        // Route untuk Member (User) (URL: /keamanan/member)
        Route::get('member', [MemberController::class, 'index'])->name('member.index');
        Route::post('member', [MemberController::class, 'store'])->name('member.store');
        Route::get('member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
        Route::put('member/{id}', [MemberController::class, 'update'])->name('member.update');
        Route::delete('member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
        Route::get('member/search-employees', [MemberController::class, 'searchEmployees'])->name('member.searchEmployees');
        Route::get('member/get-role-menus-by-role/{roleId?}', [MemberController::class, 'getRoleMenusByRoleId'])->name('member.getRoleMenusByRoleId');
    });
