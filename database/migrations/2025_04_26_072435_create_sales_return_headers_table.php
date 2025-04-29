<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sales_return_headers', function (Blueprint $table) {
            $table->id('Trx_Auto');                                             // AUTO_INCREMENT primary key :contentReference[oaicite:7]{index=7}
            $table->string('Trx_SupCode', 20)->nullable();                      // varchar(20) DEFAULT NULL
            $table->string('Trx_WareCode', 20)->nullable();                     // varchar(20) DEFAULT NULL
            $table->string('trx_jurnal', 50)->nullable();                       // varchar(50) DEFAULT NULL
            $table->string('trx_sourcenum', 50)->nullable();                    // varchar(50) DEFAULT NULL
            $table->string('trx_number', 50)->nullable()->unique();             // varchar(50) DEFAULT NULL, UNIQUE :contentReference[oaicite:8]{index=8}
            $table->float('Trx_Discount', 5, 2)->default(0.00);                 // float(5,2) DEFAULT '0.00' :contentReference[oaicite:9]{index=9}
            $table->string('Trx_FakturNo', 30)->nullable();                     // varchar(30) DEFAULT NULL
            $table->date('Trx_Date')->nullable();                               // date DEFAULT NULL
            $table->date('Trx_FakturDate')->nullable();                         // date DEFAULT NULL
            $table->date('Trx_DueDate')->nullable();                            // date DEFAULT NULL
            $table->string('trx_curr', 10)->nullable();                         // varchar(10) DEFAULT NULL
            $table->decimal('Trx_GrossPrice', 18, 2)->default(0.00);            // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_NettPrice', 18, 2)->default(0.00);             // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_Taxes', 18, 2)->default(0.00);                 // decimal(18,2) DEFAULT '0.00'
            $table->decimal('Trx_TotDiscount', 18, 2)->default(0.00);           // decimal(18,2) DEFAULT '0.00'
            $table->string('trx_status', 30)->nullable();                       // varchar(30) DEFAULT NULL
            $table->text('Trx_Note')->nullable();                               // tinytext DEFAULT NULL
            $table->decimal('trx_payment', 18, 2)->default(0.00);               // decimal(18,2) DEFAULT '0.00'
            $table->char('trx_clear', 1)->default('F');                         // varchar(1) DEFAULT 'F'
            $table->char('trx_posting', 1)->default('F');                       // varchar(1) DEFAULT 'F'
            $table->integer('Trx_Print')->default(0);                           // int(11) DEFAULT '0'
            $table->decimal('Trx_BON', 18, 2)->default(0.00);                   // decimal(18,2) DEFAULT '0.00'
            $table->integer('trx_rev')->default(0);                             // int(8) DEFAULT '0'
            $table->string('Trx_MerchandiserID', 20)->nullable();               // varchar(20) DEFAULT NULL
            $table->string('Trx_UserID', 10)->nullable();                       // varchar(10) DEFAULT NULL
            $table->dateTime('Trx_LastUpdate')->nullable();                     // datetime DEFAULT NULL
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_return_headers');
    }
};
