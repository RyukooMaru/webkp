<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\keamanan\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Menu induk
        $keamanan = Menu::create([
            'name' => 'Keamanan',
            'slug' => 'keamanan',
            'url' => null,
            'icon' => 'fas fa-shield-alt',
            'order' => 1,
            'parent_id' => null,
        ]);

        // Submenu
        Menu::create([
            'name' => 'Roles',
            'slug' => 'keamanan.roles',
            'url' => '/keamanan/roles',
            'icon' => 'fas fa-user-tag',
            'order' => 1,
            'parent_id' => $keamanan->id,
        ]);

        Menu::create([
            'name' => 'Permission',
            'slug' => 'keamanan.permission',
            'url' => '/keamanan/permission',
            'icon' => 'fas fa-lock',
            'order' => 2,
            'parent_id' => $keamanan->id,
        ]);

        Menu::create([
            'name' => 'User',
            'slug' => 'keamanan.member',
            'url' => '/keamanan/member',
            'icon' => 'fas fa-lock',
            'order' => 3,
            'parent_id' => $keamanan->id,
        ]);
    }
}
