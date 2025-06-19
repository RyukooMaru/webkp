<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use App\Models\keamanan\Karyawan; // Opsional: jika Anda ingin menggunakan model Eloquent

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan DB Facade untuk insert data
        DB::table('m_karyawan')->insert([
            [
                'Kar_ID' => 'KAR001',
                'Kar_Nama' => 'Budi Santoso',
                // Tambahkan kolom lain jika ada di tabel m_karyawan Anda
                // 'Kar_Alamat' => 'Jl. Merdeka No. 10',
                // 'Kar_Telepon' => '08123456789',
            ],
            [
                'Kar_ID' => 'KAR002',
                'Kar_Nama' => 'Siti Aminah',
            ],
            [
                'Kar_ID' => 'KAR003',
                'Kar_Nama' => 'Joko Susilo',
            ],
            [
                'Kar_ID' => 'KAR004',
                'Kar_Nama' => 'Dewi Lestari',
            ],
            [
                'Kar_ID' => 'KAR005',
                'Kar_Nama' => 'Agus Salim',
            ],
        ]);

        // Jika Anda memiliki model Karyawan dan ingin menggunakannya (pastikan fillable sudah diatur di model)
        // Karyawan::create(['Kar_ID' => 'KAR001', 'Kar_Nama' => 'Budi Santoso']);
        // Karyawan::create(['Kar_ID' => 'KAR002', 'Kar_Nama' => 'Siti Aminah']);
    }
}
