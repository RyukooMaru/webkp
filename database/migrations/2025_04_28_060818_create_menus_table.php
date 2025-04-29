<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('comprof_menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu', 100);
            $table->string('slug', 100)->unique();
            $table->string('route', 100)->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('comprof_menus')
                  ->onDelete('cascade');

            // Indexes
            $table->index('nama_menu');
            $table->index('slug');
            $table->index('urutan');
            $table->index('status');
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comprof_menus');
    }
}