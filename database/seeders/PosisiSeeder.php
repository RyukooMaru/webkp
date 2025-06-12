<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ts_position')->insert([

            [
                'pos_auto'      => '0001',
                'Pos_Code'   => 'SA',
                'Pos_Name'      => 'Sales Asistant',
            ],
            [
                'pos_auto'      => '0002',
                'Pos_Code'   => 'SPV',
                'Pos_Name'      => 'Supervisor',
            ],
            [
                'pos_auto'      => '0003',
                'Pos_Code'   => 'ST',
                'Pos_Name'      => 'Staff',
            ],
            [
                'pos_auto'      => '0004',
                'Pos_Code'   => 'MGR',
                'Pos_Name'      => 'Manager',
            ],
            [
                'pos_auto'      => '0005',
                'Pos_Code'   => 'ASS',
                'Pos_Name'      => 'Asst. Manager',
            ],
            [
                'pos_auto'      => '0006',
                'Pos_Code'   => 'SCO',
                'Pos_Name'      => 'Staff Counter',
            ],
        ]);
    }
}
