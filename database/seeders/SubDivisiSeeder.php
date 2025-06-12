<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubDivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ts_subdiv')->insert([

            [
                'div_auto'      => '0001',
                'div_divcode'   => '0001',
                'Div_Code'      => '001',
                'Div_Name'      => 'Direktur Utama',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0002',
                'div_divcode'   => '0001',
                'Div_Code'      => '002',
                'Div_Name'      => 'Direktur',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0003',
                'div_divcode'   => '0002',
                'Div_Code'      => '003',
                'Div_Name'      => 'Store',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0004',
                'div_divcode'   => '0003',
                'Div_Code'      => '004',
                'Div_Name'      => 'Keuangan',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0005',
                'div_divcode'   => '0004',
                'Div_Code'      => '005',
                'Div_Name'      => 'IT',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0006',
                'div_divcode'   => '0002',
                'Div_Code'      => '006',
                'Div_Name'      => 'Produksi',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0007',
                'div_divcode'   => '0002',
                'Div_Code'      => '007',
                'Div_Name'      => 'Kasir',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0008',
                'div_divcode'   => '0005',
                'Div_Code'      => '008',
                'Div_Name'      => 'Penjualan',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
            [
                'div_auto'      => '0009',
                'div_divcode'   => '0005',
                'Div_Code'      => '009',
                'Div_Name'      => 'Marketing',
                'Div_EntryID'   => '1',
                'Div_Entrydate' => now(),
            ],
        ]);
    }
}
