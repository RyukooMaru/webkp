<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThTransfergudangTable extends Migration
{
    public function up()
    {
        Schema::create('th_transfergudang', function (Blueprint $table) {
            $table->increments('Transfer_Auto');
            $table->string('Transfer_Number', 50)->unique();

            $table->string('Transfer_FromWarehouse', 20)->nullable();
            $table->string('Transfer_ToWarehouse', 20)->nullable();
            $table->date('Transfer_Date')->nullable();

            $table->string('Transfer_ByEmp', 20)->nullable();
            $table->string('Transfer_Note', 300)->nullable();

            $table->decimal('Transfer_GrossPrice', 18, 2)->default(0.00);
            $table->float('Transfer_Discount', 5, 2)->default(0.00);
            $table->decimal('Transfer_Taxes', 18, 2)->default(0.00);
            $table->decimal('Transfer_NettPrice', 18, 2)->default(0.00);

            $table->char('Transfer_Status', 1)->nullable(); // P, A, R
            $table->char('Transfer_FLAG', 1)->default('F');
            $table->char('Transfer_Cancel', 1)->default('F');

            $table->integer('Transfer_Print')->default(0);
            $table->integer('Transfer_Rev')->default(0);

            $table->string('Transfer_UpdateID', 10)->nullable();
            $table->dateTime('Transfer_LastUpdate')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('th_transfergudang');
    }
}

