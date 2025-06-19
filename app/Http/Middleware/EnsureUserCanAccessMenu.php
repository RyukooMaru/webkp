<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // Import Gate Facade
use Illuminate\Support\Str; // Import Str Helper

class EnsureUserCanAccessMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate->Http->Request  $request
     * @param  \Closure(\Illuminate->Http->Request): (\Illuminate->Http->Response|\Illuminate->Http->RedirectResponse)  $next
     * @return \Illuminate->Http\Response|\Illuminate->Http->RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect ke login jika belum login
        }

        // Dapatkan nama rute saat ini
        $routeName = $request->route()->getName();

        // Jika rute tidak memiliki nama, biarkan saja (atau tangani sesuai kebutuhan)
        if (is_null($routeName)) {
            return $next($request);
        }

        // Derivasi menu slug dari nama rute (misal: 'keamanan.member.index' menjadi 'keamanan.member')
        // Ini akan cocok dengan kolom 'slug' di tabel 'menus' Anda.
        $menuSlug = Str::beforeLast($routeName, '.'); // Contoh: 'keamanan.member.index' -> 'keamanan.member'
                                                      // Jika route sudah root slug: 'home' -> 'home'
        // Tangani kasus route root (misal 'home') jika slug di DB adalah 'home'
        if (empty($menuSlug) && $routeName === 'home') {
            $menuSlug = 'dashboard'; // Asumsi slug untuk Dashboard adalah 'dashboard'
        } elseif (empty($menuSlug)) {
            $menuSlug = $routeName; // Jika tidak ada titik, slug adalah nama rute itu sendiri
        }

        // DEBUGGING: Tambahkan ini untuk melihat slug yang terdeteksi
        // dd("Checking menu slug: {$menuSlug} for route: {$routeName}");

        // Periksa Gate 'access_menu'
        // Gate akan memeriksa apakah role pengguna memiliki menu dengan slug ini
        if (!Gate::allows('access_menu', $menuSlug)) {
            // Jika tidak memiliki akses, arahkan ke halaman 403 atau kembali dengan error
            // Anda bisa membuat view kustom untuk halaman 403 (akses ditolak)
            // return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.'); // Redirect ke home dengan pesan error
        }

        return $next($request);
    }
}