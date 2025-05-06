<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('m_uom', function (Blueprint $table) {
            $table->integer('UOM_Auto')->autoIncrement();
            $table->string('UOM_Code', 5)->unique();
            $table->decimal('UOM_Amount', 18, 2)->default(0.00);
            $table->string('UOM_EntryID', 10)->nullable();
            $table->dateTime('UOM_Entrydate');
            $table->string('UOM_UpdateID', 10)->nullable();
            $table->timestamp('UOM_LastUpdate')->useCurrent();
            
            $table->primary('UOM_Auto');
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_uom');
    }
};