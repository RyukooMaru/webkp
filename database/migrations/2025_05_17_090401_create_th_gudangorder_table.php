<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThGudangorderTable extends Migration
{
    public function up()
    {
        Schema::create('th_gudangorder', function (Blueprint $table) {
            $table->increments('Pur_Auto');
            $table->string('Pur_SupCode', 30)->nullable();
            $table->string('pur_ordernumber', 50)->unique()->nullable();
            $table->string('pur_warehouse', 20)->nullable();
            $table->string('pur_emp', 20)->nullable();
            $table->date('Pur_Date')->nullable();

            $table->float('Pur_Discount', 5, 2)->default(0.00);
            $table->decimal('Pur_GrossPrice', 18, 2)->default(0.00);
            $table->decimal('Pur_NettPrice', 18, 2)->default(0.00);
            $table->decimal('Pur_Taxes', 18, 2)->default(0.00);
            $table->decimal('Pur_TotDiscount', 18, 2)->default(0.00);

            $table->string('Pur_Group', 20)->nullable();
            $table->string('Pur_Note', 300)->nullable();
            $table->char('Pur_Cancel', 1)->default('F');
            $table->char('pur_status', 1)->nullable();
            $table->char('Pur_FLAG', 1)->default('F');

            $table->integer('Pur_Print')->default(0);
            $table->integer('pur_rev')->default(0);
            $table->string('Pur_UpdateID', 10)->nullable();
            $table->dateTime('Pur_LastUpdate')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('th_gudangorder');
    }
}
