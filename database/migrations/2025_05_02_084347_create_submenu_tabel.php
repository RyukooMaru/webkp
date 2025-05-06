<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('submenu_tabel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->string('nama_submenu');
            $table->integer('urut');
            $table->string('tautan');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('menu_id')
                  ->references('id')
                  ->on('comprof_menus')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('submenu_tabel', function (Blueprint $table) {
            // Drop foreign key first to avoid errors
            $table->dropForeign(['menu_id']);
        });
        
        Schema::dropIfExists('submenu_tabel');
    }
};