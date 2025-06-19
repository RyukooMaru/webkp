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
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        return view('home', compact('widget'));
    }
}
