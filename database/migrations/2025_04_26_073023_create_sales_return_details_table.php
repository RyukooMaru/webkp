<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sales_return_details', function (Blueprint $table) {
            $table->string('Trx_SupCode', 20)->nullable();                      // varchar(20) DEFAULT NULL
            $table->string('trx_number', 50)->nullable();                       // varchar(50) DEFAULT NULL
            $table->date('Trx_date')->nullable();                               // date DEFAULT NULL
            $table->string('Trx_ProdCode', 30)->nullable();                     // varchar(30) DEFAULT NULL
            $table->string('trx_prodname', 100)->nullable();                    // varchar(100) DEFAULT NULL
            $table->string('trx_uom', 10)->nullable();                          // varchar(10) DEFAULT NULL
            $table->string('trx_curr', 10)->nullable();                         // varchar(10) DEFAULT NULL
            $table->decimal('Trx_QtyTrx', 18, 2)->default(0.00);                // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_QtyReject', 18, 2)->default(0.00);             // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_QtyBonus', 18, 2)->default(0.00);              // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_QtyBayar', 18, 2)->default(0.00);              // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_GrossPrice', 18, 2)->default(0.00);            // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_NettPrice', 18, 2)->default(0.00);             // decimal(18,2) DEFAULT '0.00'
            $table->float('Trx_Discount', 5, 2)->default(0.00);                 // float(5,2) DEFAULT '0.00'
            $table->float('Trx_Taxes', 5, 2)->default(0.00);                    // float(5,2) DEFAULT '0.00'
            $table->decimal('trx_cogs', 18, 2)->nullable();                     // decimal(18,2) DEFAULT NULL
            $table->integer('trx_rev')->default(0);                             // int(8) DEFAULT '0'
            $table->char('trx_posting', 1)->default('F');                       // varchar(1) DEFAULT 'F'
            $table->text('Trx_Note')->nullable();                               // tinytext
            $table->string('Trx_UpdateID', 10)->nullable();                     // varchar(10) DEFAULT NULL
            $table->dateTime('Trx_LastUpdate')->nullable();                     // datetime DEFAULT NULL
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_return_details');
    }
};
