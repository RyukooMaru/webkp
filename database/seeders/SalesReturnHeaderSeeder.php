<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SalesReturnHeaderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('sales_return_headers')->insert([
                'Trx_SupCode'        => substr($faker->company(), 0, 20),            // varchar(20)
                'Trx_WareCode'       => substr($faker->randomElement(['WH-A', 'WH-B', 'WH-C']), 0, 20),
                'trx_jurnal'         => substr((string) Str::uuid(), 0, 50),         // varchar(50)
                'trx_sourcenum'      => substr($faker->bothify('INV-#####'), 0, 50), // varchar(50)
                'trx_number'         => substr($faker->unique()->bothify('RTJ-#####'), 0, 50), // varchar(50) unique
                'Trx_Discount'       => $faker->randomFloat(2, 0, 100),              // float(5,2)
                'Trx_FakturNo'       => substr($faker->bothify('FTR-#####'), 0, 30), // varchar(30)
                'Trx_Date'           => $faker->date(),                              // date
                'Trx_FakturDate'     => $faker->date(),                              // date
                'Trx_DueDate'        => $faker->date(),                              // date
                'trx_curr'           => substr($faker->currencyCode(), 0, 10),       // varchar(10)
                'Trx_GrossPrice'     => $faker->randomFloat(2, 1000, 10000),         // decimal(18,2)
                'Trx_NettPrice'      => $faker->randomFloat(2, 500, 9000),           // decimal(18,2)
                'Trx_Taxes'          => $faker->randomFloat(2, 0, 1000),             // decimal(18,2)
                'Trx_TotDiscount'    => $faker->randomFloat(2, 0, 500),              // decimal(18,2)
                'trx_status'         => substr($faker->randomElement(['Pending', 'Approved', 'Cancelled']), 0, 30),
                'Trx_Note'           => substr($faker->sentence(), 0, 255),          // tinytext
                'trx_payment'        => $faker->randomFloat(2, 0, 5000),             // decimal(18,2)
                'trx_clear'          => $faker->randomElement(['T', 'F']),            // char(1)
                'trx_posting'        => $faker->randomElement(['T', 'F']),            // char(1)
                'Trx_Print'          => $faker->numberBetween(0, 5),                 // int
                'Trx_BON'            => $faker->randomFloat(2, 0, 100),              // decimal(18,2)
                'trx_rev'            => $faker->numberBetween(0, 3),                 // int
                'Trx_MerchandiserID' => substr($faker->bothify('MRC-###'), 0, 20),    // varchar(20)
                'Trx_UserID'         => substr($faker->userName(), 0, 10),            // varchar(10)
                'Trx_LastUpdate'     => now(),                                       // datetime
            ]);
        }
    }
}
