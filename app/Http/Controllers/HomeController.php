<?php

namespace App\Http\Controllers;

use App\Models\keamanan\Member; // Pastikan model Member di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan Auth facade di-import

class HomeController extends Controller
{
    /**
     * Membuat instance controller baru.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan dashboard aplikasi.
     */
    public function index()
    {
        // Mendapatkan objek Member yang sedang login
        // eager load relasi 'role' dan kemudian relasi 'menus' dari 'role'
        $loggedInMember = Auth::user()->load('role.menus'); 

        $totalMembers = Member::count();

        $widget = [
            'members' => $totalMembers,
            // Tambahkan widget lain jika ada
        ];

        // Melewatkan data yang sudah dimuat ke view. 
        // Meskipun Auth::user() bisa diakses global, load() di sini memastikan relasi sudah ada.
        return view('home', compact('widget', 'loggedInMember')); 
    }
}