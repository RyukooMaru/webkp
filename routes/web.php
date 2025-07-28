<?php
use App\Http\Controllers\DataKaryawan\DivisiController;
use App\Http\Controllers\Akuntansi\KodeAkuntingController;
use App\Http\Controllers\Comprof\SettingMenuController;
use App\Http\Controllers\Comprof\SubMenuController;
use App\Http\Controllers\Comprof\DataStafController;
use App\Http\Controllers\Comprof\SliderController;
use App\Http\Controllers\Comprof\SetPerusahaanController;
use App\Http\Controllers\Comprof\KategoriBeritaController;
use App\Http\Controllers\Comprof\KategoriAlbumController;
use App\Http\Controllers\Comprof\WebsiteContentController;
use App\Http\Controllers\Comprof\BeritaController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController;
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

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/careers', [PageController::class, 'show'])->name('careers');
// Gallery Routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');
// News Routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/category/{id}', [NewsController::class, 'category'])->name('news.category');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
// Dynamic Pages from Website Content
Route::get('/page/{id}', [PageController::class, 'show'])->name('page.show');
Route::get('/submenu/{submenuId}', [PageController::class, 'showBySubmenu'])->name('page.by.submenu');

/* Auth Routes */
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Auth::routes();

/* Dashboard Route */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

/* Profile Routes */
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

/* Data Karyawan */
Route::resource('data-karyawan', DivisiController::class)
    ->parameters(['data-karyawan' => 'ts_div']);

/* Akuntansi Routes */
Route::prefix('akunting')->group(function () {
    // Kode Akuntansi routes
    Route::get('/kodeakunting', [KodeAkuntingController::class, 'index'])->name('kodeakunting.index');
    Route::post('/kodeakunting', [KodeAkuntingController::class, 'store'])->name('kodeakunting.store');
    Route::get('/kodeakunting/{id}/edit', [KodeAkuntingController::class, 'edit'])->name('kodeakunting.edit');
    Route::put('/kodeakunting/{id}', [KodeAkuntingController::class, 'update'])->name('kodeakunting.update');
    Route::delete('/kodeakunting/{id}', [KodeAkuntingController::class, 'destroy'])->name('kodeakunting.destroy');
    Route::get('/kodeakunting/get-subclasses/{classId}', [KodeAkuntingController::class, 'getSubclassesByClass'])->name('kodeakunting.getSubclasses');
});

/* Company Profile Routes */
Route::prefix('comprof')->name('comprof.')->middleware('web')->group(function () {
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

    // Data Staf Routes
    Route::get('/datastaf', [DataStafController::class, 'index'])->name('datastaf.index');
    Route::post('/datastaf', [DataStafController::class, 'store'])->name('datastaf.store');
    Route::put('/datastaf/{datastaf}', [DataStafController::class, 'update'])->name('datastaf.update');
    Route::delete('/datastaf/{datastaf}', [DataStafController::class, 'destroy'])->name('datastaf.destroy');
    
     // Slider Routes
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::put('/slider/{slider}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::post('/slider/upload-image', [SliderController::class, 'uploadImage'])->name('slider.upload-image');

    // Set Perusahaan Routes
    Route::get('/setperusahaan', [SetPerusahaanController::class, 'index'])->name('setperusahaan.index');
    Route::post('/setperusahaan', [SetPerusahaanController::class, 'store'])->name('setperusahaan.store');
    Route::post('/setperusahaan/upload-image', [SetPerusahaanController::class, 'uploadImage'])->name('setperusahaan.upload-image');

    // Kategori Berita Routes
    Route::get('/kategoriberita', [KategoriBeritaController::class, 'index'])->name('kategoriberita.index');
    Route::post('/kategoriberita', [KategoriBeritaController::class, 'store'])->name('kategoriberita.store');
    Route::put('/kategoriberita/{kategoriberita}', [KategoriBeritaController::class, 'update'])->name('kategoriberita.update');
    Route::delete('/kategoriberita/{kategoriberita}', [KategoriBeritaController::class, 'destroy'])->name('kategoriberita.destroy');

    // Kategori Album Routes
    Route::get('/kategorialbum', [KategoriAlbumController::class, 'index'])->name('kategorialbum.index');
    Route::post('/kategorialbum', [KategoriAlbumController::class, 'store'])->name('kategorialbum.store');
    Route::put('/kategorialbum/{kategorialbum}', [KategoriAlbumController::class, 'update'])->name('kategorialbum.update');
    Route::delete('/kategorialbum/{kategorialbum}', [KategoriAlbumController::class, 'destroy'])->name('kategorialbum.destroy');

    // Website Content Routes
    Route::get('/websitecontent', [WebsiteContentController::class, 'index'])->name('websitecontent.index');
    Route::post('/websitecontent', [WebsiteContentController::class, 'store'])->name('websitecontent.store');
    Route::put('/websitecontent/{id}', [WebsiteContentController::class, 'update'])->name('websitecontent.update');
    Route::delete('/websitecontent/{id}', [WebsiteContentController::class, 'destroy'])->name('websitecontent.destroy');
    Route::post('/websitecontent/upload-image', [WebsiteContentController::class, 'uploadImage'])->name('websitecontent.upload-image');

    // Berita Routes
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
});

/* Inventory Routes */
Route::prefix('inventory')->group(function () {
    // Daftar Supplier routes
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});